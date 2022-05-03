<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller {

    protected function index() {
        $posts = Post::all();
        return response()->json($posts);
    }


    protected function addPost(Request $request) {
        try {
            $post = new Post();
            $post->userId = $request->userId;
            $post->title = $request->title;
            $post->body = $request->body;
            $post->domaine = $request->domaine;
        
            // check if the image is uploaded and if it is, change the name of the image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = uniqid('pImage_') . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $post->image = $imageName;
            } else {
                $post->image = null;
            }
    
            $result =  $post->save();
            if ($result) {
                return response()->json(['status' => 'success', 'message' => 'Post added successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Error adding post']);
            }

        } catch(QueryException $e) {
            // return response()->json(['error' => $e->getMessage()], 500);
        }



        
        

    
    }
}
