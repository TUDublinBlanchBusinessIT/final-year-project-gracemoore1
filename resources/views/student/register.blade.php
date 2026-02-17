<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Register | RentConnect</title>

    <style>
        :root { --rc-blue: #2d6cff; }

        body {
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            background: #f5f7fb;
            margin: 0;
            display:flex;
            justify-content:center;
            align-items:flex-start;
            padding-top:40px;
        }

        .page {
            width: 100%;
            max-width: 500px;
            padding: 0 20px;
            display:flex;
            flex-direction:column;
            align-items:center;
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

        .step-label {
            font-size: 13px;
            color: #555;
        }

        /* CARD */
        .card {
            width: 100%;
            max-width: 420px;
            background:#fff;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(15,23,42,.08);
        }

        h1 {
            text-align:center;
            color: var(--rc-blue);
            font-weight: 800;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align:center;
            color:#64748b;
            font-size: 14px;
            margin-bottom: 20px;
        }

        label {
            display:block;
            font-size: 12px;
            color:#334155;
            margin: 12px 0 6px;
            font-weight: 600;
        }

        input {
            width:100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            outline:none;
            box-sizing: border-box;
        }

        input:focus {
            border-color: var(--rc-blue);
            box-shadow: 0 0 0 4px rgba(45,108,255,.12);
        }

        .btn {
            width:100%;
            margin-top: 18px;
            padding: 12px 14px;
            border-radius: 12px;
            background: var(--rc-blue);
            color:#fff;
            font-weight: 700;
            border:none;
            cursor:pointer;
        }

        .btn:hover { filter: brightness(.95); }

        .error-list {
            background: #fff5f5;
            color: #dc2626;
            border: 1px solid #dc2626;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 16px;
            font-size: 13px;
        }
    </style>
</head>

<body>
<div class="page">

    <!-- STEP INDICATOR -->
    <div class="steps">
        <div class="step">
            <div class="circle active">1</div>
            <div class="step-label">Your Details</div>
        </div>

        <div class="step">
            <div class="circle inactive">2</div>
            <div class="step-label">Email Verification</div>
        </div>

        <div class="step">
            <div class="circle inactive">3</div>
            <div class="step-label">ID Verification</div>
        </div>
    </div>

    <!-- CARD -->
    <div class="card">
        <h1>Student Registration</h1>
        <div class="subtitle">Please enter your details to create your account</div>

        @if ($errors->any())
            <div class="error-list">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/student/register">
            @csrf

            <label>Firstname:</label>
            <input type="text" name="firstname" value="{{ old('firstname') }}" required>

            <label>Surname:</label>
            <input type="text" name="surname" value="{{ old('surname') }}" required>

            <label>Date of Birth:</label>
            <input type="date" name="dateofbirth" value="{{ old('dateofbirth') }}" required>

            <label>Email Address:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Confirm Password:</label>
            <input type="password" name="password_confirmation" required>

            <button class="btn" type="submit">Submit</button>
        </form>
    </div>

</div>
</body>
</html>
