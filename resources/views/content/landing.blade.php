<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RK Vidhyapeeth - Memory Quiz</title>
    <link rel="icon" type="image/x-icon" href="{{ $company && $company->icon ? asset($company->icon) : asset('assets/img/favicon/icon.png') }}" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            font-family: system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }
        .landing__logo {
            max-width: 120px;
            height: auto;
            margin-bottom: 1.5rem;
            opacity: 0.95;
        }
        .landing__brand {
            font-size: clamp(1.75rem, 5vw, 2.5rem);
            font-weight: 700;
            letter-spacing: 0.02em;
            margin-bottom: 0.35rem;
            color: #fff;
        }
        .landing__tagline {
            font-size: clamp(1.1rem, 3vw, 1.4rem);
            font-weight: 500;
            color: rgba(255,255,255,0.85);
            margin-bottom: 2.5rem;
        }
        .landing__cta {
            display: inline-block;
            padding: 1rem 2.5rem;
            background: linear-gradient(135deg, #c53b0d, #e85d34);
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(197, 59, 13, 0.4);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .landing__cta:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(197, 59, 13, 0.5);
        }
        .landing__footer {
            margin-top: 3rem;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.5);
        }
    </style>
</head>
<body>
    @if($company && $company->logo)
        <img src="{{ asset($company->logo) }}" alt="RK Vidhyapeeth" class="landing__logo">
    @endif
    <h1 class="landing__brand">RK Vidhyapeeth</h1>
    <p class="landing__tagline">Memory Quiz</p>
    <a href="{{ route('student.login') }}" class="landing__cta">Student Sign In</a>
    <p class="landing__footer">© RK Vidhyapeeth</p>
</body>
</html>
