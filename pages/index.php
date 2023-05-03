<?php include '../assets/head.php'; ?>

<body>
  <?php include '../assets/navbar.php'; ?>
  <!--run bar-->
  <img class="mx-auto d-block bg-logo" alt="Logo" src="../images/RASTS.svg" id="logo">
  <div>
    <img class="w-100 op30" src="../images/indeximage_thinner.png" alt="Running figures" id="image_run">
    <div style="padding-bottom: 2rem;" id="searchFade" class="mx-auto">
      <h1 id="underline_text">Search for accounts</h1>
    <div class="wrapper drop_shadow">
      <div class="searchBar" style="padding-bottom: 2rem;">
        <input id="search_profile" type="text" name="search_profile_input" placeholder="Search for account" value="">
        <button id="search_profile_submit" type="submit" name="search_profile_submit" onclick="search_account()">
          <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="#666666" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
          </svg>
        </button>
      </div>
    </div>
      <h1 id="underline_text">Popular events</h1>
    </div>
  </div>

  <script>
  const searchInput = document.getElementById("search_profile");
  searchInput.addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
      event.preventDefault(); // prevent form submission
      search_account();
    }
  });
</script>


  <!--Temporary events-->
  <div class="events section w-100" style="padding-bottom: 4rem;">
    <div id="event_cards_dynamic"></div>
  </div>

  <!--Footer-->
  <?php include '../assets/footer.php'; ?>
</body>
<script>
  data_load_index_topten()
</script>

</html>