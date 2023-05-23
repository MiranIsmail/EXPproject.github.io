async function generate_friend_results() {
    const urlParams = new URLSearchParams(window.location.search);
    g_username = urlParams.get("username");
    const response = await get_account_result_endpoint(g_username)
    const data = await response.json();

    if (data.results){
      for (let i = 0; i < data.results.results.length; i++) {
        let row = event_user_results.insertRow(i + 1)
        let cell1 = row.insertCell(0) //user1
        let cell2 = row.insertCell(1) //user2
        let cell3 = row.insertCell(2) //date
        let cell4 = row.insertCell(3) //time
        let cell5 = row.insertCell(4) //button
        cell1.innerHTML = data.results.results[i]["Competitor 1"]
        cell2.innerHTML = data.results.results[i]["Competitor 2"]
        cell3.innerHTML = data.results.results[i]["Total time"]
        cell4.innerHTML = data.results.results[i]["Event"]
        console.log("1"+data.results.results[i]["Competitor 1"])
        console.log("2"+data.results.results[i]["Competitor 2"])
        console.log("3"+data.results.results[i]["Total time"])
        console.log("4"+data.results.results[i]["Event"])
        const link_button = document.createElement('button')
        link_button.innerText = 'More Info →'
        link_button.setAttribute("class", "more_info_button");
        link_button.onclick = function() {
        window.location.href = `../pages/timetable?event_id=${data.results.ids[i]["event_id"]}&result_id=${data.results.ids[i]["result_id"]}`
      }
      cell1.setAttribute("class", "no_padding_vert")
      cell2.setAttribute("class", "no_padding_vert")
      cell3.setAttribute("class", "no_padding_vert")
      cell4.setAttribute("class", "no_padding_vert")
      cell5.setAttribute("class", "no_padding");
      cell5.appendChild(link_button)

      }}
  }

async function get_friend_info() {
  const urlParams = new URLSearchParams(window.location.search);
  g_username = urlParams.get("username");
  const response = await get_account_details_endpoint(g_username)
  const data = await response.json();

  //Just getting the source from the span. It was messy in JS.

  document.getElementById("profileName").innerHTML =
    (await data["first_name"]) + " " + (await data["last_name"]);
  document.getElementById("profile_age").innerHTML = await calculate_age(
    await data["birthdate"]
  );
  document.getElementById("profile_length").innerHTML = await data["height"];
  document.getElementById("profile_weight").innerHTML = await data["weight"];
  document.getElementById("profile_username").innerHTML = await data["username"];
  load_image(data["pimage"]);
  generate_friend_results()
}

async function get_user_info() {
  const response = await get_user_details_endpoint(get_cookie("auth_token"))
  const data = await response.json();

  //Just getting the source from the span. It was messy in JS.

  document.getElementById("profileName").innerHTML =
    (await data["first_name"]) + " " + (await data["last_name"]);
  document.getElementById("profile_age").innerHTML = await calculate_age(
    await data["birthdate"]
  );
  document.getElementById("profile_length").innerHTML = await data["height"];
  document.getElementById("profile_weight").innerHTML = await data["weight"];
  document.getElementById("profile_chip_id").innerHTML = await data["chip_id"];
  document.getElementById("profile_username").innerHTML = await data[
    "username"
  ];
  load_image(data["pimage"]);
  generate_user_results()
}


async function generate_user_results() {
  const response = await get_user_result_endpoint(get_cookie("auth_token"))
      const data = await response.json();
      if (data.results){
        for (let i = 0; i < data.results.results.length; i++) {
          let row = event_user_results.insertRow(i + 1)
          let cell1 = row.insertCell(0) //Name
          let cell2 = row.insertCell(1) //Date
          let cell3 = row.insertCell(2) //Time
          let cell4 = row.insertCell(3) //Details
          cell1.innerHTML = data.results.results[i]["Event"]
          cell2.innerHTML = data.results.results[i]["date_time"]
          cell3.innerHTML = data.results.results[i]["Total time"]
          const link_button = document.createElement('button')
          link_button.innerText = 'More Info →'
          link_button.setAttribute("class", "more_info_button");
          link_button.onclick = function() {
          window.location.href = `../pages/timetable?event_id=${data.results.ids[i]["event_id"]}&result_id=${data.results.ids[i]["result_id"]}`
        }
        cell1.setAttribute("class", "no_padding_vert")
        cell2.setAttribute("class", "no_padding_vert")
        cell3.setAttribute("class", "no_padding_vert")
        cell4.setAttribute("class", "no_padding");
        cell4.appendChild(link_button)

        }}
}

async function generate_user_upcoming() {
  const response = await get_user_details_endpoint(get_cookie("auth_token"))
    const data = await response.json();
  const response2 = await get_user_upcoming_endpoint(data["username"])
    const data2 = await response2.json();
      console.log("long: "+data2[0]["event_name"])

  if (data2){
    for (let i = 0; i < data2.length; i++) {
      let row = event_user_upcoming.insertRow(i + 1)
      let cell1 = row.insertCell(0) //Name
      let cell2 = row.insertCell(1) //Date
      let cell3 = row.insertCell(2) //Button
      cell1.innerHTML = data2[i]["event_name"]
      cell2.innerHTML = data2[i]["startdate"]
      const link_button = document.createElement('button')
      link_button.innerText = 'Go To Event →'
      link_button.setAttribute("class", "more_info_button");
      link_button.onclick = function() {
      window.location.href = '../pages/event_display.php?event_id='+data2[i]["event_id"];
    }
    cell1.setAttribute("class", "no_padding_vert")
    cell2.setAttribute("class", "no_padding_vert")
    cell3.setAttribute("class", "no_padding");
    cell3.appendChild(link_button)

    }}
}
