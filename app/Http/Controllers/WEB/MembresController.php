<?php

namespace App\Http\Controllers\WEB;

use Exception;
use App\Models\Membres;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MembresRquest;
use Yajra\DataTables\Facades\DataTables;

class MembresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $membres = Membres::select(['id','numero_carte','nom', 'prenom','contact_personnel']);
                return DataTables::of($membres)
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
            return view('admin.membres.index');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View("admin.membres.form");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MembresRquest $request)
    {
        $data = $request->validated();
        
        $membre = Membres::withTrashed()
            ->where('numero_carte', $data['numero_carte'])
            ->where('nom', $data['nom'])
            ->where('prenom', $data['prenom'])
            ->first();
        if ($membre) {
            $membre->restore();
            $membre->update($data);
        } else {
            Membres::create($data);
        }
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
