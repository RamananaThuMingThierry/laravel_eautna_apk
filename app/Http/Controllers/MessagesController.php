<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Messages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MessagesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if($user){

            $messages = Messages::where('users_id', $user->id)->orderBy('created_at')->get();

            return response()->json([
                'messages' => $messages
            ], 200);

        }
        else
        {
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function store(Request $request, $id_user_received)
    {
        $user = auth()->user();
        
        if($user)
        {
            $verification_id_user_received_existe = User::where('id', $id_user_received)->exists();

            if($verification_id_user_received_existe){

                $user_received = User::where('id', $id_user_received)->first();

                if($user_received->id == $user->id){
                    return response()->json([
                        'message' => $this->constantes['SendMessageInvalide']
                    ], 304);
                }else{

                    if($user_received->status == false){
                        return response()->json([
                            'message' => $this->constantes['Permission']
                        ], 403);
                    }

                    $message = $request->message;

                    $validator = Validator::make($request->all(), [
                        'message' => 'required|string|max:1000',
                    ]);        
            
                    if($validator->fails()){
                        
                        return response()->json([
                            'errors' => $validator->messages(),
                        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    
                    }else{                
                        
                        Messages::create([
                            'message' => $message,
                            'users_id' => $user->id,
                            'users_receive' => $id_user_received
                        ]);

                        return response()->json([
                            'message' => $this->constantes['SendMessageReussi']
                        ], 200);

                    }
                }
            }else{
                return response()->json([
                    'message' => 'Cette personne '.$this->constantes['NExistePasDansBD']
                ], 404);
            }
        }
        else
        {
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function show($userReceivedId){
        $user = auth()->user();
        if($user){
            $messages = DB::table('messages')
            ->where(function($query) use ($userReceivedId){
                $query
                    ->where('users_id', auth()->user()->id)
                    ->where('users_receive', $userReceivedId);
                })
            ->orWhere(function($query) use ($userReceivedId){
                $query
                    ->where('users_id', $userReceivedId)
                    ->where('users_receive', auth()->user()->id);
                })
            ->orderBy('created_at', 'desc')
            ->get();
        
            return response()->json([
                'messages' => $messages
            ], 200);
        }
        else
        {
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function ListeMessages($userReceivedId){
        $user = auth()->user();
        if($user){
           
            $latestmessages = DB::table('messages')
            ->select('users_id', DB::raw('MAX(created_at) as latest_date'))
            ->groupBy('users_id');
    
            $messages = DB::table('messages')
            ->joinSub($latestmessages, 'latest_messages', function($join){
                $join->on('messages.users_id', '=', 'latest_messages.users_id')
                    ->on('messages.created_at', '=', 'latest_messages.latest_date');
            })->select('messages.*')
            ->get();
            
           
            $users = DB::table('messages')
                ->distinct()
                ->select('users_receive')
                ->get();
            
            foreach($users as $u){
                $u->messages = $messages->where('users_receive', $u->users_receive)
                ->first();
            }

            return response()->json([
                'messages' => $users
            ], 200);
        }
        else
        {
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
        }
    }
    
}
