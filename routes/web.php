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

Route::get('/serve-model/{filename}', function ($filename) {
    $path = public_path('modeles/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, [
        'Content-Type' => 'model/gltf-binary',
        'Access-Control-Allow-Origin' => '*',
    ]);
});

Route::get('/viewer/{id}', function ($id) {
    $modele = Modele3D::findOrFail($id);
    $modeleUrl = '/public/modeles/' . basename($modele->chemin_stockage);
    $arModelUrl = request()->getSchemeAndHttpHost() . '/serve-model/' . basename($modele->chemin_stockage);

    $viewerPageUrl = request()->getSchemeAndHttpHost() . '/viewer/' . $id;

    $qrCode = base64_encode(QrCode::format('png')->size(250)->generate($viewerPageUrl));

    return view('viewer', [
        'modeleUrl' => $modeleUrl,
        'modeleNom' => $modele->nom_fichier,
        'qrCode' => $qrCode,
        'arModelUrl' => $arModelUrl,
    ]);
})->name('viewer.show');