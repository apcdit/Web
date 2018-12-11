<?php

namespace App\Http\Controllers;

use App\Posts;
use http\Env\Response;
use Illuminate\Http\Request;
//use App\Http\Requests;
use function MongoDB\BSON\toJSON;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Posts::all();

        return response($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create a new posts receiving all the requests
        return response($request->all());
        $posts = new Posts();

        return response($posts->create($request->all()));

        //return response()->json($posts,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //show the post with the id
        $posts = Posts::find($id);

        return response($posts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $posts = Posts::find($id);
        $posts->update($request->all()); //update using the new data
        return response(Posts::find($id),200);
    }

    public function showLatest(){
        
        Cache::remember('latestPosts', 60, function () {
            $posts = Posts::orderBy('created_at','desc')->take(3)->get();
            return $posts;
        });
        return response(Cache::get('latestPosts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $posts = new Posts();

        if($posts->find($id)){
            Posts::destroy('id',$id);
            return response('Successfully deleted!',204);
        }else{
            return response('Post not found!',204);
        }

    }
}
