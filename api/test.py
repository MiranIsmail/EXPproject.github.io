import requests


def main() -> None:
    BASE = "http://193.11.187.227:5000/"
    response = requests.put(BASE + "account",{"email": "a@ar24", "first_name": "amin", "last_name": "afzali", "password": "dsf"})

    # response = requests.post(BASE + "account",data={'token':"3a9b2e43cb02c3a70347a83caced98618f93cd5d"})

    # response = requests.get(BASE + f"account", {"email": "a@a", "password": "dsf"})

    # response = requests.delete(BASE+'account',data={'token':"599c9a9a7ab14208e31d8f91ddc158d717374a74"})

    # response = requests.put(
    #     BASE + "event",
    #     {
    #         "auth_token":"eb18fb7faa62b1d7f24c82b283056356ccfc847b",
    #         "event_name": "test",
    #         "track_id": 1,
    #         "host_organization": "gangsterAB",
    #         "sport": "Runing",
    #         "start_date": "2023-01-15",
    #         "end_date": "2024-06-15",
    #         "module_id": 1,
    #     }, timeout=15
    # )

    # response = requests.get(BASE+'event',{"key":'host_email',"search_text":'a'})

    # response = requests.delete(
    #     BASE + "event", data={"token": "eb18fb7faa62b1d7f24c82b283056356ccfc847b", "event_id": 5}
    # )

    #response = requests.put(BASE+"result",{'track_time':'12s','event_id':6,'participant1':'a@a2'})

    # response = requests.get(BASE + "result", {"event_id": 6})

    #response = requests.delete(BASE + 'result', data={'token':'eb18fb7faa62b1d7f24c82b283056356ccfc847b','event_id':6})
    print(response.json())


if __name__ == "__main__":
    main()
