<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz: {{ $quiz->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #f0f2f5; min-height: 100vh; }
        .navbar {
            background: linear-gradient(135deg, #433532, #c53b0d);
            color: white;
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a { color: white; text-decoration: none; }
        .container { max-width: 900px; margin: 0 auto; padding: 1.5rem; }

        /* Memory phase */
        #memory-phase { text-align: center; padding: 1rem 0; }
        #memory-phase .memory-title { font-size: 1.25rem; margin-bottom: 1rem; color: #333; }
        #memory-phase .memory-img { max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .timer-wrap { margin-top: 1.5rem; }
        .timer-circle {
            width: 80px; height: 80px; border-radius: 50%;
            background: linear-gradient(135deg, #433532, #c53b0d);
            color: white;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.75rem; font-weight: 700;
        }
        .timer-label { display: block; margin-top: 0.5rem; font-size: 0.9rem; color: #666; }
        .btn-next-phase {
            margin-top: 1.5rem;
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, #433532, #c53b0d);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: none;
        }
        .btn-next-phase.show { display: inline-block; }

        /* Questions phase - one at a time */
        #questions-phase { display: none; }
        #questions-phase.show { display: block; }
        .question-step { display: none; }
        .question-step.active { display: block; }
        .q-navigation { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; flex-wrap: wrap; gap: 0.75rem; }
        .q-timer { font-weight: 600; color: #433532; }
        .q-timer.warning { color: #c53b0d; }
        .q-timer.done { color: #dc2626; }
        .btn-next-q {
            padding: 0.6rem 1.25rem;
            background: linear-gradient(135deg, #433532, #c53b0d);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-next-q:hover { opacity: 0.95; }
        .overall-timer {
            position: sticky; top: 0; z-index: 10;
            background: #fff; padding: 0.75rem 1rem; margin: -1.5rem -1.5rem 1rem -1.5rem;
            border-radius: 12px 12px 0 0;
            font-weight: 600; color: #433532;
        }
        .overall-timer.warning { color: #c53b0d; }
        .overall-timer.done { color: #dc2626; }
        .q-block {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        .q-block h3 { font-size: 1rem; color: #433532; margin-bottom: 1rem; }
        .q-img { max-width: 100%; max-height: 200px; object-fit: contain; margin-bottom: 1rem; border-radius: 6px; }
        .options { display: grid; gap: 0.75rem; }
        .option-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }
        .option-label:hover { border-color: #c53b0d; background: #fff5f2; }
        .option-label input { display: none; }
        .option-label input:checked + .option-content { font-weight: 600; }
        .option-label:has(input:checked) { border-color: #c53b0d; background: #fff5f2; }
        .option-content { display: flex; align-items: center; gap: 0.5rem; }
        .option-content img { width: 48px; height: 48px; object-fit: contain; border-radius: 4px; }
        .btn-submit {
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, #433532, #c53b0d);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
        }
        .quiz-timer-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 4px;
            background: #c53b0d;
            width: 100%;
            transform-origin: left;
            z-index: 100;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <span>{{ $quiz->name }}</span>
        <span id="nav-timer">Quiz in progress</span>
    </div>

    <div class="container">
        <!-- Phase 1: Memory page with timer -->
        <div id="memory-phase">
            <p class="memory-title">स्मरण-पृष्ठ (Memory Page) — Memorize the items. Time remaining:</p>
            @if($quiz->memory_page_image)
                <img src="{{ asset($quiz->memory_page_image) }}" alt="Memory page" class="memory-img">
            @else
                <p class="text-muted">No memory page image.</p>
            @endif
            <div class="timer-wrap">
                <div class="timer-circle" id="countdown">{{ $memoryTime }}</div>
                <span class="timer-label">seconds (memory page) — then quiz starts automatically</span>
            </div>
        </div>

        <!-- Phase 2: Questions (one at a time) -->
        <div id="questions-phase">
            <div class="overall-timer" id="overall-timer"></div>
            <form action="{{ route('student.quiz.submit', $quiz->id) }}" method="POST" id="quiz-form">
                @csrf
                @foreach($quiz->questions as $index => $q)
                <div class="question-step q-block" data-index="{{ $index }}">
                    <h3>Question {{ $index + 1 }} of {{ $quiz->questions->count() }}</h3>
                    @if($q->question_image)
                        <img src="{{ asset($q->question_image) }}" alt="Question" class="q-img">
                    @endif
                    <div class="options">
                        @foreach($q->options as $opt)
                        <label class="option-label">
                            <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt->id }}">
                            <span class="option-content">
                                @if($opt->image)
                                    <img src="{{ asset($opt->image) }}" alt="{{ $opt->label }}">
                                @endif
                                <span>{{ $opt->label }}</span>
                            </span>
                        </label>
                        @endforeach
                    </div>
                    <div class="q-navigation">
                        <span class="q-timer" id="q-timer-{{ $index }}">30 sec</span>
                        @if($index < $quiz->questions->count() - 1)
                            <button type="button" class="btn-next-q" data-next="{{ $index + 1 }}">Next →</button>
                        @else
                            <button type="submit" class="btn-submit">Submit Quiz</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </form>
        </div>
    </div>

    <script>
    (function() {
        var memoryTime = {{ $memoryTime }};
        var quizTimeTotal = {{ $quizTime }};
        var countdownEl = document.getElementById('countdown');
        var memoryPhase = document.getElementById('memory-phase');
        var questionsPhase = document.getElementById('questions-phase');
        var navTimer = document.getElementById('nav-timer');
        var overallTimerEl = document.getElementById('overall-timer');
        var quizForm = document.getElementById('quiz-form');
        var questionsPhaseStartedAt = null;

        function showQuestions() {
            memoryPhase.style.display = 'none';
            questionsPhase.classList.add('show');
            questionsPhaseStartedAt = Date.now();
            var remainingForQuestions = Math.max(0, quizTimeTotal - memoryTime);
            if (remainingForQuestions > 0) {
                var r = remainingForQuestions;
                overallTimerEl.textContent = 'Time remaining: ' + r + ' sec';
                overallTimerEl.classList.remove('done');
                if (r <= 30) overallTimerEl.classList.add('warning');
                var qt = setInterval(function() {
                    r--;
                    overallTimerEl.textContent = 'Time remaining: ' + r + ' sec';
                    if (r <= 30) overallTimerEl.classList.add('warning');
                    if (r <= 10) overallTimerEl.classList.add('done');
                    if (r <= 0) {
                        clearInterval(qt);
                        overallTimerEl.textContent = 'Time\'s up!';
                        quizForm.submit();
                    }
                }, 1000);
            } else {
                overallTimerEl.style.display = 'none';
            }
            if (totalQuestions > 0) showQuestion(0);
        }

        if (memoryTime > 0) {
            var remaining = memoryTime;
            countdownEl.textContent = remaining;
            var t = setInterval(function() {
                remaining--;
                countdownEl.textContent = remaining;
                if (remaining <= 0) {
                    clearInterval(t);
                    showQuestions();
                }
            }, 1000);
        } else {
            showQuestions();
        }

        var totalQuestions = document.querySelectorAll('.question-step').length;
        var currentQ = 0;
        var perQuestionSec = 30;
        var questionTimerInterval = null;

        function showQuestion(index) {
            document.querySelectorAll('.question-step').forEach(function(el) { el.classList.remove('active'); });
            var step = document.querySelector('.question-step[data-index="' + index + '"]');
            if (step) step.classList.add('active');
            currentQ = index;
            var timerEl = document.getElementById('q-timer-' + index);
            if (!timerEl) return;
            var sec = perQuestionSec;
            timerEl.textContent = sec + ' sec';
            timerEl.classList.remove('warning', 'done');
            if (questionTimerInterval) clearInterval(questionTimerInterval);
            questionTimerInterval = setInterval(function() {
                sec--;
                timerEl.textContent = sec + ' sec';
                if (sec <= 10) timerEl.classList.add('done');
                else if (sec <= 15) timerEl.classList.add('warning');
                if (sec <= 0) {
                    clearInterval(questionTimerInterval);
                    if (index < totalQuestions - 1) {
                        showQuestion(index + 1);
                    } else {
                        quizForm.submit();
                    }
                }
            }, 1000);
        }

        questionsPhase.addEventListener('click', function(e) {
            var btn = e.target.closest('.btn-next-q');
            if (!btn) return;
            e.preventDefault();
            var nextIndex = parseInt(btn.getAttribute('data-next'), 10);
            if (questionTimerInterval) clearInterval(questionTimerInterval);
            if (nextIndex < totalQuestions) {
                showQuestion(nextIndex);
            }
        });
    })();
    </script>
    <script>
    (function() {
        history.pushState(null, '', location.href);
        window.addEventListener('popstate', function() {
            history.pushState(null, '', location.href);
        });
    })();
    </script>
    <script>
    (function() {
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
        document.addEventListener('keydown', function(e) {
            var k = e.key || e.keyCode;
            if (k === 'F5' || k === 116) { e.preventDefault(); return; }
            if (e.ctrlKey && (k === 'r' || k === 'R' || k === 82)) { e.preventDefault(); return; }
            if (e.ctrlKey && e.shiftKey && (k === 'r' || k === 'R' || k === 82)) { e.preventDefault(); }
        });
        window.addEventListener('beforeunload', function(e) {
            e.preventDefault();
            e.returnValue = 'Reload or leaving will end your quiz. Are you sure?';
            return e.returnValue;
        });
    })();
    </script>
</body>
</html>
