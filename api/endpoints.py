from flask import Flask, request
from flask_restful import Api, Resource, reqparse
from flask_mysqldb import MySQL
from hashlib import sha1
import time

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
    def put(self) -> tuple[str, int]:
        conn = mysql.connect
        cur = conn.cursor()
        data = request.form.to_dict()

        if not any([key in data.keys() for key in ["first_name", "last_name", "password", "mail"]]):
            request.abort(404, "missing, data")

        data["password"] = str(sha1(str(data["password"]).encode()).hexdigest())
        columns = "`" + "`,`".join(data.keys()) + "`"
        values = "'" + "','".join(data.values()) + "'"
        sql = f"insert into Users ({columns},`token`) values ({values},'{sha1(str(str(data['first_name'])+ 'SALT' + str(time.monotonic()) + str(data['password'])).encode()).hexdigest()}')"
        print(sql)
        cur.execute(sql)
        conn.commit()

        return sql, 201


api.add_resource(Register, "/register")

if __name__ == "__main__":
    app.run(debug=True)
