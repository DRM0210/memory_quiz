<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emt App Admin</title>
    <link rel="icon" type="image/x-icon" href="{{ $company && $company->icon ? asset($company->icon) : asset('assets/img/favicon/icon.png') }}" />
<style>
    @import "https://unpkg.com/open-props";
*,
*::before,
*::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box; }

*:focus {
  outline-offset: 4px; }

button,
input {
  font: inherit; }

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
  font-family: var(--font-sans); }
  .page__main {
    grid-area: main; }

.main {
  display: grid;
  align-items: center; }
  .main__login-form {
    margin-inline: auto;
    max-width: 25em; }

.login-form {
  color: #433532;
  display: grid;
  position: relative;
  width: 100%;
  padding: var(--size-8);
  border: 1px solid rgba(255, 255, 255, 0.4);
    border-radius: 1em; }
  .login-form::before {
    background: rgba(255, 255, 255, 0.3);
    position: absolute;
    inset: 0;
    border-radius: inherit;
    content: "";
    z-index: -4000;
    box-shadow: 0 0 2em rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(5px); }
  .login-form__title {
    margin-bottom: var(--size-6);
    font-weight: var(--font-weight-6);
    font-size: var(--font-size-5);
    text-align: center; }
  .login-form__label {
    margin-bottom: var(--size-4);
    display: grid; }
  .login-form__input {
    color: inherit;
    width: 100%;
    padding: 0.8em;
    border: 0;
      border-radius: var(--radius-2); }
  .login-form__footer {
    margin-top: var(--size-5);
    display: flex;
    gap: var(--size-2);
    flex-direction: column;
    justify-content: space-between;
    align-items: center; }
    @media screen and (min-width: 36em) {
      .login-form__footer {
        flex-direction: row; } }
  .login-form__link {
    color: inherit;
    text-decoration: 0; }
    .login-form__link:hover {
      text-decoration: underline; }

.primary-btn {
  color: white;
  background-color: #433532;
  padding: 0.9em 1.4em;
  border: 0;
    border-radius: var(--radius-2);
  cursor: pointer; }
  .primary-btn:hover {
    background-color: #c53b0d; }

.sr-only {
  position: absolute;
  margin: -1px;
  width: 1px;
  height: 1px;
  padding: 0;
  border-width: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap; }




</style>
</head>
<body class="page">

    <main class="main page__main">
        <form class="login-form main__login-form" action="{{ route('login') }}" method="POST">
            @csrf
            <img src="{{ $company && $company->logo ? asset($company->logo) : asset('assets/img/favicon/ispl_logo.png') }}" class="img-fluid" alt="Company Logo">
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
    <script>
      function spark(event) {
  let i = document.createElement("i");
  // Set the position of the element based on the mouse event
  i.style.left = event.pageX + "px";
  i.style.top = event.pageY + "px";

  // Randomly scale the element
  i.style.transform = `scale(${Math.random() * 2 + 1})`;

  // Set random transition values
  i.style.setProperty("--x", getRandomTransitionValue());
  i.style.setProperty("--y", getRandomTransitionValue());
  document.body.appendChild(i);

  // Remove the element after 2 seconds
  setTimeout(() => {
    document.body.removeChild(i);
  }, 2000);
};

function getRandomTransitionValue() {
  // Generate a random value between -200 and 200 pixels
  return `${Math.random() * 400 - 200}px`;
}



    </script>
</body>

</html>
