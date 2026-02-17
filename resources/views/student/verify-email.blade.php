<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification | RentConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root { --rc-blue: #2d6cff; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #f5f7fb;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 40px;
        }

        /* STEP INDICATOR */
        .steps {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 25px;
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

        /* ORIGINAL CARD DESIGN */
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
            color: var(--rc-blue);
            line-height: 1.2;
        }

        .subtitle {
            font-size: 16px;
            color: #6B7280;
            margin-bottom: 10px;
        }

        .timer {
            font-size: 15px;
            color: #374151;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .timer.expired { color: #dc2626; }

        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 12px;
        }

        input[type="text"] {
            padding: 13px 12px;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            font-size: 15px;
            background: #F9FAFB;
            color: #1F2937;
        }

        input[type="text"]:focus {
            border-color: var(--rc-blue);
            outline: none;
        }

        .btn {
            padding: 15px;
            background: var(--rc-blue);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            cursor: pointer;
        }

        .btn:hover { filter: brightness(.95); }

        .error-list {
            background: #fff5f5;
            color: #e53e3e;
            border: 1px solid #e53e3e;
            border-radius: 8px;
            padding: 12px;
        }
    </style>
</head>

<body>

<!-- STEP INDICATOR (added safely) -->
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

<div class="card">

    <h1>Email Verification</h1>
    <div class="subtitle">Please enter the 4‑digit code sent to your email</div>

    <!-- Countdown timer -->
    <div id="timer" class="timer">⏳ 10:00 remaining</div>

    <form method="POST" action="/student/verify-email">
        @csrf

        @if ($errors->any())
            <div class="error-list">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Your original single input field preserved -->
        <input type="text" name="code" placeholder="4 digit code" maxlength="4" required pattern="\d{4}">

        <button class="btn" type="submit">Verify</button>
    </form>
</div>

<!-- Countdown Timer Script -->
<script>
    let timeLeft = 600; // 10 minutes

    const timerEl = document.getElementById('timer');

    const countdown = setInterval(() => {
        const minutes = String(Math.floor(timeLeft / 60)).padStart(2, '0');
        const seconds = String(timeLeft % 60).padStart(2, '0');

        timerEl.textContent = `⏳ ${minutes}:${seconds} remaining`;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            timerEl.textContent = "Code expired";
            timerEl.classList.add("expired");
        }

        timeLeft--;
    }, 1000);
</script>

</body>
</html>