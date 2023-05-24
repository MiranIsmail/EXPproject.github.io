<style>
    .navtext {
        font-size: 1.3rem;
        font-weight: bold;
        color: #ffffffe1;
    }

    .navtext:hover {
        color: #d4fefe;
    }
</style>
      <!-- Cookie Modal -->
    <div class="modal fade" id="cookieModal" tabindex="-1" role="dialog" aria-labelledby="cookieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cookieModalLabel">Cookie Policy</h5>
        </div>
        <div class="modal-body">
          <p>We use cookies to personalize content, provide social media features and to analyze our traffic. We also share information about your use of our site with our social media, advertising and analytics partners who may combine it with other information that you’ve provided to them or that they’ve collected from your use of their services.</p>
          <p>By continuing to use our website, you consent to our use of cookies.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Accept</button>
        </div>
      </div>
    </div>
  </div>
<nav class="navbar navbar-expand-sm navbar-dark bg-30">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img class="w-50" alt="rasts icon" src="../images/s_black.svg"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link navtext" href="../pages/index.php">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navtext" href="../pages/event.php">EVENTS</a>
                </li>
                <?php if ($is_logged_in_org) { ?>
                    <li class="nav-item">
                        <a class="nav-link navtext" href="../pages/track.php">TRACKS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navtext" href="../pages/resource.php">RESOURCES</a>
                    </li>
                <?php
                }
                if ($is_logged_in) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link navtext" href="../pages/profile.php" id="navbar-profile">PROFILE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navtext" href="" id="navbar-log-out" onclick="log_out()">LOG OUT</a>
                    </li>
                <?php
                } else {
                ?><li class="nav-item">
                        <a class="nav-link navtext" href="../pages/Login.php" id="navbar-log-in">LOG IN</a>
                    </li><?php
                        }

                            ?>


            </ul>
        </div>
    </div>
</nav>