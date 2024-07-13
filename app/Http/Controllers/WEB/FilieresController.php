<?php

namespace App\Http\Controllers\WEB;

use Exception;
use App\Models\Filieres;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilieresRequest;
use Yajra\DataTables\Facades\DataTables;

class FilieresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $filieres = Filieres::select(['id', 'nom_filieres']);
                return DataTables::of($filieres)
                    ->addColumn('action', function($row){
                        return '<a href="javascript:void(0)" class="d-inline btn-sm btn btn-info" id="btn-edit-filiere-form-modal" data-id="'.$row->id.'">Edit</a>&nbsp;<a class="btn-sm btn btn-danger delFiliereButton d-inline-block" href="javascript:void(0)" data-id="'.$row->id.'">Del</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.filieres.index');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FilieresRequest $request)
    {
        $data = $request->validated();
        Filieres::create($data);
        return response()->json([
            'message' => 'Création réuissi!'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $filiere = Filieres::find($id);
        if(!$filiere){
            abort(404);
        }
        return response()->json([
            'success' => true,
            'filiere' => $filiere
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FilieresRequest $request, $id)
    {
        $filiere = Filieres::find($id);
        if (!$filiere) {
            return response()->json([
                'success' => false,
                'message' => 'Filière non trouvée'
            ], 404);
        }

        $data = $request->validated();

        $filiere->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Filière mise à jour avec succès',
            'filiere' => $filiere
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
