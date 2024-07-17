<?php

namespace App\Http\Controllers\WEB;

use Exception;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NiveauRequest;
use Yajra\DataTables\Facades\DataTables;

class NiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $niveaux = Level::select(['id', 'nom_niveau']);
                return DataTables::of($niveaux)
                    ->addColumn('action', function($row){
                        return '<div class="d-flex justify-content-center">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-inline" title="Modifier" id="btn-edit-niveau-form-modal" data-id="'.$row->id.'">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-inline ms-1" title="Supprimer" id="btn-delete-niveau-form-modal" data-id="'.$row->id.'">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.niveaux.index');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NiveauRequest $request)
    {
        $data = $request->validated();
        $niveau = Level::withTrashed()->where('nom_niveau', $data['nom_niveau'])->first();
        if ($niveau) {
            $niveau->restore();
            $niveau->update($data);
        } else {
            Level::create($data);
        }
        return response()->json([
            'message' => 'Création réuissi!'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $niveau = Level::find($id);
        if(!$niveau){
            abort(404);
        }
        return response()->json([
            'success' => true,
            'niveau' => $niveau
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NiveauRequest $request, string $id)
    {
        $niveau = Level::find($id);

        if (!$niveau) {
            return response()->json([
                'success' => false,
                'message' => 'Niveau non trouvée'
            ], 404);
        }

        $data = $request->validated();

        // Vérifier si le nom_niveau a changé
        if ($data['nom_niveau'] === $niveau->nom_niveau) {
            return response()->json([
                'success' => true,
                'message' => 'Aucune modification apportée',
                'niveau' => $niveau
            ]);
        }

        $niveau->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Niveau mise à jour avec succès',
            'niveau' => $niveau
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $niveau = Level::find($id);

        if (!$niveau) {
            return response()->json([
                'success' => false,
                'message' => 'Niveau non trouvée'
            ], 404);
        }

        $niveau->delete();

        return response()->json([
            'success' => true,
            'message' => 'Niveau supprimée avec succès'
        ]);
    }
}
