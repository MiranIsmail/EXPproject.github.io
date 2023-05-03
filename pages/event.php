<?php
include '../assets/head.php';
?>

<body>
  <?php include '../assets/navbar.php'; ?>
  <!--Image with sporting people-------------------------------------------------------------------------------------------->
  <img class="w-100 op30" src="../images/indeximage_thinner.png" id="image_run" alt="Running figures">
  <div style="padding-bottom: 2rem;" id="searchFade">
    <!--Create event button--------------------------------------------------------------------------------------------------->

    <?php if ($is_logged_in) { ?>
      <div id="wrapper_button" class="mx-auto">
        <button type="button" id="button_style_create" onclick="location.href='eventcreate.php'">Create your own event!</button>
      </div>
    <?php } ?>
    <!--Search bar------------------------------------------------------------------------------------------------------------>
    <div class="wrapper drop_shadow">
      <div class="searchBar">
        <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="Search" value="" onkeyup="search_event()">
        <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
          <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="#666666" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
          </svg>
        </button>
      </div>
    </div>
  </div>



  <div class="events section w-100" style="padding-bottom: 4rem;">
    <div id="event_cards_dynamic"></div>
  </div>

  <?php include '../assets/footer.php'; ?>
  <script>
    data_load_index()
  </script>
</body>

</html>