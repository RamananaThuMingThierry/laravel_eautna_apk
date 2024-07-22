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
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        if(Auth::check()){
            if(Auth::check() && Auth::user()->status == false){
                return redirect()->route('status.not.approuved');
            }else{
                try {
                    if ($request->ajax()) {
                        $membres = Membres::select(['id', 'image', 'numero_carte', 'nom', 'prenom', 'contact_personnel']);
                        return DataTables::of($membres)
                            ->addColumn('action', function ($row) {
                                return '<div class="d-flex justify-content-center">
                                    <a href="/admin/membres/'.$row->id.'" class="btn btn-warning btn-sm btn-inline" title="Voir un membre">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="/admin/membres/'.$row->id.'/edit" class="btn btn-primary btn-sm btn-inline ms-1" title="Modifier un membre">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" type="button" class="btn btn-danger btn-sm btn-inline ms-1" title="Supprimer un membre" id="btn-delete-membre-form-modal" data-id="'.$row->id.'">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>';
                            })
                            ->rawColumns(['action'])
                            ->make(true);
                    }
                    return view('admin.membres.index');
                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            }
        }else{
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::check()){
            if(Auth::check() && Auth::user()->status == false){
                return redirect()->route('status.not.approuved');
            }else{
                $membre = new Membres();
                $axes = Axes::pluck('nom_axes', 'id')->toArray();
                $sections = Sections::pluck('nom_sections', 'id')->toArray();
                $filieres = Filieres::pluck('nom_filieres', 'id')->toArray();
                $fonctions = Fonctions::pluck('nom_fonctions', 'id')->toArray();
                $levels = Level::pluck('nom_niveau', 'id')->toArray();
                return View("admin.membres.form", [
                    'membre' => $membre,
                    'axes' => $axes,
                    'sections' => $sections,
                    'filieres' => $filieres,
                    'fonctions' => $fonctions,
                    'levels' => $levels,
                ]);
            }
        }else{
            return redirect()->route('login');
        }
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
    public function show($id)
    {
        try {
            $membre = Membres::findOrFail($id);
            if(!$membre){
                abort(404);
            }
            return view('admin.membres.show', compact('membre'));
        } catch (Exception $e) {
            return redirect()->route('admin.membres.index')->with('error', $e->getMessage());
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $axes = Axes::pluck('nom_axes', 'id')->toArray();
        $sections = Sections::pluck('nom_sections', 'id')->toArray();
        $filieres = Filieres::pluck('nom_filieres', 'id')->toArray();
        $fonctions = Fonctions::pluck('nom_fonctions', 'id')->toArray();
        $levels = Level::pluck('nom_niveau', 'id')->toArray();

        try {
            $membre = Membres::findOrFail($id);
            if(!$membre){
                abort(404);
            }
            return View("admin.membres.form", [
                'axes' => $axes,
                'sections' => $sections,
                'filieres' => $filieres,
                'fonctions' => $fonctions,
                'levels' => $levels,
                'membre' => $membre
            ]);
        } catch (Exception $e) {
            return redirect()->route('admin.membres.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MembresRequest $request, string $id)
    {
        try {
            $membre = Membres::findOrFail($id);
            if(!$membre){
                abort(404);
            }
            
            $data = $request->all();

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
        
            $membre->update($data);
        
            return response()->json([
                'success' => true,
                'message' => 'Modification réussie!'
            ], 200);
        } catch (Exception $e) {
            return redirect()->route('admin.membres.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $membre = Membres::find($id);

        if (!$membre) {
            return response()->json([
                'success' => false,
                'message' => 'Membre non trouvée'
            ], 404);
        }

        $membre->delete();

        return response()->json([
            'success' => true,
            'message' => 'Membre supprimée avec succès'
        ]);
    }
}
