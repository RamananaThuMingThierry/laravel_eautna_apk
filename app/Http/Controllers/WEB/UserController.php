<?php

namespace App\Http\Controllers\WEB;

use Exception;
use App\Models\User;
use App\Models\Fonctions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $utilisateurs = User::select(['id', 'image', 'pseudo','email', 'contact', 'roles', 'status']);
                return DataTables::of($utilisateurs)
                    ->addColumn('action', function ($row) {
                        return '<div class="d-flex justify-content-center">
                            <a href="javascript:void(0)" class="btn btn-warning btn-sm btn-inline" id="btn-show-utilisateur-modal" data-id="'.$row->id.'" title="Voir un utilisateur">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-inline ms-1" title="Modifier un utilisateur" id="btn-update-utilisateur-form-modal" data-id="'.$row->id.'">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" type="button" class="btn btn-danger btn-sm btn-inline ms-1" title="Supprimer un utilisateur" id="btn-update-utilisateur-form-modal" data-id="'.$row->id.'">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
    
            return view('admin.utilisateurs.index');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user){
            abort(404);
        }
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
    
    public function edit(string $id)
    {
        $user = User::find($id);
        if(!$user){
            abort(404);
        }
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function waiting()
    {
        return view('auth.waiting');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::check()){
            if(Auth::check() && Auth::user()->status == false){
                return redirect()->route('status.not.approuved');
            }else{
                $user = User::find($id);

                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Utilisateur non trouvée'
                    ], 404);
                }
                 
                if($user->status == false){
                    $data['status'] = true;
                }
                $data['roles'] = $request->roles;
                
                $user->update($data);
        
                return response()->json([
                    'success' => true,
                    'message' => 'Mise à jour effectuée'
                ]);
            }
        }else{
            return redirect()->route('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::check()){
            if(Auth::check() && Auth::user()->status == false){
                return redirect()->route('status.not.approuved');
            }else{
                $user = User::find($id);

                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Utilisateur non trouvée'
                    ], 404);
                }
        
                $user->delete();
        
                return response()->json([
                    'success' => true,
                    'message' => 'Utilisateur supprimée avec succès'
                ]);
            }
        }else{
            return redirect()->route('login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
