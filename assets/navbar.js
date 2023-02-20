class Footer extends HTMLElement {
    constructor() {
      super();
    }

  connectedCallback() {
    this.innerHTML = `
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
                      <a class="nav-link" href="login.html" id="navtex">LOG IN</a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>
      </header>
    `;
  }
}

customElements.define('exp-navbar', Footer);