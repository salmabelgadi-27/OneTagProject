<?php

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModeleController;
use App\Models\Modele3D;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [ModeleController::class, 'create'])->name('modele.upload');
Route::post('/upload', [ModeleController::class, 'store'])->name('modele.store');
Route::post('/api/upload-compressed', [ModeleController::class, 'storeCompressed'])->name('modele.storeCompressed');

Route::get('/viewer/{id}', function ($id) {
    $modele = Modele3D::findOrFail($id);
    $modeleUrl = '/public/modeles/' . basename($modele->chemin_stockage);

    $viewerPageUrl = request()->getSchemeAndHttpHost() . '/viewer/' . $id;
    $arUrl = 'https://arvr.google.com/scene-viewer/1.0?file=' . urlencode('https://modelviewer.dev/shared-assets/models/Astronaut.glb') . '&mode=ar_preferred&title=Demo+Astronaut';

    $qrCode = base64_encode(QrCode::format('png')->size(250)->generate($viewerPageUrl));

    return view('viewer', [
        'modeleUrl' => $modeleUrl,
        'modeleNom' => $modele->nom_fichier,
        'qrCode' => $qrCode,
    ]);
})->name('viewer.show');