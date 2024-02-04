<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    // Récupérer tous les posts

    public function index(){

        $user = auth()->user();

        if($user){
            $posts = Post::orderBy('created_at', 'desc')
            ->with('images')
            ->with('users:id,pseudo,image')
            ->withCount('commentaires', 'likes')
            ->with('likes', function($like){
                return $like->where('users_id', auth()->user()->id)
                ->select('id','users_id','post_id')->get(); 
            })
            ->get();
            
            return response()->json([
                'posts' => $posts 
            ], 200);
        }else{
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    // Afficher un post
    public function show($id){
        
        $user = auth()->user();

        if($user){
            $verifier_post = Post::find($id);

            if($verifier_post){
                $post = Post::where('id', $id)->with('users:id,pseudo,contact,adresse,image')->withCount('commentaires', 'likes')->get();
    
                return response()->json([
                    'post' => $post
                ], 200);
    
            }else{
                return response()->json([
                    'message' => 'Post '. $this->constantes['NExistePasDansBD']
                ], 404);
            }

        }else{
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    // créer un post
    public function store(Request $request){
        
        $users = auth()->user();
        $description = $request->description;

        if($users){

            if($users->status){

                $validator = Validator::make($request->all(), [
                    'description' => 'required|string',
                    'images.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048', // Adaptez les extensions et la taille selon vos besoins.
                ]);  
                
                if($validator->fails()){
                            
                    return response()->json([
                        'errors' => $validator->messages(),
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        
                }else{

                    $post = Post::create([
                        'description' => $description,
                        'users_id' => auth()->user()->id,
                    ]);
                     
                    // if($request->hasFile('images')) {
                    //     foreach ($request->file('images') as $img) {
                    //         $filename = time() . '_' . $img->getClientOriginalName();
                    //         Storage::disk('posts')->put($filename, file_get_contents($img));
                    //         $path = URL::to('/').'/storage/posts/'.$filename;
                    //         $post->images()->create(['image_path' => $path]);
                    //     }
                    // }
                    

                    // foreach ($request->file('images') as $image) {
                    //     $path = $image->store('posts', 'public'); // 'public' est le disk par défaut
                    //     $imagesPaths[] = $path;
                    //     $post->images()->create(['image_path' => $path]);
                    // }

                    if($request->file('images')){
                        foreach ($request->file('images') as $img) {
                            $filename = time() . '_' . uniqid() . '_' . $img->getClientOriginalName();
                            Storage::disk('posts')->put($filename, file_get_contents($img));
                            $path = URL::to('/').'/storage/posts/'.$filename;
                            $post->images()->create(['image_path' => $path]);
                        }
                    }
                    // foreach ($request->file('images') as $image) {
                    //     $timestamp = time();
                    //     $filename = $timestamp . '.' . $image->getClientOriginalExtension();
                    //     $path = $image->storeAs('posts', $filename, 'public'); // 'public' est le disk par défaut
                    //     $post->images()->create(['image_path' => $path]);
                    // }

                    return response()->json([
                        'message' => 'Post '. $this->constantes['Creation'],
                        'post' => $post
                    ], 200);
                }

            }else{

                return response()->json([
                    'message' =>  $this->constantes['Permission']
                ], 403);

            }

        }else{
            
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
            ], 401);

        }
    }
    
    // update a post
    public function update(Request $request, $id){
        
        $autorisation = false;
        $users = auth()->user();

        $description = $request->description;

        if($users){
           
            $post = Post::find($id);

            if($post){
    
                if($users->roles == "Administrateurs"){
                    $autorisation = true;
                }else if($post->user_id == auth()->user()->id){
                    $autorisation = true;
                }   

                if($autorisation){

                    $validator = Validator::make($request->all(), [
                        'description' => 'required|string',
                    ]);  
                    
                    
                    if($validator->fails()){
                                
                        return response()->json([
                            'errors' => $validator->messages(),
                        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            
                    }else{
                        
                        $post->update([
                            'description' => $description,
                            'date' => Carbon::now(),
                            'user_id' => $users->id,
                        ]);

                        // for now skip for post image
                        return response()->json([
                            'message' =>  $this->constantes['Modification'],
                            'post' => $post
                        ], 200);

                    }    
                }else{
                    return response()->json([
                        'message' =>  $this->constantes['Permission']
                    ], 403);
                }
            }else{
                return response()->json([
                    'message' => 'Post '. $this->constantes['NExistePasDansBD']
                ], 404);
            }
        }else{
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    // Delete post
    public function delete($id){

        $users = auth()->user();
        $autorisation = false;

        if($users){
            
            $post = Post::find($id);

            if($post){

                if($users->roles == "Administrateurs"){
                    $autorisation = true;
                }else if($post->user_id == $users->id){
                    $autorisation = true;
                }
                
                if($autorisation){

                    $post->comments()->delete();
                    $post->likes()->delete();
                    $post->delete();
                    
                    return response()->json([
                        'message' =>  $this->constantes['Suppression']
                    ], 200);
                }else{
                    return response()->json([
                        'message' =>  $this->constantes['Permission']
                    ], 403);
                }
            }else{
                return response()->json([
                    'message' => 'Post '. $this->constantes['NExistePasDansBD']
                ], 404);
            }

        }else{
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
        }
    }
}
