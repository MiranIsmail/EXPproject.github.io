var mysql = require('mysql');



var con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "Faiz1234",
  database:"demo"
});



con.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});

con.query("SELECT * FROM `users`", (err, results) => {
  if (err) { throw err; }
  console.log(results);
});
