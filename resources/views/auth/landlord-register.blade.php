<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landlord Register | RentConnect</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root { --rc-blue: #2d6cff; }

        body {
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            background: #f5f7fb;
        }

        .page {
            min-height: 100vh;
            display:flex;
            flex-direction: column;
            align-items:center;
            justify-content:flex-start;
            padding: 40px 24px;
        }

        /* STEP INDICATOR */
        .steps {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 25px;
            gap: 40px;
        }

        .step {
            text-align: center;
        }

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
            margin-bottom: 18px;
        }

        label {
            display:block;
            font-size: 12px;
            color:#334155;
            margin: 12px 0 6px;
            font-weight: 600;
        }

        input {
            width:90%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            outline:none;
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

        .error {
            margin-top: 6px;
            font-size: 12px;
            color: #dc2626;
        }

        .note {
            margin-top: 16px;
            text-align:center;
            font-size: 12px;
            color:#64748b;
        }

        .back {
            display:block;
            text-align:center;
            margin-top: 14px;
            font-size: 13px;
            color: var(--rc-blue);
            text-decoration:none;
            font-weight: 700;
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
        <h1>Please Enter:</h1>

        <form method="POST" action="{{ route('landlord.register.store') }}">
            @csrf

            <label>Firstname:</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" required>
            @error('first_name') <div class="error">{{ $message }}</div> @enderror

            <label>Surname:</label>
            <input type="text" name="surname" value="{{ old('surname') }}" required>
            @error('surname') <div class="error">{{ $message }}</div> @enderror

            <label>Email Address:</label>
            <input type="email" name="email" placeholder="example123@rentconnect.ie" value="{{ old('email') }}" required>
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label>Phone Number:</label>
            <input type="text" name="phone" value="{{ old('phone') }}" required
                   inputmode="numeric" pattern="[0-9]*"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
            @error('phone') <div class="error">{{ $message }}</div> @enderror

            <label>Password:</label>
            <input type="password" name="password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror

            <label>Confirm Password:</label>
            <input type="password" name="password_confirmation" required>

            <button class="btn" type="submit">Submit</button>
        </form>

        <a class="back" href="/">← Back</a>

        <div class="note">
            You will be asked to verify your email after registering.
        </div>
    </div>
</div>
</body>
</html>
