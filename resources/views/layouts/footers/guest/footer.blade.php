<!-- -------- BLOODCONNECT FOOTER ------- -->
<footer class="footer py-5">
  <div class="container">
    <div class="row">

      <!-- FOOTER LINKS -->
      <div class="col-lg-8 mb-4 mx-auto text-center">

        <a href="#" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
          About BloodConnect
        </a>

        <a href="#" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
          Privacy Policy
        </a>

        <a href="#" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
          Terms & Conditions
        </a>

        <a href="#" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
          Contact Support
        </a>

      </div>

      @if (!auth()->user() || \Request::is('static-sign-up'))

      <!-- SOCIAL ICONS -->
      <div class="col-lg-8 mx-auto text-center mb-4 mt-2">

        <a href="#" class="text-secondary me-xl-4 me-4">
          <span class="text-lg fab fa-facebook"></span>
        </a>

        <a href="#" class="text-secondary me-xl-4 me-4">
          <span class="text-lg fab fa-twitter"></span>
        </a>

        <a href="#" class="text-secondary me-xl-4 me-4">
          <span class="text-lg fab fa-instagram"></span>
        </a>

        <a href="#" class="text-secondary me-xl-4 me-4">
          <span class="text-lg fab fa-github"></span>
        </a>

      </div>

      @endif

    </div>

    @if (!auth()->user() || \Request::is('static-sign-up'))

    <!-- COPYRIGHT -->
    <div class="row">
      <div class="col-8 mx-auto text-center mt-1">

        <p class="mb-0 text-secondary">

          Copyright ©
          <script>
            document.write(new Date().getFullYear())
          </script>

          <span style="color:#252f40;" class="font-weight-bold ml-1">
            BloodConnect
          </span>

          — AI-Powered Blood Donation and Matching Platform

        </p>

      </div>
    </div>

    @endif

  </div>
</footer>
<!-- -------- END BLOODCONNECT FOOTER ------- -->