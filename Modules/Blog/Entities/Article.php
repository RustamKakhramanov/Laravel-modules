<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Transformers\ArticleTransformer;
use Spatie\Fractal\Fractal;

class Article extends Model
{
    use HasFactory;

    const IMAGES_PATH = 'app/public/articles/images';

    protected $fillable = ['title', 'description', 'image', 'content'];

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\ArticleFactory::new();
    }

    public function toFractalJson($status = 200) {
        return Fractal::create($this)
            ->transformWith(new ArticleTransformer())
            ->respond($status);
    }

    public function writeImage($file) {
        $destinationPath = storage_path( self::IMAGES_PATH );
        $fileName = time() . '.'.$file->clientExtension();
        $file->move( $destinationPath, $fileName );

        $this->save();
    }
}
