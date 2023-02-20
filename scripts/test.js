function sendFunction() {
    let xemail = document.getElementById('email').value;
    let xfirst_name = document.getElementById('fname').value;
    let xlast_name = document.getElementById('lname').value;
    let xpassword = document.getElementById('pword').value;
    var url = "http://193.11.187.227:5000/account";
    var params = "email="+xemail+"first_name"+xfirst_name+"last_name"+xlast_name+"password"+xpassword;
    var xhr = new XMLHttpRequest();
    xhr.open("PUT", url, true);
    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.send(params);
    alert(params)
}
