<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ID Verification</title>

    <!-- TESSERACT JS -->
    <script src="https://unpkg.com/tesseract.js@4.0.2/dist/tesseract.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root { --rc-blue: #2d6cff; }

        body {
            font-family: 'Nunito', sans-serif;
            background: #f5f7fb;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 60px;
            margin: 0;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        /* STEP INDICATOR */
        .steps {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 40px;
            gap: 50px;
            flex-wrap: wrap;
        }

        .step { text-align: center; }

        .circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 700;
            margin: 0 auto 8px;
            font-size: 18px;
        }

        .active { background: var(--rc-blue); color: white; }
        .inactive { background: #d3d3d3; color: white; }

        .step-label { font-size: 14px; color: #555; }

        /* CARD */
        .container {
            background: white;
            width: 420px;
            padding: 45px;
            border-radius: 22px;
            box-shadow: 0 10px 30px rgba(15,23,42,.08);
            text-align: center;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 16px;
            color: var(--rc-blue);
            font-weight: 800;
        }

        p {
            color: #555;
            margin-bottom: 32px;
            font-size: 15px;
        }

        /* UPLOAD BOX */
        .upload-box {
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            padding: 28px;
            background: #f8fafc;
            cursor: pointer;
            transition: 0.2s;
            margin-bottom: 20px;
        }

        .upload-box:hover {
            border-color: var(--rc-blue);
            background: #eef4ff;
        }

        .upload-box input { display: none; }

        .upload-text {
            color: #64748b;
            font-size: 15px;
            font-weight: 600;
        }

        /* IMAGE PREVIEW */
        .preview {
            margin-top: 20px;
            display: none;
        }

        .preview img {
            width: 100%;
            border-radius: 14px;
            margin-top: 12px;
        }

        /* STATUS TEXT */
        #status {
            margin-top: 15px;
            font-size: 14px;
            color: #475569;
            min-height: 20px;
        }

        /* BUTTONS */
        button {
            width: 100%;
            padding: 14px 16px;
            background: var(--rc-blue);
            border: none;
            color: white;
            font-size: 17px;
            border-radius: 14px;
            cursor: pointer;
            font-weight: 700;
            transition: 0.2s;
            margin-top: 25px;
        }

        button:hover { filter: brightness(.95); }

        button.processing {
            background: #94a3b8;
            cursor: not-allowed;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 28px;
            font-size: 14px;
            color: var(--rc-blue);
            text-decoration: none;
            font-weight: 700;
        }

        .error {
            color: #dc2626;
            margin-top: 25px;
            font-size: 15px;
        }

        /* FULLSCREEN OVERLAY */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.9);
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 9999;
        }

        .overlay .spinner {
            border: 5px solid #e2e8f0;
            border-top: 5px solid var(--rc-blue);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 0.8s linear infinite;
            margin-bottom: 20px;
        }

        .overlay p {
            font-size: 18px;
            color: #334155;
            font-weight: 700;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* MOBILE */
        @media (max-width: 430px) {
            .container {
                width: 92%;
                padding: 35px;
            }

            .steps {
                gap: 25px;
            }
        }

        .help-icon {
            display: inline-block;
            width: 22px;
            height: 22px;
            background: var(--rc-blue);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 22px;
            font-weight: bold;
            cursor: pointer;
            margin-left: 8px;
            font-size: 14px;
        }

        .ocr-help-box {
            background: #f5f7ff;
            border-left: 4px solid var(--rc-blue);
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            max-width: 380px;
            text-align: left;
        }
        .close-help {
            margin-top: 10px;
            background: var(--rc-blue);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .upload-shifted {
            margin-top: 20px; 
        }

        .ocr-help-box {
        	background: #f5f7ff;
            border-left: 4px solid var(--rc-blue);
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            margin-bottom: 60px;
            max-width: 380px;
            text-align: left;
        }

        #progressWrap{
            width: 100%;
            max-width: 520px;
            margin-top: 14px;
        }

        .progressRow{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .progressTrack{
            flex:1;
            height: 12px;
            background: #e8eefc;
            border-radius: 999px;
            overflow:hidden;
        }

        .progressBar{
            height: 100%;
            background: var(--rc-blue);
            border-radius: 999px;
            transition: width .15s ease;
        }

        .progressPct{
            min-width: 44px;
            text-align:right;
            font-weight: 700;
            color: #0f172a;
        }

        .progressStage{
            margin-top: 8px;
            font-size: 13px;
            color: #475569;
        }

        .verify-btn:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .verify-btn {
            background: var(--rc-blue);
            color: white;
            transition: all .2s ease;
        }




    </style>
</head>

<body>

<div class="overlay" id="processingOverlay">
    <div class="spinner"></div>
    <p>Processing ID…</p>
</div>

<div class="wrapper">

    <!-- STEP INDICATOR -->
    <div class="steps">
        <div class="step">
            <div class="circle inactive">1</div>
            <div class="step-label">Your Details</div>
        </div>

        <div class="step">
            <div class="circle inactive">2</div>
            <div class="step-label">Email Verification</div>
        </div>

        <div class="step">
            <div class="circle active">3</div>
            <div class="step-label">ID Verification</div>
        </div>
    </div>

    <!-- CARD -->
    <div class="container">
        <h1>
            OCR Verification
            <span class="help-icon" onclick="toggleOCRHelp()">?</span>
        </h1>
        <p>Please upload a clear photo of your ID</p>
        <div id="ocrHelpBox" class="ocr-help-box" style="display: none;">
            <h3>What is OCR?</h3>
            <p>
                Optical Character Recognition (OCR) is a secure process where you upload a photo 
                of your government‑issued ID so we can confirm it’s really you creating the account.
                This helps keep everyone safe on the platform by reducing scams and preventing fake accounts.
                Your ID image is processed securely and <strong>never stored</strong>.
            </p>
            <button onclick="toggleOCRHelp()" class="close-help">Close</button>
    </div>



        <form id="ocrForm" method="POST" action="{{ route('landlord.verify.id.submit') }}">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="ocr_text" id="ocr_text">

            <label class="upload-box" id="uploadBox">
                <span class="upload-text">Click or drag to upload</span>
                <input id="fileInput" type="file" accept="image/*" required>
            </label>

            <div class="preview" id="previewBox">
                <img id="previewImage" src="">
            </div>

            <p id="status"></p>

            
            <div id="progressWrap" style="display:none;">
                <div class="progressRow">
                    <div class="progressTrack">
                        <div id="progressBar" class="progressBar" style="width:0%;"></div>
                    </div>
                    <div id="progressPct" class="progressPct">0%</div>
                </div>
                <div id="progressStage" class="progressStage"></div>
            </div>

            <div id="verifyWrap" style="display:none;">
                <button id="verifyBtn" type="submit">Verify ID</button>
            </div>



            <a href="{{ route('landlord.verify.email') }}" class="back">← Back</a>
        </form>
    </div>

</div>

<script>
    const fileInput = document.getElementById('fileInput');
    const previewBox = document.getElementById('previewBox');
    const previewImage = document.getElementById('previewImage');
    const verifyBtn = document.getElementById('verifyBtn');
    const verifyWrap = document.getElementById('verifyWrap');
    const ocrForm = document.getElementById('ocrForm');
    const overlay = document.getElementById('processingOverlay');
    const statusText = document.getElementById('status');
    const ocrField = document.getElementById('ocr_text');
    const progressWrap = document.getElementById('progressWrap');
    const progressBar = document.getElementById('progressBar');
    const progressPct = document.getElementById('progressPct');
    const progressStage = document.getElementById('progressStage');


    async function preprocessImage(file) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = () => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                canvas.width = img.width * 2;
                canvas.height = img.height * 2;

                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                let data = imageData.data;

                for (let i = 0; i < data.length; i += 4) {
                    const avg = (data[i] + data[i + 1] + data[i + 2]) / 3;
                    data[i] = avg;
                    data[i + 1] = avg;
                    data[i + 2] = avg;
                }

                ctx.putImageData(imageData, 0, 0);

                const contrast = 40;
                const factor = (259 * (contrast + 255)) / (255 * (259 - contrast));

                let contrasted = ctx.getImageData(0, 0, canvas.width, canvas.height);
                let cd = contrasted.data;

                for (let i = 0; i < cd.length; i += 4) {
                    cd[i] = factor * (cd[i] - 128) + 128;
                    cd[i + 1] = factor * (cd[i + 1] - 128) + 128;
                    cd[i + 2] = factor * (cd[i + 2] - 128) + 128;
                }

                ctx.putImageData(contrasted, 0, 0);

                canvas.toBlob((blob) => resolve(blob), 'image/png');
            };

            img.src = URL.createObjectURL(file);
        });
    }

    /* HANDLE FILE SELECTION */
    fileInput.addEventListener('change', async () => {
        const file = fileInput.files[0];
        if (!file) return;

        document.querySelector('.upload-box').style.display = 'none';

        previewImage.src = URL.createObjectURL(file);
        previewBox.style.display = 'block';

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        statusText.textContent = 'Processing image...';
        verifyBtn.disabled = true;
        verifyBtn.classList.add('processing');
        verifyWrap.style.display = 'none';


        try {
            const processedImage = await preprocessImage(file);

            statusText.textContent = 'Running OCR...';

            // show progress UI
            const progressWrap = document.getElementById('progressWrap');
            const progressBar  = document.getElementById('progressBar');
            const progressPct  = document.getElementById('progressPct');
            const progressStage = document.getElementById('progressStage');

            progressWrap.style.display = 'block';
            progressBar.style.width = '0%';
            progressPct.textContent = '0%';
            progressStage.textContent = 'Starting OCR...';

            const result = await Tesseract.recognize(processedImage, 'eng', {
                logger: (m) => {
                    // m.progress is 0..1 when available
                    if (typeof m.progress === 'number') {
                        const pct = Math.round(m.progress * 100);
                        progressBar.style.width = pct + '%';
                        progressPct.textContent = pct + '%';
                    }

                    // Optional: show stage text
                    if (m.status) {
                        // Examples: "loading tesseract core", "initializing tesseract", "recognizing text"
                        progressStage.textContent = m.status;
                    }
                }
            });

            const text = result.data.text || '';
            ocrField.value = text;

            if (text.trim().length > 10) {
                verifyBtn.disabled = false;
            } else {
                verifyBtn.disabled = true;
            }


            statusText.textContent = 'OCR complete. You can now verify your ID.';

            progressBar.style.width = '100%';
            progressPct.textContent = '100%';
            progressStage.textContent = 'Done';

            verifyWrap.style.display = 'block';
            verifyBtn.disabled = false;
            verifyBtn.classList.remove('processing');
            verifyBtn.style.background = 'var(--rc-blue)';
            verifyBtn.style.cursor = 'pointer';




        } catch (err) {
            console.error(err);
            statusText.textContent = 'OCR failed. Please try another image.';
            verifyBtn.disabled = true;
            progressWrap.style.display = 'none';
            verifyWrap.style.display = 'none';


        }
    });

    
    ocrForm.addEventListener('submit', () => {
        overlay.style.display = 'flex';
        verifyBtn.disabled = true;
        verifyBtn.classList.add('processing');
        verifyBtn.textContent = "Processing…";
    });

    function toggleOCRHelp() {
        const box = document.getElementById('ocrHelpBox');
        box.style.display = box.style.display === 'none' ? 'block' : 'none';

}

</script>

</body>
</html>
