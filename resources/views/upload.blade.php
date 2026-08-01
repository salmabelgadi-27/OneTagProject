<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONETAG - Import 3D</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Work Sans', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1F1410 0%, #2E1D14 50%, #3B2417 100%);
            min-height: 100vh;
            color: #F1E4D3;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: rgba(255,235,205,0.05);
            border: 1px solid rgba(230,190,140,0.18);
            border-radius: 16px;
            padding: 40px;
            max-width: 460px;
            width: 100%;
            backdrop-filter: blur(10px);
        }
        h1 {
            font-family: 'Fraunces', Georgia, serif;
            font-size: 1.8rem;
            background: linear-gradient(90deg, #C9793F, #C89B3C);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }
        .subtitle {
            color: #B99C81;
            font-size: 0.9rem;
            margin-bottom: 25px;
        }
        .success-msg {
            color: #A8BC84;
            background: rgba(143,160,94,0.1);
            border-left: 3px solid #8FA05E;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }
        .error-list {
            list-style: none;
            margin-bottom: 15px;
        }
        .error-list li {
            color: #D08376;
            background: rgba(181,69,58,0.1);
            border-left: 3px solid #B5453A;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        label {
            display: block;
            color: #B99C81;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }
        input[type="file"] {
            width: 100%;
            color: #F1E4D3;
            background: rgba(255,235,205,0.04);
            border: 2px dashed rgba(201,121,63,0.35);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }
        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #C9793F, #C89B3C);
            color: #FBF3E7;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(201,121,63,0.35);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(201,121,63,0.45);
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Importer un modèle 3D</h1>
        <p class="subtitle">Déposez votre fichier GLB pour le préparer, le compresser et générer son QR Code.</p>

        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <ul class="error-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="/upload" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Choisir un fichier GLB :</label>
            <input type="file" name="fichier_3d" accept=".glb">
            <button type="submit">Importer</button>
        </form>
    </div>
</body>
</html>