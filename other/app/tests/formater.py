#import json
from datetime import datetime
import serial
import time
import requests


def split_time(time: str):
    time_split = time.split(":")
    t_hours = int(time_split[0])
    t_minutes = int(time_split[1])
    t_seconds = float(time_split[2])

    return t_hours, t_minutes, t_seconds


def seconds_to_time_format(seconds: int):
    """Takes in amount of seconds and outputs on the time format xx:xx:xx.xxx"""
    time_hrs, rem = divmod(seconds, 3600)
    time_min, seconds = divmod(rem, 60)
    time_ms = int((seconds - int(seconds)) * 1000)
    time_sec = int(seconds)

    return time_hrs, time_min, time_sec, time_ms


def time_formater(start_time: str, end_time: str, off_set: int):
    """Gives to the given time format a difference in time between two timestamps \n

    This function has three return values inside a dictionary:
    1. The timestamp (str)
    2. The timestamp difference (str)
    3. The difference in seconds (int)"""

    # Take the string of type "xx:xx:xx.xxx" and split the parts up
    e_hours, e_minutes, e_seconds = split_time(end_time)
    s_hours, s_minutes, s_seconds = split_time(start_time)

    s_total_seconds = s_hours*3600+s_minutes*60+s_seconds
    e_total_seconds = e_hours*3600+e_minutes*60+e_seconds

    if s_total_seconds > e_total_seconds:
        return "00:00:00.000", "00:00:00.000", e_total_seconds
    
    # With the off_set, make it so all times after the reset behave as if the reset was the start.
    adjusted_time = e_total_seconds - off_set

    # If the timer has gone for a whole day without reset:
    if adjusted_time > 3600*12:
        return "00:00:00.000", "00:00:00.000", e_total_seconds


    # Calculate the time difference
    time_diff = e_total_seconds - s_total_seconds

    # Convert time back to hours, minutes, and seconds
    time_hrs, time_min, time_sec, time_ms = seconds_to_time_format(
        adjusted_time)

    # Convert time difference to hours, minutes, and seconds
    time_diff_hrs, time_diff_min, time_diff_sec, time_diff_ms = seconds_to_time_format(
        time_diff)

    # Convert time back to the original format
    time_diff_str = f"{int(time_diff_hrs):02d}:{int(time_diff_min):02d}:{int(time_diff_sec):02d}.{time_diff_ms:03d}"
    time_str = f"{int(time_hrs):02d}:{int(time_min):02d}:{int(time_sec):02d}.{time_ms:03d}"
    return time_str, time_diff_str, round(time_diff, 2)


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

            station_id = int(str_part[1])
            timestamp_id = str_part[2]
            timestamp = str_part[3]
            
            if station_id == 0:
                station_name = "Start"
            elif station_id > 100 and station_id < 201:
                station_name = str_part[1]
                try:  # Since all new entries appear last in list we can index it in the last possition to get previous.
                    prev_station_timestamp = time_list[-1][1]
                except IndexError:
                    prev_station_timestamp = None
                    print("You have not passed the start station")
            elif station_id == 90:
                station_name = "Finish"
                prev_station_timestamp = time_list[-1][1]
            else:
                # If nothing applices, you are not a station, e.g. the USB.
                station_name = "Undefined"
                

            # if the station has had a previous
            if (station_name == "Finish" or station_name == str_part[1]) and prev_station_timestamp != None:
                timestamp, diff_format, seconds_diff = time_formater(prev_station_timestamp, timestamp, off_set)

                # Check if this time stamp was set as the new start.
                if timestamp == "00:00:00.000" and seconds_diff != 0:
                    # Reset the data. The offset is always subtracted in the time_diff function
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

    # find the total time, last entry in the second position
    total_time = time_list[-1][1]
    result_card = {"chip_id": chip_id,
                   "total_time": total_time, "track_time": time_list}

    # export to json
    #json_string = json.dumps(result_card)
    return result_card


def main():
    runner= True
    ser = serial.Serial(port="COM5", baudrate=115200)
    url = 'https://rasts.se/api/Results'
    #json_obj = {"chip_id": "4242145", "total_time": "00:02:42.003", "track_time": [["Start", "00:00:00.000", "00:00:00.000", "0", "46424898727"], ["101", "00:00:06.003", "00:00:06.003", 6.003, "46424904730"], ["102", "00:01:45.871", "00:01:39.867", 99.868, "46425004598"], ["101", "00:01:48.221", "00:00:02.350", 2.35, "46425006948"], ["102", "00:01:52.551", "00:00:04.330", 4.33, "46425011278"], ["102", "00:02:04.434", "00:00:11.882", 11.883, "46425023161"], ["102", "00:02:42.003", "00:00:37.569", 37.569, "46425060730"]]}
    # send a command to the USB device
    #ser.write(b"/PP0<CR><LF>")
    while runner:
        response = ser.readline()
        if response[1] != 73:
            if response[1] != 80:
                res:dict=time_format_parse(str(response))
                #print(time_format_parse(str(response)))
                requests.post(url, data= time_format_parse(str(response)))
                time.sleep(0.005)
                runner = False
    return res
