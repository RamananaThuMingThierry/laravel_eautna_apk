<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function likeOrDislike($id){

        $user = auth()->user();
        $post = Post::find($id);

        if($user){
            if($post){

                $like = $post->likes()->where('users_id', auth()->user()->id)->first();
    
                     // if not liked the like
                if(!$like){
    
                    Likes::create([
                        'post_id' => $post->id,
                        'users_id' => auth()->user()->id
                    ]);
    
                    return response()->json([
                        'message' => $this->constantes['Like']
                    ], 200);
                }else{
    
                    // else dislike it
                $like->delete();
    
                return response()->json([
                    'message' => $this->constantes['DisLike']
                ], 200);
    
                }
            }else{
                return response()->json([
                    'message' => 'Post '.$this->constantes['NExistePasDansBD']
                ], 404);
            }
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }
}
