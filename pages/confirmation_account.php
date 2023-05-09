<?php
include '../assets/head.php';
?>

<body>
  <?php include '../assets/navbar.php'; ?>
<div class="container">
  <h1 class="mx-auto" style="text-align: center; padding-top: 20rem;">Thank You for Creating an Account!</h1>
  <p class="mx-auto" style="text-align: center;">Please check your email inbox to confirm your email.</p>
  <p class="mx-auto" style="text-align: center;">You will be redirected in <span id="countdown">3</span> seconds.</p>
</div>

<?php include '../assets/footer.php'; ?>
<script>
    window.onload = function() {
      var count = 3;
      var countdown = setInterval(function() {
        document.getElementById("countdown").innerHTML = count;
        count--;
        if (count < 0) {
          clearInterval(countdown);
          window.location.href = "Login.php"; // Change this URL to the desired redirect URL
        }
      }, 1000);
    }
  </script>
</body>

</html>