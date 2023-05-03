var mysql = require('mysql');
const fs = require('fs');


var con=mysql.createConnection({
    host:"exsportserver.mysql.database.azure.com",
    user:"notadmin",
    password:"Grupp5exsport!",
    database:"systemteknik",
    port:3306,
    ssl:{ca:fs.readFileSync("DigiCertGlobalRootCA.crt.pem")}});


con.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});

con.query("SELECT * FROM `users`", (err, results) => {
  if (err) { throw err; }
  console.log(results);
});
