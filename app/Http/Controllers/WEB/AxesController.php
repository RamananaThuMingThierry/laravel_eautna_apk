<?php

namespace App\Http\Controllers\WEB;

use Exception;
use App\Models\Axes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AxesRequest;
use Yajra\DataTables\Facades\DataTables;

class AxesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $axes = Axes::select(['id', 'nom_axes']);
                return DataTables::of($axes)
                    ->addColumn('action', function($row){
                        return '<div class="d-flex justify-content-center">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-inline" title="Modifier" id="btn-edit-axes-form-modal" data-id="'.$row->id.'">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-inline ms-1" title="Supprimer" id="btn-delete-axes-form-modal" data-id="'.$row->id.'">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.axes.index');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AxesRequest $request)
    {
        $data = $request->validated();
        $axes = Axes::withTrashed()->where('nom_axes', $data['nom_axes'])->first();
        if ($axes) {
            $axes->restore();
            $axes->update($data);
        } else {
            Axes::create($data);
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
        $axes = Axes::find($id);
        if(!$axes){
            abort(404);
        }
        return response()->json([
            'success' => true,
            'axes' => $axes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AxesRequest $request, string $id)
    {
        $axes = Axes::find($id);
        if (!$axes) {
            return response()->json([
                'success' => false,
                'message' => 'Axes non trouvée'
            ], 404);
        }

        $data = $request->validated();

        $axes->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Axes mise à jour avec succès',
            'axes' => $axes
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $axes = Axes::find($id);

        if (!$axes) {
            return response()->json([
                'success' => false,
                'message' => 'Axes non trouvée'
            ], 404);
        }

        $axes->delete();

        return response()->json([
            'success' => true,
            'message' => 'Axes supprimée avec succès'
        ]);
    }
}
