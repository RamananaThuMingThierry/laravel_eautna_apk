<?php

namespace App\Http\Controllers\WEB;

use Exception;
use App\Models\Fonctions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FonctionsRequest;
use Yajra\DataTables\Facades\DataTables;

class FonctionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $fonctions = Fonctions::select(['id', 'nom_fonctions']);
                return DataTables::of($fonctions)
                    ->addColumn('action', function($row){
                        return '<div class="d-flex justify-content-center">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-inline" title="Modifier" id="btn-edit-fonction-form-modal" data-id="'.$row->id.'">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-inline ms-1" title="Supprimer" id="btn-delete-fonction-form-modal" data-id="'.$row->id.'">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.fonctions.index');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FonctionsRequest $request)
    {
        $data = $request->validated();
        $fonction = Fonctions::withTrashed()->where('nom_fonctions', $data['nom_fonctions'])->first();
        if ($fonction) {
            $fonction->restore();
            $fonction->update($data);
        } else {
            Fonctions::create($data);
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
        $fonction = Fonctions::find($id);
        if(!$fonction){
            abort(404);
        }
        return response()->json([
            'success' => true,
            'fonction' => $fonction
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FonctionsRequest $request, string $id)
    {
        $fonction = Fonctions::find($id);

        if (!$fonction) {
            return response()->json([
                'success' => false,
                'message' => 'Fonction non trouvée'
            ], 404);
        }

        $data = $request->validated();

        $fonction->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Fonction mise à jour avec succès',
            'fonction' => $fonction
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fonction = Fonctions::find($id);

        if (!$fonction) {
            return response()->json([
                'success' => false,
                'message' => 'Fonction non trouvée'
            ], 404);
        }

        $fonction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fonction supprimée avec succès'
        ]);
    }
}
