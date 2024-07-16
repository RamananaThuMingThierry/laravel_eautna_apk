<?php

namespace App\Http\Controllers\WEB;

use Exception;
use App\Models\Axes;
use App\Models\Level;
use App\Models\Membres;
use App\Models\Filieres;
use App\Models\Sections;
use App\Models\Fonctions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\MembresRequest;
use Illuminate\Support\Facades\Storage;
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
        $axes = Axes::pluck('nom_axes', 'id')->toArray();
        $sections = Sections::pluck('nom_sections', 'id')->toArray();
        $filieres = Filieres::pluck('nom_filieres', 'id')->toArray();
        $fonctions = Fonctions::pluck('nom_fonctions', 'id')->toArray();
        $levels = Level::pluck('nom_niveau', 'id')->toArray();
        return View("admin.membres.form", [
            'axes' => $axes,
            'sections' => $sections,
            'filieres' => $filieres,
            'fonctions' => $fonctions,
            'levels' => $levels,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MembresRequest $request)
    {
        $data = $request->validated();
    
        $membre = Membres::withTrashed()
            ->where('numero_carte', $data['numero_carte'])
            ->where('nom', $data['nom'])
            ->where('prenom', $data['prenom'])
            ->first();
    
            if ($request->hasFile('photo')) {
                if ($membre && $membre->image) {
                    $imagePath = public_path('images/' . $membre->image);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                }
                $image = $request->file('photo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $data['image'] = $imageName;
            }
    
        if ($membre) {
            $membre->restore();
            $membre->update($data);
        } else {
            Membres::create($data);
        }
    
        return response()->json([
            'message' => 'Création réussie!'
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
