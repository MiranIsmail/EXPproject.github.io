

/**
 * endpoint for creating an account
 * @param {string} email email of the user
 * @param {string} first_name first name of the user
 * @param {string}} last_name last name of the user
 * @param {string} password password of the user
 * @param {string} username username of the user
 * @returns a fetch response with data about the user in json format. The data includes first_name, last_name, email, username, birthdata, profile image, chip_id, height and weight.
 */
async function create_account_endpoint(email, first_name, last_name, password, username) {
    return await fetch(BASE_ULR + "Account", {
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
}

/**
 * endpoint for getting the public details of the user by thier username
 * @param {string} username username of the user
 * @returns a fetch response with data about the user in json format. The data includes the public information about the user. * 
 * */
async function get_account_details_endpoint(username) {
    return await fetch(BASE_ULR + "Account/" + username, {
        method: "GET",
    });

}

/**
 * endpoint for editing the details of the user 
 * @param {object} parameters an object with the parameters that need to be changed. The parameters are: email, first_name, last_name, password, username, birthdate, pimage, chip_id, height and weight.
 * @returns a fetch response with empty data.
 */
async function edit_user_details_endpoint(parameters) {
    return await fetch(BASE_ULR + "Account", {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
            Authorization: get_cookie("auth_token"),
        },
        body: JSON.stringify(parameters),
    });


}

/**
 * endpoint for getting the results of the user by thier token
 * @param {string} token the token of the user
 * @returns a fetch response with data about the user in json format. The data includes first_name, last_name, email, username, birthdata, profile image, chip_id, height and weight.
 */
async function get_user_details_endpoint(token) {
    return await fetch(BASE_ULR + "Account", {
        method: "GET",
        headers: { Authorization: token },
    });

}

/**
 * endpoint for getting the token of the user by thier email and password
 * @param {string} email email of the user
 * @param {string} password password of the user
 * @returns a fetch response with data about the user in json format. The data includes the token of the user. The token is active for 24 hours.
 */
async function get_token_endpoint(email, password) {
    return await fetch(BASE_ULR + "Token", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email: email, password: password }),
    });

}
/**
 * changes the token without returning any data.
 * @param {string} token the token of the user
 * @returns a fetch response with empty data.
 */
async function delete_token_endpoint(token) {
    return await fetch(BASE_ULR + "Token", {
        method: "DELETE",
        headers: { Authorization: get_cookie("auth_token") },
    });
}

/**
 * 
 * @param {string} token the token of the user
 * @returns a fetch response with data about the users results in json format. The data includes all the .
 */
async function get_user_result_endpoint(token) {
    return await fetch(BASE_ULR + "Results/?token=" + token);

}

async function get_result_endpoint(result_id) {
    return await fetch(BASE_ULR + "Results/" + result_id);

}

async function get_event_results_endpoint(event_id) {
    return await fetch(BASE_ULR + "Results/?event_id=" + event_id);

}

async function get_account_result_endpoint(username) {
    return await fetch(BASE_ULR + "Results/?username=" + username);

}

async function get_event_endpoint(event_id) {
    return await fetch(BASE_ULR + "Event/" + event_id);

}
async function get_all_event_endpoint() {
    return await fetch(BASE_ULR + "Event");

}
async function get_top_event_endpoint() {
    return await fetch(BASE_ULR + "Event?setting=topten");

}

async function get_track_checkpoints_endpoint(track_name) {
    return await fetch(BASE_ULR + "Checkpoints?track_name=" + track_name);

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

async function create_event_endpoint(parameters
) {

    return await fetch(BASE_ULR + "Event", {
        method: "POST",
        body: JSON.stringify(parameters),
        headers: { "Content-Type": "application/json; charset=UTF-8" },
    });
}

async function get_all_tracks_endpoint() {
    const response = await fetch(BASE_ULR + "Track");
    return await response.json();
}

async function generate_event_results_endpoint(event_id) {
    const response = await fetch(BASE_ULR + "Results?event_id=" + event_id);
    return await response.json();
}

async function register_event_endpoint(parameters) {
    const response = await fetch(BASE_ULR + "Registration", {
        method: "POST",
        body: JSON.stringify(parameters),
    });
    return await response.json();
}