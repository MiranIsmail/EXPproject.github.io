class Navbar extends HTMLElement {
    constructor() {
      super();
    }

  connectedCallback() {
    this.innerHTML = `
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>EXP Initiative</title>
        <meta charset="utf-8">
        <!--Tre librarys dont remove, Bootstrap 5-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="stylesheet.css">
        <script src="assets/footer.js" type="text/javascript" defer></script>
        <script type="text/javascript" src="javascripts.js"></script>
    </head>


      <style>
      #navtext{
        font-size: 1.3rem;
        font-weight: bold;
    }
    #navtext:hover{
        color: #fff;
    }
      </style>
      <header>
      <nav class="navbar navbar-expand-sm navbar-dark bg-30">
      <div class="container-fluid">
          <a class="navbar-brand" href="index.html"><img class="w-50" src="images/logoboll.svg"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
              <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                      <a class="nav-link" href="event.html" id="navtext">EVENT</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="profile.html" id="navtext">PROFIL</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="Login.html" id="navtext">LOG IN</a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>
      </header>
    `;
  }
}

customElements.define('exp-navbar', Navbar);