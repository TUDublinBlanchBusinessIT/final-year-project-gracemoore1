<!DOCTYPE html>
<html>
<head>
    <title>OCR Verification</title>
    <script src="https://unpkg.com/tesseract.js@4.0.2/dist/tesseract.min.js"></script>
</head>
<body>
    <h1>OCR Verification</h1>
    <p>Please upload a clear photo of your ID.</p>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="ocr-form" method="POST" action="{{ route('landlord.verify.id.submit') }}">
        @csrf

        <input type="hidden" name="email" value="{{ request('email') }}">
        <input type="hidden" name="ocr_text" id="ocr_text">

        <label>Upload ID image:</label>
        <input type="file" id="id_image" accept="image/*" required>

        <p id="status"></p>

        <button type="submit" id="submit-btn" disabled>Verify ID</button>
    </form>

    <script>
        const fileInput = document.getElementById('id_image');
        const ocrField = document.getElementById('ocr_text');
        const statusText = document.getElementById('status');
        const submitBtn = document.getElementById('submit-btn');

        fileInput.addEventListener('change', async function () {
            const file = this.files[0];
            if (!file) return;

            statusText.textContent = 'Running OCR, please wait...';
            submitBtn.disabled = true;

            const reader = new FileReader();
            reader.onload = async function (e) {
                const imageData = e.target.result;

                try {
                    const result = await Tesseract.recognize(imageData, 'eng');
                    const text = result.data.text || '';
                    ocrField.value = text;
                    statusText.textContent = 'OCR complete. You can now verify your ID.';
                    submitBtn.disabled = false;
                } catch (err) {
                    console.error(err);
                    statusText.textContent = 'OCR failed. Please try another image.';
                    submitBtn.disabled = true;
                }
            };

            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>
