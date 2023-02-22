class Header extends HTMLElement {
    constructor() {
      super();
    }

  connectedCallback() {
    this.innerHTML = `
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
       justify-content: center;
   }
      </style>

      <footer>
      <footer class="container-fluid w-100" id="footer-container">
      <div class="container">
        <div class="row">
          <div class="col" id="footer-items">
          <a style="text-decoration: none; color:white;" href="event.html">Event</a>
          </div>
          <div class="col" id="footer-items">
          <a style="text-decoration: none; color:white;" href="Login.html">Log In</a>
          </div>
          <div class="col" id="footer-items">
            <a style="text-decoration: none; color:white;" href="profile.html">Profil</a>
          </div>
        </div>
      </div>
    </footer>
      </footer>
    `;
  }
}

customElements.define('exp-footer', Header);