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
            Event
          </div>
          <div class="col" id="footer-items">
            Log In
          </div>
          <div class="col" id="footer-items">
            Profil
          </div>
        </div>
      </div>
    </footer>
      </footer>
    `;
  }
}

customElements.define('exp-footer', Header);