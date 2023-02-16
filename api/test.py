import requests


def main() -> None:
    BASE = "http://127.0.0.1:5000/"

    response = requests.put(
        BASE + "register",
        {"first_name": "amin", "last_name": "dsf", "password": "123", "mail": "am2in@afzali"},
    )
    print(response.json())


if __name__ == "__main__":
    main()
