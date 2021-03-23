<?php


namespace Modules\Blog\Transformers;


use Modules\Blog\Entities\Article;
use League\Fractal;

class ArticleTransformer extends Fractal\TransformerAbstract
{
    public function transform(Article $article)
    {
        return [
            'id'      => (int) $article->id,
            'title'   => (string) $article->title,
            'content'   => (string) $article->content,
            'image'    => (string) $article->image,
            'description'    => (string) $article->description,
            'created_at'    =>  $article->created_at,
            'updated_at'    => $article->updated_at,

        ];
    }
}
