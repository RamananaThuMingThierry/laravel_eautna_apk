<?php

namespace App\Http\Controllers\WEB;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Fonctions;

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
                            <a href="/admin/utilisateurs/'.$row->id.'/edit" class="btn btn-primary btn-sm btn-inline ms-1" title="Modifier un utilisateur">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" type="button" class="btn btn-danger btn-sm btn-inline ms-1" title="Supprimer un utilisateur" id="btn-delete-utilisateur-form-modal" data-id="'.$row->id.'">
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
