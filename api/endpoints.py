from flask import Flask, request
from flask_restful import Api, Resource, reqparse
from flask_mysqldb import MySQL
from hashlib import sha1
import random as rand
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


class Account(Resource):
    def put(self) -> tuple[str, int]:
        conn = mysql.connect
        cur = conn.cursor()
        data = request.form.to_dict()
        print(data)
        if not any([key in data.keys() for key in ["first_name", "last_name", "password", "mail"]]):
            request.abort(404, "missing, data")

        data["password"] = str(sha1(str(data["password"]).encode()).hexdigest())
        columns = "`" + "`,`".join(data.keys()) + "`"
        values = "'" + "','".join(data.values()) + "'"
        sql = f"insert into Users ({columns},`token`) values ({values},'{sha1(str(str(data['mail']) + 'SALT' + str(time.monotonic()) + str(data['password'])).encode()).hexdigest()}')"
        print(sql)
        cur.execute(sql)
        conn.commit()
        conn.close()
        return "Success", 201

    def post(self) -> tuple[str, int]:
        conn = mysql.connect
        cur = conn.cursor()
        token = request.form.to_dict().get("token")
        sql = "update Users set token = %s where token = %s"
        random_token = sha1(str(rand.random() + time.monotonic()).encode()).hexdigest()
        cur.execute(sql, (random_token, token))
        conn.commit()
        conn.close()
        return "Success", 200

    def get(self) -> tuple[tuple[str, str], int]:
        conn = mysql.connect
        cur = conn.cursor()
        sql = "select token from Users where mail like %s and password like %s"
        email = request.args.get("mail")
        password = request.args.get("password")
        print(email, password)
        cur.execute(sql, (email, sha1(password.encode()).hexdigest()))
        token = cur.fetchall()[0][0]
        conn.close()
        return ("success", token), 200

    def delete(self) -> tuple[str, int]:
        conn = mysql.connect
        cur = conn.cursor()
        token = request.form.get("token")
        sql = "delete from Users where token LIKE %s"
        cur.execute(sql, (token,))
        conn.commit()
        conn.close()
        return "success", 200


api.add_resource(Account, "/account")

if __name__ == "__main__":
    app.run(debug=True)
