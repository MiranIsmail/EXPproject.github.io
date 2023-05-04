
<style>
#footer-container{
  background:#000000cc;
  }

  #footer-items{
  padding: 1rem;
  text-decoration: none;
  color: white;
  font-size: 20px;
  display: flex;
  justify-content: center;}


</style>

<footer class="text-center" id="footer-container">
  <!-- Grid container -->
  <div class="container p-4">
    <!--Grid row-->
    <div class="row">
      <!--Grid column-->
      <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">Navigation</h5>

        <ul class="list-unstyled ">
          <li>
            <a href="../pages/event.php">Event</a>
          </li>
          <li>
            <a href="../pages/Login.php">Log In</a>
          </li>
          <li>
            <a href="../pages/profile.php">Profile</a>
          </li>
        </ul>
      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">Contact</h5>

        <ul class="list-unstyled mb-0">
          <li>
            <a href="mailto:info@rasts.se">info@rasts.se</a>
          </li>
          <li>
            <a href="#!">0455 - 38 50 00</a>
          </li>
          <li>
            <a href="#!">Organisations Nr: xxxxxx-xxxx</a>
          </li>
        </ul>
      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">More info</h5>

        <ul class="list-unstyled mb-0">
          <li>
            <a href="#!">About Us</a>
          </li>
          <li>
            <a href="https://en.wikipedia.org/wiki/Swimrun">What is Swimrun?</a>
          </li>
          <li>
            <a href="https://www.karlshamnssimklubb.se/swimrun/medlem-swimrun/">Karlshamn Swimrun</a>
          </li>

        </ul>
      </div>
      <!--Grid column-->
    </div>
    <!--Grid row-->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center text-light p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2023 Copyright:
    <a class="text-light" href="https://www.bth.se/">Blekinge Institute of Technology</a>


  </div>
  <!-- Copyright -->
</footer>
<script>
  $(document).ready(function() {
    if (localStorage.getItem("cookieConsent") != "true") {
      $("#cookieModal").modal("show");
    }
    else{
      $("#cookieModal").modal("hide");
    }
  });

  $(".btn-primary").click(function() {
    localStorage.setItem("cookieConsent", true);
    $("#cookieModal").modal("hide");
  });
  </script>
  <script type="text/javascript"  src="../scripts/endpoint_functions.js"></script>
  <script type="text/javascript"  src="../scripts/tools.js"></script>
  <script type="text/javascript"  src="../scripts/js_scripts.js"></script>
  <script type="text/javascript"  src="../scripts/index_related.js"></script>
  <script type="text/javascript"  src="../scripts/event_related.js"></script>
  <script type="text/javascript"  src="../scripts/profile_related.js"></script>