<?php


namespace App\Dtos;


class TokenData {
    protected $token_type;
    protected $expires_in;
    protected $access_token;


    public function __construct($params) {
        foreach ($params as $name => $value) {

            if ( property_exists( $this, $name ) ) {
                $this->{$name} = $value;
            }
        }
    }

    public  function getData() {
        return $this->access_token ? get_object_vars($this) : [];
    }


    public  function getResponseJson() {
        return json_encode( $this->getAllData());
    }


    public function __toString() {
        return $this->getResponseJson();
    }

}
