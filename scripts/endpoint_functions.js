const BASE_ULR = "https://rasts.se/api/";

async function create_account_endpoint(email, first_name, last_name, password, username) {
    response = await fetch(BASE_ULR + "Account", {
        method: 'POST',
        body: JSON.stringify({
            email: email,
            first_name: first_name,
            last_name: last_name,
            password: password,
            username: username
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    });
    return await response.json();
}

async function get_token_endpoint(email, password) {
    const response = await fetch(BASE_ULR + "Token", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email: email, password: password }),
    });
    data = await response.json();
    return data["auth_token"];
}

async function get_user_details_endpoint(token) {
    const response = await fetch(BASE_ULR + "Account", {
        method: "GET",
        headers: { Authorization: token },
    });
    return await response.json();
}

async function get_account_details_endpoint(username) {
    const response = await fetch(BASE_ULR + "Account/" + username, {
        method: "GET",
    });
    return await response.json();
}

async function edit_user_details_endpoint(first_name = null, last_name = null, birthdate = null, height = null, weight = null, chip_id = null, pimage = null) {

    parameters = { "first_name": first_name, "last_name": last_name, "birthdate": birthdate, "height": height, "weight": weight, "chip_id": chip_id, "pimage": pimage }
    for (const [key, value] of Object.entries(parameters)) {
        if (!value) {
            delete parameters[key];
        }
    }
    response = await fetch(BASE_ULR + "Account", {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
            Authorization: get_cookie("auth_token"),
        },
        body: JSON.stringify(parameters),
    });

    return await response.json();
}

async function get_user_result_endpoint(token) {
    const response = await fetch(BASE_ULR + "Results/?token=" + token);
    return await response.json();
}

async function get_result_endpoint(result_id) {
    const response = await fetch(BASE_ULR + "Results/" + result_id);
    return await response.json();
}

async function get_event_results_endpoint(event_id) {
    const response = await fetch(BASE_ULR + "Results/?event_id=" + event_id);
    return await response.json();
}

async function get_account_result_endpoint(username) {
    const response = await fetch(BASE_ULR + "Results/?username=" + username);
    return await response.json();
}

async function get_event_endpoint(event_id) {
    const response = await fetch(BASE_ULR + "Event/" + event_id);
    return await response.json();
}

async function get_track_checkpoints_endpoint(track_name) {
    const response = await fetch(BASE_ULR + "Checkpoints?track_name=" + track_name);
    return await response.json();
}

function create_track_endpoint(track_name, start_station, end_station) {
    xhr = new XMLHttpRequest();
    xhr.open("POST", BASE_ULR + "Track", false); // false makes the request synchronous
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.send(
        JSON.stringify({
            track_name: track_name,
            start_station: start_station,
            end_station: end_station,
        })
    );
}

async function create_checkpoint_endpoint(
    trackname,
    startid,
    endid,
    dist,
    terrain,
    longitude,
    latitude,
    number
) {
    await fetch(BASE_ULR + "Checkpoint", {
        method: "POST",
        body: JSON.stringify({
            track_name: trackname,
            station_id: startid,
            next_id: endid,
            next_distance: dist,
            terrain: terrain,
            longitude: longitude,
            latitude: latitude,
            checkpoint_number: number,
        }),
        headers: { "Content-Type": "application/json; charset=UTF-8" },
    });
}

async function create_event_endpoint(
    event_name,
    track_name,
    username,
    startdate,
    enddate,
    eimage,
    description,
    sport,
    open_for_entry,
    public_view
) {
    parameters = { "event_name": event_name, "track_name": track_name, "username": username, "start_time": startdate, "end_time": enddate, "image": eimage, "description": description, "sport": sport, "open_for_entry": open_for_entry, "public_view": public_view }
    for (const [key, value] of Object.entries(parameters)) {
        if (!value) {
            delete parameters[key];
        }
    }
    response = await fetch(BASE_ULR + "Event", {
        method: "POST",
        body: JSON.stringify(parameters),
        headers: { "Content-Type": "application/json; charset=UTF-8" },
    });
    return await response.json();
}

async function get_all_tracks_endpoint() {
    const response = await fetch(BASE_ULR + "Track");
    return await response.json();
}

async function generate_event_results(event_id) {
    const response = await fetch(BASE_ULR + "Results?event_id=" + event_id);
    return await response.json();
}

async function register_event_endpoint(event_id, token, chip_id) {
    parameters = { "event_id": event_id, "token": token, "chip_id": chip_id }
    const response = await fetch(BASE_ULR + "Registration", {
        method: "POST",
        body: JSON.stringify(parameters),
    });
    return await response.json();
}



