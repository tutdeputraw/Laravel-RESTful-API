<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::listen(function ($query) {
        //     var_dump($query->sql);
        // });

        $data = Post::with(['user', 'comments'])->paginate(5);

        return new PostCollection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => ['required'],
            'title' => ['required', 'min:5'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Post::create($data);

        return response()->json(['message' => 'success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, $id)
    {
        $data = $post::find($id);

        if (is_null($data)) {
            return response()->json(['message' => "id {$id} not found"], 404);
        }

        return new PostResource($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $id = $request->id;
        $data = $post->find($id);

        if (is_null($data)) {
            return response()->json(['message' => "id {$id} not found"], 404);
        }

        $data->update($request->all());

        return response()->json([
            'message' => "success"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        $id = $request->id;
        $data = $post->find($id);

        if (is_null($data)) {
            return response()->json(['message' => "id {$request->id} not found"], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
