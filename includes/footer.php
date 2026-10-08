      <div class="footer">Audio Zone · Feel the Sound</div>
    </main>
  </div>

  <div
    id="loginModal"
    class="login-modal-overlay"
    role="dialog"
    aria-modal="true"
    aria-labelledby="loginModalTitle"
    hidden
  >

    <div class="login-modal-card">

      <button
        id="loginModalClose"
        class="login-modal-close"
        type="button"
        aria-label="Close login dialog">
        &times;
      </button>

      <div class="login-modal-header">

        <img
          src="assets/images/audio-zone-logo.png"
          alt="Audio Zone"
          class="login-modal-logo">

        <h2 id="loginModalTitle">Welcome back</h2>

        <p>Sign in to continue listening.</p>

      </div>

      <form
        id="loginForm"
        class="login-modal-form"
        method="POST"
        action="login.php"
      >

        <div class="field">

          <label for="loginEmail">Email</label>

          <div class="input-wrap">

            <svg
              class="field-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round"
              aria-hidden="true">

              <rect x="3" y="5" width="18" height="14" rx="3"/>
              <path d="m3 7.5 9 6 9-6"/>

            </svg>

            <input
              id="loginEmail"
              type="email"
              name="email"
              required
              placeholder="you@example.com"
              autocomplete="email">

          </div>

        </div>

        <div class="field">

          <label for="loginPassword">Password</label>

          <div class="input-wrap has-toggle">

            <svg
              class="field-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round"
              aria-hidden="true">

              <rect x="5" y="11" width="14" height="9" rx="2"/>
              <path d="M8 11V7a4 4 0 0 1 8 0v4"/>

            </svg>

            <input
              id="loginPassword"
              type="password"
              name="password"
              required
              placeholder="Your password"
              autocomplete="current-password">

            <button
              type="button"
              class="toggle-pass"
              aria-label="Show password">

              <svg
                class="icon-eye"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true">

                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                <circle cx="12" cy="12" r="3"/>

              </svg>

              <svg
                class="icon-eye-off"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true">

                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                <line x1="3.5" y1="3.5" x2="20.5" y2="20.5"/>

              </svg>

            </button>

          </div>

        </div>

        <button
          type="submit"
          name="login"
          class="gold-btn login-modal-submit">
          Sign in
        </button>

        <p class="login-modal-alt">
          Don't have an account?
          <a href="register.php">Create one</a>
        </p>

      </form>

    </div>

  </div>

  <script>

    var loginModal = document.getElementById("loginModal");
    var loginClose = document.getElementById("loginModalClose");
    var loginButton = document.getElementById("topbarLoginBtn");


    function openLoginModal() {

      loginModal.hidden = false;

    }


    function closeLoginModal() {

      loginModal.hidden = true;

    }


    if (loginButton) {

      loginButton.onclick = function(event) {

        event.preventDefault();

        openLoginModal();

      };

    }


    if (loginClose) {

      loginClose.onclick = function() {

        closeLoginModal();

      };

    }


    if (loginModal) {

      loginModal.onclick = function(event) {

        if (event.target === loginModal) {

          closeLoginModal();

        }

      };

    }


    var passwordButton = document.querySelector(".toggle-pass");
    var passwordInput = document.getElementById("loginPassword");


    if (passwordButton && passwordInput) {

      passwordButton.onclick = function() {

        if (passwordInput.type == "password") {

          passwordInput.type = "text";
          passwordButton.setAttribute("aria-label", "Hide password");

        } else {

          passwordInput.type = "password";
          passwordButton.setAttribute("aria-label", "Show password");

        }

      };

    }


    document.addEventListener("click", function(event) {

      if (window.isLoggedIn) {
        return;
      }

      var card = event.target.closest(
        ".track-card, .artist-card, .album-card, .genre-chip"
      );

      if (card) {

        event.preventDefault();

        openLoginModal();

      }

    });

  </script>

</body>
</html>