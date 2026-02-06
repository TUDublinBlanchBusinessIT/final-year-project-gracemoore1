<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OCR Verification | RentConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    :root {
        --primary: rgb(38, 98, 227);
        --primary-hover: #1E4FD8;
        --text-main: #1F2937;
        --text-muted: #6B7280;
        --bg: #F3F4F6;
        --error: #e53e3e;
    }
    * {
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    body {
        margin: 0;
        min-height: 100vh;
        background: var(--bg);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 24px;
    }
    .card {
        width: 100%;
        max-width: 420px;
        background: #fff;
        padding: 44px 28px;
        border-radius: 20px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        text-align: center;
    }
    h1 {
        margin: 0 0 10px;
        font-size: 28px;
        font-weight: 800;
        color: var(--primary);
        line-height: 1.2;
    }
    .subtitle {
        font-size: 16px;
        color: var(--text-muted);
        margin-bottom: 28px;
    }
    form {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-top: 12px;
    }
    .upload-area {
        border: 2px dashed var(--primary);
        border-radius: 12px;
        padding: 32px 0;
        margin-bottom: 8px;
        background: #f8fafc;
        cursor: pointer;
        transition: border-color 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .upload-area:hover {
        border-color: var(--primary-hover);
    }
    .upload-area input[type="file"] {
        display: none;
    }
    .upload-icon {
        font-size: 36px;
        color: var(--primary);
        margin-bottom: 8px;
    }
    .upload-label-text {
        color: var(--text-muted);
        font-size: 15px;
    }
    .preview-img {
        max-width: 100%;
        max-height: 180px;
        margin: 16px 0 0 0;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(38,98,227,0.08);
        display: none;
    }
    .ocr-status {
        margin: 10px 0;
        color: var(--primary);
        font-size: 15px;
    }
    .btn-row {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }
    .btn {
        width: 50%;
        min-width: 110px;
        max-width: 180px;
        padding: 15px 0;
        background: var(--primary);
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s, opacity 0.15s;
        box-sizing: border-box;
    }
    .btn:disabled {
        background: #b3c7f7;
        cursor: not-allowed;
    }
    .btn:hover:enabled {
        background: var(--primary-hover);
        transform: translateY(-1px);
    }
    .btn:active:enabled {
        opacity: 0.85;
        transform: translateY(0);
    }
    .error-list {
        background: #fff5f5;
        color: var(--error);
        border: 1px solid var(--error);
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 18px;
        text-align: left;
        font-size: 15px;
    }
    </style>
    <!-- Tesseract.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
</head>
<body>
    <div class="card">
        <h1>OCR Verification</h1>
        <div class="subtitle">
            Please upload a clear photo of your student ID
        </div>
        <form method="POST" action="/student/verify-id">
            @csrf

            @if ($errors->any())
                <div class="error-list">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <label class="upload-area" id="uploadLabel">
                <div class="upload-icon">&#128247;</div>
                <div class="upload-label-text">Click or drag to upload</div>
                <input type="file" name="id_image" id="id_image" accept="image/*" required>
                <img id="preview" class="preview-img">
            </label>

            <div id="ocr-status" class="ocr-status"></div>
            <input type="hidden" name="ocr_text" id="ocr_text">

            <div class="btn-row">
                <button class="btn" type="submit" id="submitBtn" disabled>Verify ID</button>
            </div>
        </form>
    </div>
    <script>
    // Show image preview and run OCR
    document.getElementById('id_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');
        const status = document.getElementById('ocr-status');
        const submitBtn = document.getElementById('submitBtn');
        const ocrText = document.getElementById('ocr_text');
        submitBtn.disabled = true;
        ocrText.value = '';
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                preview.src = evt.target.result;
                preview.style.display = 'block';
                status.textContent = "Scanning ID, please wait...";
                Tesseract.recognize(
                    evt.target.result,
                    'eng',
                    { logger: m => { status.textContent = "OCR: " + Math.round(m.progress*100) + "%"; } }
                ).then(({ data: { text } }) => {
                    ocrText.value = text;
                    status.textContent = "Scan complete. Ready to submit.";
                    submitBtn.disabled = false;
                }).catch(() => {
                    status.textContent = "OCR failed. Please try another image.";
                    submitBtn.disabled = true;
                });
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            status.textContent = '';
            submitBtn.disabled = true;
        }
    });
    </script>
</body>
</html>
