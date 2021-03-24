<?php


namespace App\Services;


use App\Models\User;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use App\Dtos\TokenData;

class TokenService {
    const TOKEN_BEARER_TYPE = "Bearer";
    const DEFAULT_EXPIRE = 1;


//    public function __construct(User $user, $expire_day = self::DEFAULT_EXPIRE, $type = self::TOKEN_BEARER_TYPE ) {
//        $this->user = $user;
//
//    }

    public static function generate( User $user, $expire_day = self::DEFAULT_EXPIRE, $type = self::TOKEN_BEARER_TYPE ) {
        Passport::personalAccessTokensExpireIn(Carbon::now()->addDays($expire_day));

        $token = $user->createToken('API Access');


        return new TokenData([
            "token_type" => $type,
            "expires_in" => $token->token->expires_at->diffInSeconds(Carbon::now()),
            "access_token" => $token,
            "refresh_token" => $token
        ]);
    }




}
