<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Entities\Article;
use Modules\Blog\Transformers\ArticleTransformer;
use Spatie\Fractal\Fractal;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return string
     */
    public function list()
    {
        $paginator = Article::where('user_id', Auth::id())->paginate();
        $articles = $paginator->getCollection();


        return Fractal::create()
            ->collection($articles, new ArticleTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toJson();

    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|string|max:255',
        ]);


        $article = Article::create([
            'firstname' => $request->input('firstname'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),

        ]);

        if( $request->hasFile( 'image' ) ) {
            $article->writeImage($request->image);
        }



        return $article->toFractalJson(201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return string
     */
    public function show(int $id)
    {

        return Article::find($id)->toFractalJson();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|string|max:255',
        ]);


        if ( !$article = Article::find($id) ) {
            return response('Article not found', 400);
        }

        $article->update($request->all());

        return $article->toFractalJson();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return string
     */
    public function delete($id)
    {
        if ( !$article = Article::find($id) ) {
            return response('Article not found', 400);
        }

        $article->delete();

        return response('', 200);
    }
}
