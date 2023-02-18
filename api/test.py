import requests


def main() -> None:
    BASE = "http://127.0.0.1:5000/"
    # response = requests.put(BASE + "account",{"mail": "a@a2", "first_name": "amin", "last_name": "afzali", "password": "dsf"})

    # response = requests.post(BASE + "account",data={'token':"3a9b2e43cb02c3a70347a83caced98618f93cd5d"})

    #response = requests.get(BASE + f"account", {"mail": "a@a", "password": "dsf"})

    response = requests.delete(BASE+'account',data={'token':"599c9a9a7ab14208e31d8f91ddc158d717374a74"})

    print(response.json())


if __name__ == "__main__":
    main()
