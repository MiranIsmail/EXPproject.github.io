fetch("http://127.0.0.1:5000/event", {
    method: "GET",
    body: JSON.stringify({
        key: 'host_email',
        search_text: "a",
        completed: false
    }),
    headers: {
        "Content-type": "application/json; charset=UTF-8"
    }
});