<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
        .result-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            padding: 2.5rem;
            max-width: 420px;
            width: 100%;
            text-align: center;
        }
        .result-card h1 { font-size: 1.5rem; color: #433532; margin-bottom: 0.5rem; }
        .result-card .quiz-name { color: #666; font-size: 0.95rem; margin-bottom: 1.5rem; }
        .score-circle {
            width: 120px; height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #433532, #c53b0d);
            color: white;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .score-circle .num { font-size: 2.25rem; font-weight: 700; line-height: 1; }
        .score-circle .den { font-size: 0.9rem; opacity: 0.9; }
        .result-card .message { font-size: 1rem; color: #333; margin-bottom: 1.5rem; }
        .btn-dashboard {
            display: inline-block;
            padding: 0.75rem 1.75rem;
            background: linear-gradient(135deg, #433532, #c53b0d);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-dashboard:hover { color: white; opacity: 0.95; }
    </style>
</head>
<body>
    <div class="result-card">
        <h1>Result</h1>
        <p class="quiz-name">{{ $attempt->quizMaster->name }}</p>
        <div class="score-circle">
            <span class="num">{{ $score }}</span>
            <span class="den">/ {{ $total }}</span>
        </div>
        <p class="message">
            @if($total > 0)
                You got <strong>{{ $score }}</strong> out of <strong>{{ $total }}</strong> correct.
            @else
                No questions in this quiz.
            @endif
        </p>
        <a href="{{ route('student.dashboard') }}" class="btn-dashboard">Back to Dashboard</a>
    </div>
</body>
</html>
