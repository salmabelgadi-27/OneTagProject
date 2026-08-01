<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONETAG - Visionneuse AR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Model Viewer : composant Google pour 3D + AR -->
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Work Sans', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #1F1410 0%, #2E1D14 50%, #3B2417 100%);
            min-height: 100vh;
            color: #F1E4D3;
        }
        .container { max-width: 1100px; margin: 0 auto; padding: 20px; }
        .header {
            text-align: center;
            padding: 30px 0;
            border-bottom: 1px solid rgba(230,190,140,0.15);
            margin-bottom: 30px;
        }
        .header h1 {
            font-family: 'Fraunces', Georgia, serif;
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(90deg, #C9793F, #C89B3C);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }
        .header p { color: #B99C81; font-size: 1rem; }
        .main-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 25px;
        }
        @media (max-width: 850px) {
            .main-grid { grid-template-columns: 1fr; }
        }
        .panel {
            background: rgba(255,235,205,0.05);
            border: 1px solid rgba(230,190,140,0.18);
            border-radius: 16px;
            padding: 25px;
            backdrop-filter: blur(10px);
        }
        .panel-title {
            font-family: 'Fraunces', Georgia, serif;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 18px;
            color: #F1E4D3;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .panel-title .icon {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #C9793F, #C89B3C);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }
        .viewer-container {
            width: 100%;
            height: 450px;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            background: #1A100B;
            border: 1px solid rgba(230,190,140,0.12);
        }
        model-viewer {
            width: 100%;
            height: 100%;
            background-color: #1A100B;
            --poster-color: #1A100B;
        }
        model-viewer::part(default-ar-button) {
            background: linear-gradient(135deg, #C9793F, #C89B3C);
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            color: #FBF3E7;
            box-shadow: 0 4px 20px rgba(201,121,63,0.35);
        }
        .model-name {
            margin-top: 15px;
            padding: 12px 15px;
            background: rgba(201,121,63,0.08);
            border-radius: 10px;
            border-left: 3px solid #C9793F;
            font-size: 0.9rem;
            color: #E3A56D;
            word-break: break-all;
        }
        .qr-display {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            gap: 16px;
        }
        .qr-box {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(20,12,8,0.4);
        }
        .qr-box img { display: block; width: 220px; height: 220px; }
        .qr-caption {
            text-align: center;
            color: #B99C81;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        .qr-caption strong { color: #F1E4D3; }
        .btn {
            padding: 12px 20px;
            border-radius: 10px;
            border: none;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            text-decoration: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #C9793F, #C89B3C);
            color: #FBF3E7;
            box-shadow: 0 4px 20px rgba(201,121,63,0.35);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(201,121,63,0.45);
        }
        .btn-secondary {
            background: rgba(255,235,205,0.07);
            color: #F1E4D3;
            border: 1px solid rgba(230,190,140,0.18);
        }
        .btn-secondary:hover {
            background: rgba(255,235,205,0.12);
            border-color: rgba(230,190,140,0.35);
        }
        .actions { width: 100%; display: flex; flex-direction: column; gap: 10px; margin-top: 5px; }
        .instructions {
            background: rgba(200,155,60,0.1);
            border: 1px solid rgba(200,155,60,0.3);
            border-radius: 12px;
            padding: 18px;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #B99C81;
            line-height: 1.7;
        }
        .instructions strong { color: #F1E4D3; }
        .ar-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(143,160,94,0.15);
            border: 1px solid rgba(143,160,94,0.3);
            color: #A8BC84;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ONETAG — Visionneuse AR</h1>
            <p>Scannez le QR code pour voir ce modèle en réalité augmentée</p>
        </div>

        <div class="main-grid">
            <!-- Viewer 3D + AR -->
            <div class="panel">
                <div class="panel-title">
                    <div class="icon">📦</div>
                    Aperçu du modèle 3D
                </div>
                <div class="viewer-container">
 <model-viewer
    src="https://raw.githubusercontent.com/salmabelgadi-27/OneTagProject/master/public/modeles-gh/{{ $modeleNom }}"
    alt="{{ $modeleNom }}"
    ar
    ar-modes="webxr scene-viewer quick-look"
    camera-controls
    touch-action="pan-y"
    auto-rotate
    shadow-intensity="1"
    loading="eager"
></model-viewer>
                </div>
                <div class="model-name">
                    📄 {{ $modeleNom }}
                </div>
<div style="margin-top:15px;">
    <button onclick="document.querySelector('model-viewer').activateAR()" style="width:100%;padding:16px;border:none;border-radius:12px;background:linear-gradient(135deg,#C9793F,#C89B3C);color:#FBF3E7;font-size:1.1rem;font-weight:700;cursor:pointer;box-shadow:0 4px 20px rgba(201,121,63,0.35);">
        📱 Voir en Réalité Augmentée (AR)
    </button>
</div>
<script>
    document.getElementById('arLink').addEventListener('click', function(e) {
        const mv = document.querySelector('model-viewer');
        if (mv && mv.canActivateAR) {
            e.preventDefault();
            mv.activateAR();
        }
    });
</script>
                <div class="ar-badge">
                    ✅ AR disponible — appuyez sur le bouton AR dans le viewer (sur téléphone)
                </div>
            </div>

            <!-- QR Code -->
            <div class="panel">
                <div class="panel-title">
                    <div class="icon">📱</div>
                    QR Code AR
                </div>
                <div class="qr-display">
                    <div class="qr-box">
                        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code" style="width:220px;height:220px;">
                    </div>
                    <div class="qr-caption">
                        Pointez la caméra de votre téléphone vers ce QR code.<br>
                        Le modèle s'affichera en <strong>3D</strong>, et vous pourrez le voir en <strong>réalité augmentée</strong> en appuyant sur le bouton AR.
                    </div>
                    <div class="actions">
                        <a href="data:image/png;base64,{{ $qrCode }}" download="onetag-qr.png" class="btn btn-primary">
    💾 Télécharger le QR Code
</a>
                            💾 Télécharger le QR Code
                        </a>
                        <button class="btn btn-secondary" onclick="navigator.clipboard.writeText(window.location.href).then(()=>alert('Lien copié !'))">
                            📋 Copier le lien
                        </button>
                    </div>
                </div>

                <div class="instructions">
                    <strong>📋 Comment utiliser :</strong><br>
                    1. Scannez le QR code avec votre téléphone<br>
                    2. Le modèle 3D s'affiche dans le navigateur<br>
                    3. Appuyez sur le bouton <strong>AR</strong> (en bas du viewer)<br>
                    4. Le modèle apparaît dans votre espace réel via la caméra<br><br>
                    <strong>Compatibilité :</strong> Android (Chrome + ARCore) et iOS (Safari + ARKit)
                </div>
            </div>
        </div>
    </div>
</body>
</html>