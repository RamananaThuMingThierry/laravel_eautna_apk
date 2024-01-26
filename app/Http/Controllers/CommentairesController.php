<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Commentaires;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CommentairesController extends Controller
{
     // get all commentaires of a post
     public function index($id){
        $user = auth()->user();

        if($user){
            
            $post = Post::find($id);

            if($post){
                return response()->json([
                    'commentaires' => $post->commentaires()->with('users:id,pseudo,image')->get()
                ], 200);
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


    // Create comment
    public function store(Request $request, $id){
        $post = Post::find($id);

        $user = auth()->user();

        $commentaires = $request->commentaires;

        if($user){

            if($user->status){
                
                if($post){

                    $validator = Validator::make($request->all(), [
                        'commentaires' => 'required|string',
                    ]);  

                    if($validator->fails()){
                        
                        return response()->json([
                            'errors' => $validator->messages(),
                        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            
                    }else{

                        Commentaires::create([
                            'commentaires' => $commentaires,
                            'post_id' => $id,
                            'users_id' => $user->id
                        ]);
                            
                        return response()->json([
                            'message' => 'Le commentaire '.$this->constantes['Creation']
                        ], 200);

                    }
        
                }else{
                    return response()->json([
                        'message' => 'Post '.$this->constantes['NExistePasDansBD']
                    ], 404);
                }

            }else{
                return response()->json([
                    'message' => $this->constantes['Permission']
                ], 403);    
            }

        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    // Modifier un commentaire
    public function update(Request $request, $id){
        $autorisation = false;
        $commentaires = $request->commentaires;
        $commentaires_update = Commentaires::find($id);
        $user = auth()->user();

        if($user){

            if($user->roles == "Administrateurs"){
                $autorisation = true;
            }else if($commentaires_update->users_id == $user->id){
                $autorisation = true;
            }

            if($autorisation){

                if($commentaires_update){

                    $validator = Validator::make($request->all(), [
                        'commentaires' => 'required|string',
                    ]);  

                    if($validator->fails()){
                        
                        return response()->json([
                            'errors' => $validator->messages(),
                        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            
                    }else{
                        $commentaires_update->update([
                            'commentaires' => $commentaires,
                            'users_id' => $user->id
                        ]);
    
                        return response()->json([
                            'commentaires' => $commentaires_update,
                            'message' => $this->constantes['Reussi']
                        ], 200);    
                    }
                    
                }else{
                    return response()->json([
                        'message' => 'Cet commentaire '.$this->constantes['NExistePasDansBD']
                    ], 404);
                }

            }else{

                return response()->json([
                    'message' => $this->constantes['Permission']
                ], 403);

            }
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }
    
    // supprimer un commentaires
    public function delete($id){
        $autorisation = false;
        $commentaires = Commentaires::find($id);
        $user = auth()->user();

        if($user){

            if($user->roles == "Administrateurs"){
                $autorisation = true;
            }else if($commentaires->users_id == $user->id){
                $autorisation = true;
            }

            if($autorisation){

                if($commentaires){

                    $commentaires->delete();

                    return response()->json([
                        'message' =>$this->constantes['Suppression']
                    ], 200);
                
                }else{
                
                    return response()->json([
                        'message' => 'Cet commentaire '.$this->constantes['NExistePasDansBD']
                    ], 404);

                }

            }else{
                return response()->json([
                    'message' => $this->constantes['Permission']
                ], 403);
            }
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);            
        }
    }
}
