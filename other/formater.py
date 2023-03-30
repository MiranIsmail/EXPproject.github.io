import json
from datetime import datetime
import serial
import time
import requests


def time_diff(start_time: str, end_time: str, time_format: str, off_set: int):
    """Gives to the given time format a difference in time between two timestamps"""

    end_time_split = end_time.split(":")
    e_hours = int(end_time_split[0])
    e_minutes = int(end_time_split[1])
    e_seconds = float(end_time_split[2])

    start_time_split = start_time.split(":")
    s_hours = int(start_time_split[0])
    s_minutes = int(start_time_split[1])
    s_seconds = float(start_time_split[2])

    e_total_seconds = e_hours*3600+e_minutes*60+e_seconds
    e_total_seconds -= off_set

    s_total_seconds = s_hours*3600+s_minutes*60+s_seconds

    time_diff = e_total_seconds - s_total_seconds

    if e_total_seconds > 3600*24:
        return "00:00:00.000", "00:00:00.000", e_total_seconds

    # Convert time difference to hours, minutes, and seconds
    time_hrs, rem = divmod(e_total_seconds, 3600)
    time_min, e_total_seconds = divmod(rem, 60)
    time_ms = int((e_total_seconds - int(e_total_seconds)) * 1000)
    time_sec = int(e_total_seconds)

    # Convert time difference to hours, minutes, and seconds
    time_diff_hrs, rem = divmod(time_diff, 3600)
    time_diff_min, time_diff_rem = divmod(rem, 60)
    time_diff_ms = int((time_diff_rem - int(time_diff_rem)) * 1000)
    time_diff_sec = int(time_diff_rem)

    # Convert time difference back to the original format
    time_diff_str = f"{int(time_diff_hrs):02d}:{int(time_diff_min):02d}:{int(time_diff_sec):02d}.{time_diff_ms:03d}"
    time_str = f"{int(time_hrs):02d}:{int(time_min):02d}:{int(time_sec):02d}.{time_ms:03d}"
    return time_str, time_diff_str, round(time_diff,2)


def time_format_parse(time_log: str):
    """Takes the EMIT-chip time log and formats it. The output will have the following format: \n
        {"chip_id" : xxxxxxx, "time": "Qx": [{}]}"""
    time_format = "%H:%M:%S.%f"
    split_string = time_log.split("\\t")

    # The USB ID is always found in this location.
    usb_id = split_string[3][1:]
    chip_id = split_string[1][1:]
    total_time = "00:00:00.000"
    off_set = 0
    time_list = []

    for str in split_string:
        str_part = str.split("-")  # The seperator is -.

        # make sure it is a timestamp. It always starts with a Q.
        if str_part[0][0] == "Q":

            result_id = str_part[0]
            station_id = int(str_part[1])
            timestamp_id = str_part[2]
            timestamp = str_part[3]

            if station_id == 0:
                station_name = "Start"

            elif station_id > 100 and station_id < 201:
                station_name = str_part[1]
                try:  # Since all new entries appear last in dict we can index it in the last possition to get previous.
                    prev_station_timestamp = time_list[-1][1]
                except IndexError:
                    prev_station_timestamp = None
                    print("You have not passed the start station")
                    return

            elif station_id == 90:
                station_name = "Finish"
                prev_station_timestamp = time_list[-1][1]

            else:
                # If nothing applices, you are not a station, e.g. the USB.
                station_name = "Undefined"

            # if the station has had a previous
            if (station_name == "Finish" or station_name == str_part[1]) and prev_station_timestamp != None:
                timestamp, diff_format, seconds_diff = time_diff(
                    prev_station_timestamp, timestamp, time_format, off_set)

                # Check if this time stamp was over a day since the last
                if seconds_diff > 3600*24:
                    # Reset the data. The offset is always subtracted in t
                    off_set = seconds_diff
                    time_list = []
                    timestamp = "00:00:00.000"
                    seconds_diff = 0
                    diff_format = "00:00:00.000"
            else:
                seconds_diff = 0
                diff_format = "00:00:00.000"

            if station_name != "Undefined":
                time_list.append(
                    [station_name, timestamp, diff_format, seconds_diff, timestamp_id])

    total_time = time_list[-1][1]
    result_card = {"chip_id": chip_id,
                   "total_time": total_time, "track_time": time_list}
    json_string = json.dumps(result_card)
    return json_string


if __name__ == "__main__":
    ser = serial.Serial(port="COM5", baudrate=115200)
    url = 'https://rasts.se/api/Results'
    json_obj = {"chip_id": "4242145", "total_time": "00:02:42.003", "track_time": [["Start", "00:00:00.000", "00:00:00.000", "0", "46424898727"], ["101", "00:00:06.003", "00:00:06.003", 6.003, "46424904730"], ["102", "00:01:45.871", "00:01:39.867", 99.868, "46425004598"], ["101", "00:01:48.221", "00:00:02.350", 2.35, "46425006948"], ["102", "00:01:52.551", "00:00:04.330", 4.33, "46425011278"], ["102", "00:02:04.434", "00:00:11.882", 11.883, "46425023161"], ["102", "00:02:42.003", "00:00:37.569", 37.569, "46425060730"]]}
    # send a command to the USB device
    ser.write(b"/PP0<CR><LF>")
    while True:
        response = ser.readline()
        if response[1] != 73:
            if response[1] != 80:
                print(time_format_parse(str(response)))
                requests.post(url, json= time_format_parse(str(response)))
                time.sleep(0.005)

#requests.post(url, json= json_obj)
