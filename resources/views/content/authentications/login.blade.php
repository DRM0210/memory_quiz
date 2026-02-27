<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company && $company->name ? $company->name . ' - Admin' : config('variables.templateName', 'Emt App Admin') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ $company && $company->icon ? asset($company->icon) : asset('assets/img/favicon/icon.png') }}" />
<style>
    @import "https://unpkg.com/open-props";

    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    *:focus {
        outline-offset: 4px;
    }

    button,
    input {
        font: inherit;
    }

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

    .page__main {
        grid-area: main;
    }

    .main {
        display: grid;
        align-items: center;
    }

    .main__login-form {
        margin-inline: auto;
        max-width: 26rem;
        width: 100%;
    }

    .login-form {
        color: #433532;
        display: grid;
        row-gap: var(--size-4);
        position: relative;
        width: 100%;
        padding: var(--size-8);
        border-radius: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
        background: radial-gradient(circle at top left,
                rgba(255, 255, 255, 0.65),
                rgba(255, 255, 255, 0.3));
        backdrop-filter: blur(10px);
    }

    .login-form__title {
        margin-top: var(--size-4);
        margin-bottom: var(--size-4);
        font-weight: var(--font-weight-6);
        font-size: var(--font-size-5);
        text-align: center;
    }

    .login-form__logo {
        display: block;
        margin-inline: auto;
        margin-bottom: var(--size-4);
        max-width: 8rem;
        height: auto;
        object-fit: contain;
    }

    .login-form__label {
        display: grid;
        row-gap: 0.35rem;
        font-size: 0.95rem;
    }

    .login-form__input {
        color: inherit;
        width: 100%;
        padding: 0.8em 0.9em;
        border-radius: var(--radius-2);
        border: 1px solid rgba(0, 0, 0, 0.08);
        background-color: rgba(255, 255, 255, 0.85);
        transition: border-color 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
    }

    .login-form__input:focus {
        border-color: #c53b0d;
        box-shadow: 0 0 0 3px rgba(197, 59, 13, 0.28);
        background-color: #ffffff;
    }

    .login-form__footer {
        margin-top: var(--size-5);
        display: flex;
        gap: var(--size-2);
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
    }

    @media screen and (min-width: 36em) {
        .login-form__footer {
            flex-direction: row;
        }
    }

    .login-form__link {
        color: inherit;
        text-decoration: none;
        opacity: 0.9;
    }

    .login-form__link:hover {
        text-decoration: underline;
        opacity: 1;
    }

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

    .primary-btn:hover {
        filter: brightness(1.03);
        transform: translateY(-1px);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.4);
    }

    .primary-btn:active {
        transform: translateY(0);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.32);
    }

    .sr-only {
        position: absolute;
        margin: -1px;
        width: 1px;
        height: 1px;
        padding: 0;
        border-width: 0;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
    }
</style>
</head>
<body class="page">

    <main class="main page__main">
        <form class="login-form main__login-form" action="{{ route('login') }}" method="POST">
            @csrf
            <img src="{{ $company && $company->logo ? asset($company->logo) : asset('assets/img/favicon/ispl_logo.png') }}" class="login-form__logo" alt="Company Logo">
            <h3 class="login-form__title">Login</h3>
            <label class="login-form__label" for="email">
                <span class="sr-only">Username</span>
                <input class="login-form__input" type="text" id="email" name="email" value="" placeholder="Email" required="required"/>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </label>
            <label class="login-form__label" for="password">
                <span class="sr-only">Password</span>
                <input class="login-form__input" type="password" id="password" name="password" value="" placeholder="Password" required="required"/>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </label>
            <button class="primary-btn" type="submit">Login</button>
            <!-- <div class="login-form__footer"><a class="login-form__link" href="#">Forget Password?</a><a class="login-form__link" href="#">Sign Up</a></div> -->
        </form>
    </main>
</body>

</html>
