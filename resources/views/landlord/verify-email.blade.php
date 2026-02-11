<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root { --rc-blue: #2d6cff; }

        body {
            font-family: 'Nunito', sans-serif;
            background: #f5f7fb;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 40px;
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
            margin-bottom: 25px;
            gap: 40px;
        }

        .step { text-align: center; }

        .circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 700;
            margin: 0 auto 6px;
            font-size: 18px;
        }

        .active { background: var(--rc-blue); color: white; }
        .inactive { background: #d3d3d3; color: white; }

        .step-label { font-size: 13px; color: #555; }

        /* CARD */
        .container {
            background: white;
            width: 380px;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(15,23,42,.08);
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: var(--rc-blue);
            font-weight: 800;
        }

        p { color: #555; margin-bottom: 10px; }

        .timer {
            font-size: 14px;
            margin-bottom: 20px;
            color: #64748b;
            font-weight: 600;
        }

        .timer.expired {
            color: #dc2626;
        }

        /* CODE INPUTS */
        .code-inputs {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 20px;
        }

        .code-inputs input {
            width: 60px;
            height: 60px;
            font-size: 28px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            outline: none;
            transition: 0.2s;
        }

        .code-inputs input:focus {
            border-color: var(--rc-blue);
            box-shadow: 0 0 0 4px rgba(45,108,255,.12);
        }

        button {
            width: 100%;
            padding: 12px 14px;
            background: var(--rc-blue);
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            transition: 0.2s;
        }

        button:hover { filter: brightness(.95); }

        .back {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 13px;
            color: var(--rc-blue);
            text-decoration: none;
            font-weight: 700;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: 600;
        }

        .error { color: red; margin-bottom: 10px; }
    </style>
</head>

<body>

<div class="wrapper">

    <!-- STEP INDICATOR -->
    <div class="steps">
        <div class="step">
            <div class="circle inactive">1</div>
            <div class="step-label">Your Details</div>
        </div>

        <div class="step">
            <div class="circle active">2</div>
            <div class="step-label">Email Verification</div>
        </div>

        <div class="step">
            <div class="circle inactive">3</div>
            <div class="step-label">ID Verification</div>
        </div>
    </div>

    <div class="container">

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <h1>Email Verification</h1>
        <p>Please enter the 4‑digit code sent to your email</p>

        <div id="timer" class="timer">⏳ 10:00 remaining</div>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form id="verifyForm" method="POST" action="{{ route('landlord.verify.email.submit') }}">
            @csrf

            <input type="hidden" name="email" value="{{ request('email') }}">
            <input type="hidden" id="full_code" name="code">

            <div class="code-inputs">
                <input type="number" maxlength="1" class="digit" />
                <input type="number" maxlength="1" class="digit" />
                <input type="number" maxlength="1" class="digit" />
                <input type="number" maxlength="1" class="digit" />
            </div>

            <button id="verifyBtn" type="submit">Verify</button>
        </form>

        <!-- Hidden resend form -->
        <form id="resendForm" method="POST" action="{{ route('landlord.verify.email.resend') }}" style="display:none;">
            @csrf
            <input type="hidden" name="email" value="{{ request('email') }}">
            <button type="submit" style="background:#475569;">Send new code</button>
        </form>

        <a href="{{ route('landlord.register.show') }}" class="back">← Back</a>
    </div>

</div>

<script>
    const inputs = document.querySelectorAll('.digit');
    const hiddenField = document.getElementById('full_code');
    const timerEl = document.getElementById('timer');
    const verifyBtn = document.getElementById('verifyBtn');
    const verifyForm = document.getElementById('verifyForm');
    const resendForm = document.getElementById('resendForm');

    // Auto-advance input boxes
    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            input.value = input.value.slice(0, 1);
            if (input.value && index < inputs.length - 1) inputs[index + 1].focus();
            hiddenField.value = Array.from(inputs).map(i => i.value).join('');
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && index > 0) inputs[index - 1].focus();
        });
    });

    // Countdown timer
    let timeLeft = 600; // 10 minutes in seconds

    const countdown = setInterval(() => {
        const minutes = String(Math.floor(timeLeft / 60)).padStart(2, '0');
        const seconds = String(timeLeft % 60).padStart(2, '0');

        timerEl.textContent = `⏳ ${minutes}:${seconds} remaining`;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            timerEl.textContent = "Code expired";
            timerEl.classList.add("expired");

            verifyBtn.style.display = "none";
            resendForm.style.display = "block";
        }

        timeLeft--;
    }, 1000);
</script>

</body>
</html>
