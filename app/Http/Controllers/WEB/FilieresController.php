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
                        return '<div class="d-flex justify-content-center">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-inline" title="Modifier" id="btn-edit-filiere-form-modal" data-id="'.$row->id.'">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-inline ms-1" title="Supprimer" id="btn-delete-filiere-form-modal" data-id="'.$row->id.'">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        ';
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
        $filiere = Filieres::withTrashed()->where('nom_filieres', $data['nom_filieres'])->first();
        if ($filiere) {
            $filiere->restore();
            $filiere->update($data);
        } else {
            Filieres::create($data);
        }
        return response()->json([
            'message' => 'Création réuissi!'
        ], 200);
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
        $filiere = Filieres::find($id);

        if (!$filiere) {
            return response()->json([
                'success' => false,
                'message' => 'Filière non trouvée'
            ], 404);
        }

        $filiere->delete();

        return response()->json([
            'success' => true,
            'message' => 'Filière supprimée avec succès'
        ]);
    }
}
