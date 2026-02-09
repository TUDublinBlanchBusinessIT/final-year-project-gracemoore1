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


        async function preprocessImage(file) {
            return new Promise((resolve) => {
                const img = new Image();
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    // Upscale 
                    canvas.width = img.width * 2;
                    canvas.height = img.height * 2;

                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    // Convert to grayscale
                    let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    let data = imageData.data;

                    for (let i = 0; i < data.length; i += 4) {
                        const avg = (data[i] + data[i + 1] + data[i + 2]) / 3;
                        data[i] = avg;
                        data[i + 1] = avg;
                        data[i + 2] = avg;
                    }

                    ctx.putImageData(imageData, 0, 0);

                    // Increase contrast
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

                    // Return processed image
                    canvas.toBlob((blob) => resolve(blob), 'image/png');
                };

                img.src = URL.createObjectURL(file);
            });
        }


        fileInput.addEventListener('change', async function () {
            const file = this.files[0];
            if (!file) return;

            statusText.textContent = 'Processing image...';
            submitBtn.disabled = true;

            try {
                // Preprocess the image before OCR
                const processedImage = await preprocessImage(file);

                statusText.textContent = 'Running OCR...';

                const result = await Tesseract.recognize(processedImage, 'eng');
                const text = result.data.text || '';

                ocrField.value = text;
                statusText.textContent = 'OCR complete. You can now verify your ID.';
                submitBtn.disabled = false;

            } catch (err) {
                console.error(err);
                statusText.textContent = 'OCR failed. Please try another image.';
                submitBtn.disabled = true;
            }
        });
    </script>
</body>
</html>
