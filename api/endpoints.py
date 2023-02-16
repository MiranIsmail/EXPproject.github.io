from flask import Flask, request
from flask_restful import Api, Resource, reqparse
from flask_mysqldb import MySQL
from hashlib import sha256

app = Flask(__name__)
api = Api(app)

# Configure MySQL connection
app.config["MYSQL_HOST"] = "localhost"
app.config["MYSQL_USER"] = "root"
app.config["MYSQL_PASSWORD"] = "Faiz1234"
app.config["MYSQL_DB"] = "systemteknik"

# Initialize MySQL extension
mysql = MySQL(app)


class Register(Resource):
    def get(self):
        pass

    def put(self) -> tuple[str, int]:
        cur = mysql.connect.cursor()
        data = request.form.to_dict()
        columns = "`" + "`,`".join(data.keys()) + "`"
        values = "'" + "','".join(data.values()) + "'"
        sql = f"insert into Users ({columns}) values ({values})"
        print(sql)
        cur.execute(sql)
        print(cur.fetchall())
        
        return sql, 201


api.add_resource(Register, "/register")

if __name__ == "__main__":
    app.run(debug=True)
    mysql.teardown()
