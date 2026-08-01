<?php

namespace App\Http\Controllers;

use App\Models\Modele3D;
use Illuminate\Http\Request;

class ModeleController extends Controller
{
    public function create()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fichier_3d' => 'required|file|max:51200',
        ]);

        $extension = $request->file('fichier_3d')->getClientOriginalExtension();
        if (strtolower($extension) !== 'glb') {
            return back()->withErrors(['fichier_3d' => 'Le fichier doit être au format GLB.']);
        }

        $fichier = $request->file('fichier_3d');
        $nomFichier = uniqid() . '_' . $fichier->getClientOriginalName();

        $destinationPath = public_path('modeles');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $fichier->move($destinationPath, $nomFichier);

        $modele = Modele3D::create([
            'nom_fichier'      => $nomFichier,
            'format'           => 'glb',
            'taille_originale' => round(filesize($destinationPath . '/' . $nomFichier) / 1024, 2),
            'chemin_stockage'  => 'modeles/' . $nomFichier,
        ]);

        return redirect()->route('viewer.show', ['id' => $modele->id])
            ->with('success', 'Fichier importé avec succès !');
    }

    public function storeCompressed(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200',
        ]);

        $fichier = $request->file('file');
        $nomFichier = uniqid() . '_compressed.glb';

        $destinationPath = public_path('modeles');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $fichier->move($destinationPath, $nomFichier);

        $url = request()->getSchemeAndHttpHost() . '/modeles/' . $nomFichier;

        return response()->json([
            'success' => true,
            'url' => $url,
        ]);
    }
}