from flask import Flask
from flask_restful import Api, Resource, reqparse
from flask_mysqldb import MySQL

app = Flask(__name__)
api = Api(app)

# Configure MySQL connection
app.config["MYSQL_HOST"] = "localhost"
app.config["MYSQL_USER"] = "root"
app.config["MYSQL_PORT"] = 3306
app.config["MYSQL_DB"] = "systemTeknik"
app.config["MYSQL_PASSWORD"] = "Faiz1234"

mysql = MySQL(app)



class Register(Resource):
    def put(self) -> tuple[str, int]:
        register_put_args = reqparse.RequestParser()
        register_put_args.add_argument(
            "first_name", type=str, help="First name is required", required=True
        )
        register_put_args.add_argument(
            "last_name", type=str, help="Last name is required", required=True
        )
        register_put_args.add_argument("email", type=str, help="Email is required", required=True)
        register_put_args.add_argument(
            "password", type=str, help="Password is required", required=True
        )
        register_put_args.add_argument("height", type=int, help="Needs to be integer")
        register_put_args.add_argument("weight", type=int, help="Needs to be integer kg")
        register_put_args.add_argument("age", type=int, help="Needs to be integer")
        register_put_args.add_argument("equipment", type=str, help="Needs to be string")

        sql_qustion = "insert into Users values ('Amin@afzali.com','dsfsagsrg','Amin','Afzali',null,172,45,10,'d','password')"
        #cur.execute(sql_qustion)

        return sql_qustion, 201


api.add_resource(Register, "/register")

if __name__ == "__main__":
    app.run(debug=True)
