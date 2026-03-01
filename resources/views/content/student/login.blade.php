<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $company && $company->name ? $company->name . ' - Student Login' : 'Student Login' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ $company && $company->icon ? asset($company->icon) : asset('assets/img/favicon/icon.png') }}" />
<style>
    @import "https://unpkg.com/open-props";
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    *:focus { outline-offset: 4px; }
    button, input { font: inherit; }
    .page {
        color: white;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        background-image: url({{ asset('assets/img/backgrounds/bc.jpg') }});
        display: grid;
        grid-template-areas: "main";
        padding: var(--size-4);
        min-height: 100vh;
        font-family: var(--font-sans);
    }
    .page__main { grid-area: main; }
    .main { display: grid; align-items: center; justify-items: center; }
    .main__form { margin-inline: auto; max-width: 26rem; width: 100%; }
    .auth-form {
        color: #433532;
        display: grid;
        row-gap: var(--size-4);
        position: relative;
        width: 100%;
        padding: var(--size-8);
        border-radius: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
        background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.65), rgba(255, 255, 255, 0.3));
        backdrop-filter: blur(10px);
    }
    .auth-form__title { margin-top: var(--size-4); margin-bottom: var(--size-4); font-weight: var(--font-weight-6); font-size: var(--font-size-5); text-align: center; }
    .auth-form__logo { display: block; margin-inline: auto; margin-bottom: var(--size-4); max-width: 8rem; height: auto; object-fit: contain; }
    .auth-form__label { display: grid; row-gap: 0.35rem; font-size: 0.95rem; }
    .auth-form__input {
        color: inherit;
        width: 100%;
        padding: 0.8em 0.9em;
        border-radius: var(--radius-2);
        border: 1px solid rgba(0, 0, 0, 0.08);
        background-color: rgba(255, 255, 255, 0.85);
        transition: border-color 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
    }
    .auth-form__input:focus {
        border-color: #c53b0d;
        box-shadow: 0 0 0 3px rgba(197, 59, 13, 0.28);
        background-color: #ffffff;
    }
    .input-wrap { position: relative; }
    .input-wrap .auth-form__input { padding-right: 2.75rem; }
    .pw-toggle {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: 0;
        cursor: pointer;
        padding: 0.25rem;
        color: #666;
    }
    .pw-toggle:hover { color: #c53b0d; }
    .primary-btn {
        color: white;
        background-image: linear-gradient(135deg, #433532, #c53b0d);
        padding: 0.9em 1.4em;
        border: 0;
        border-radius: var(--radius-2);
        cursor: pointer;
        width: 100%;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        transition: transform 0.12s ease, box-shadow 0.12s ease, filter 0.12s ease;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.35);
    }
    .primary-btn:hover { filter: brightness(1.03); transform: translateY(-1px); box-shadow: 0 14px 30px rgba(0, 0, 0, 0.4); }
    .auth-form__footer { margin-top: var(--size-5); text-align: center; font-size: 0.9rem; }
    .auth-form__link { color: inherit; text-decoration: none; opacity: 0.9; }
    .auth-form__link:hover { text-decoration: underline; opacity: 1; }
    .invalid-feedback { display: block; color: #c53b0d; font-size: 0.85rem; margin-top: 0.25rem; }
</style>
</head>
<body class="page">
    <main class="main page__main">
        <form class="auth-form main__form" action="{{ route('student.login.post') }}" method="POST">
            @csrf
            <img src="{{ $company && $company->logo ? asset($company->logo) : asset('assets/img/favicon/ispl_logo.png') }}" class="auth-form__logo" alt="Logo">
            <h3 class="auth-form__title">Student Login</h3>
            <label class="auth-form__label" for="login">
                <input class="auth-form__input" type="text" id="login" name="login" value="{{ old('login') }}" placeholder="Email or Phone" required/>
                @if ($errors->has('login'))<span class="invalid-feedback">{{ $errors->first('login') }}</span>@endif
            </label>
            <label class="auth-form__label">
                <div class="input-wrap">
                    <input class="auth-form__input" type="password" id="password" name="password" placeholder="Password" required/>
                    <button type="button" class="pw-toggle" aria-label="Show password">
                        <svg class="eye-open" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/></svg>
                        <svg class="eye-closed" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="display:none;"><path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709z"/></svg>
                    </button>
                </div>
                @if ($errors->has('password'))<span class="invalid-feedback">{{ $errors->first('password') }}</span>@endif
            </label>
            <label class="auth-form__label" style="flex-direction: row; align-items: center; gap: 0.5rem;">
                <input type="checkbox" name="remember" value="1"/> Remember me
            </label>
            <button class="primary-btn" type="submit">Login</button>
            <div class="auth-form__footer">
                Don't have an account? <a class="auth-form__link" href="{{ route('student.signup') }}">Sign Up</a>
            </div>
        </form>
    </main>
    <script>
    document.querySelectorAll('.pw-toggle').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = this.closest('.auth-form__label').querySelector('input[type="password"], input[type="text"]');
            if (!input) return;
            var open = this.querySelector('.eye-open');
            var closed = this.querySelector('.eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                open.style.display = 'none';
                closed.style.display = 'block';
            } else {
                input.type = 'password';
                open.style.display = 'block';
                closed.style.display = 'none';
            }
        });
    });
    </script>
</body>
</html>
