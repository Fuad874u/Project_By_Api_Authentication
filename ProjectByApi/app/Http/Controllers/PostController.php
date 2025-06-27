<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        // return Post::all();

        // return PostResource::collection($posts);

        return response()->json([
            'data' => PostResource::collection($posts),
            'message' => 'success',
            'status' => 200 
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|string|max:255',
        //     'body' => 'required',
        // ]);

        // if($validator->fails()){
        //     // return $validator->errors();
        //     return response()->json([
        //         'errors' => $validator->errors(),
        //         'message' => 'Validation Error',
        //         'status' => 422
        //     ], 422);
        // }

        $data = $request->validated();

        $post = Post::create($data);

        // $post = Post::create([
        //     'title' => $request->title,
        //     'body' => $request->body
        // ]);

        // return $post;

        // return new PostResource($post);

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Post Created Successfully',
            'status' => 201 
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);

        if(!$post){
            // return "Post not found";
            return response()->json([
                'message' => 'Post not found',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'success',
            'status' => 200 
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $post = Post::find($id);

        if(!$post){
            // return "Post not found";
            return response()->json([
                'message' => 'Post not found',
                'status' => 404
            ], 404);
        }


        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|string|max:255',
        //     'body' => 'required',
        // ]);

        // if($validator->fails()){
        //     // return $validator->errors();
        //     return response()->json([
        //         'errors' => $validator->errors(),
        //         'message' => 'Validation Error',
        //         'status' => 422
        //     ], 422);
        // }

        $data = $request->validated();

        $post->update($data);

        // $post->update([
        //     'title' => $request->title,
        //     'body' => $request->body
        // ]);

        // return $post;
        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Post Updated Successfully',
            'status' => 200 
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if(!$post){
            // return "Post is not found";
            return response()->json([
                'message' => 'Post is not found',
                'status' => 404
            ], 404);
        }

        $post->delete();

        // return "Post deleted";
        return response()->json([
                'message' => 'Post deleted Successfully',
                'status' => 200
            ], 200);
    }
}
