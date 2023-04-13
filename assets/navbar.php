
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

<nav class="navbar navbar-expand-sm navbar-dark bg-30">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img class="w-50" src="../images/s_black.svg"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link navtext" href="../pages/index.php">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navtext" href="../pages/event.php">EVENT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navtext" href="../pages/track.php">TRACK</a>
                </li>

                <?php
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