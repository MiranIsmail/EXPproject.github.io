function createAccount() {
    let xemail = document.getElementById('email').value;
    let xfirst_name = document.getElementById('fname').value;
    let xlast_name = document.getElementById('lname').value;
    let xpassword = document.getElementById('pword').value;


    fetch('http://193.11.187.227:5000/account', {
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            // "Content-Type": "multipart/form-data",
        },
        method: 'PUT',
        body: JSON.stringify({ 'first_name': xfirst_name, 'last_name': xlast_name, 'password': xpassword, 'email': xemail })
    }).then(response => response.json())
    open("LogIn.html")
}


function logIn() {
    let femail = document.getElementById('fetchEmail').value;
    let fpword = document.getElementById('fetchPword').value;

    fetch('http://193.11.187.227:5000/account?email=' + femail + "&password=" + fpword)
        .then((response) => response.json())
        .then((data) => { alert(data) });
}
