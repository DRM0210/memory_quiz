<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ isset($company) && $company && $company->icon ? asset($company->icon) : asset('assets/img/favicon/icon.png') }}" />
<style>
    @import "https://unpkg.com/open-props";
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        min-height: 100vh;
        font-family: var(--font-sans);
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
        color: #333;
    }
    .layout { display: flex; min-height: 100vh; }
    .navbar {
        background: linear-gradient(135deg, #433532, #c53b0d);
        color: white;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .navbar__brand { font-weight: 700; font-size: 1.25rem; }
    .sidebar {
        width: 280px;
        min-width: 280px;
        background: #fff;
        box-shadow: 4px 0 20px rgba(0,0,0,0.06);
        padding: 1.5rem 0;
        display: flex;
        flex-direction: column;
    }
    .sidebar__card {
        margin: 0 1rem 1rem;
        padding: 1.25rem;
        background: linear-gradient(135deg, rgba(67,53,50,0.08), rgba(197,59,13,0.08));
        border-radius: 12px;
        border: 1px solid rgba(67,53,50,0.12);
    }
    .sidebar__card h3 { font-size: 0.9rem; color: #433532; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .sidebar__detail { font-size: 0.9rem; margin-bottom: 0.5rem; }
    .sidebar__detail strong { display: inline-block; min-width: 70px; color: #555; }
    .sidebar .btn-logout {
        display: block;
        width: calc(100% - 2rem);
        margin: 1rem 1rem 0;
        padding: 0.6rem 1rem;
        background: linear-gradient(135deg, #433532, #c53b0d);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
    }
    .sidebar .btn-logout:hover { color: white; opacity: 0.95; }
    .main {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
    }
    .main__content {
        flex: 1;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }
    .main__inner { max-width: 700px; width: 100%; }
    .card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }
    .card__title { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; color: #433532; }
    .card__subtitle { color: #666; font-size: 0.95rem; margin-bottom: 1.5rem; }
    .quiz-card {
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        background: #fff;
        transition: box-shadow 0.2s ease;
    }
    .quiz-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
    .quiz-card h3 { font-size: 1.1rem; margin-bottom: 0.35rem; color: #433532; }
    .quiz-card .meta { font-size: 0.85rem; color: #666; margin-bottom: 0.75rem; }
    .btn-start-quiz {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #433532, #c53b0d);
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
    }
    .btn-start-quiz:hover { color: white; opacity: 0.95; }
    @media (max-width: 768px) {
        .layout { flex-direction: column; }
        .sidebar { width: 100%; min-width: 0; flex-direction: row; flex-wrap: wrap; padding: 1rem; }
        .sidebar__card { flex: 1 1 100%; }
    }
</style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar__card">
                <h3>Student Details</h3>
                <div class="sidebar__detail"><strong>Name</strong> {{ $student->name }}</div>
                <div class="sidebar__detail"><strong>Email</strong> {{ $student->email }}</div>
                <div class="sidebar__detail"><strong>Phone</strong> {{ $student->phone }}</div>
                @if($student->address)
                    <div class="sidebar__detail"><strong>Address</strong> {{ $student->address }}</div>
                @endif
            </div>
            <form action="{{ route('student.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </aside>
        <div class="main">
            <nav class="navbar">
                <span class="navbar__brand">Student Dashboard</span>
                <span>{{ $student->name }}</span>
            </nav>
            <div class="main__content">
                <div class="main__inner">
                    @if (session('success'))
                        <div class="card" style="background: #d1fae5; border-color: #10b981;">
                            <p class="mb-0">{{ session('success') }}</p>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="card" style="background: #fee2e2; border-color: #ef4444;">
                            <p class="mb-0">{{ session('error') }}</p>
                        </div>
                    @endif
                    <div class="card">
                        <h2 class="card__title">Available Quizzes</h2>
                        <p class="card__subtitle">Select a quiz to start.</p>
                        @if(isset($availableQuizzes) && $availableQuizzes->count() > 0)
                            @foreach($availableQuizzes as $quiz)
                            <div class="quiz-card">
                                <h3>{{ $quiz->name }}</h3>
                                <p class="meta">Questions: {{ $quiz->questions_count }} · Memory: {{ $quiz->memory_time ?? 0 }}s · Total: {{ $quiz->quiz_time }}s</p>
                                <a href="{{ route('student.quiz.play', $quiz->id) }}" class="btn-start-quiz">Start Quiz</a>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted mb-0">No quizzes available at the moment.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
