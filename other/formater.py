import json
from datetime import datetime
import serial
import time


def time_diff_sformat(start_time, end_time, time_format) -> int:
    """Sends out the amount of seconds between two different timestamps"""
    try:
        time_start = datetime.strptime(start_time, time_format)
        time_goal = datetime.strptime(end_time, time_format)

        # Calculate the time difference
        time_diff = time_goal - time_start

        # Get the time difference in seconds
        time_diff_sec = time_diff.total_seconds()

        return time_diff_sec
    except ValueError:
        print("You have old data on this device. It will not be logged")
        return "0"



def time_diff_lformat(start_time, end_time, time_format):
    """Gives to the given time format a difference in time between two timestamps"""

    try:
        time_start = datetime.strptime(start_time, time_format)
        time_goal = datetime.strptime(end_time, time_format)

        # Calculate the time difference
        time_diff = time_goal - time_start

        time_diff_sec = time_diff.total_seconds()

        # Convert time difference to hours, minutes, and seconds
        time_diff_hrs, rem = divmod(time_diff_sec, 3600)
        time_diff_min, time_diff_sec = divmod(rem, 60)
        time_diff_ms = int((time_diff_sec - int(time_diff_sec)) * 1000)
        time_diff_sec = int(time_diff_sec)

        # Convert time difference back to the original format
        time_diff_str = f"{int(time_diff_hrs):02d}:{int(time_diff_min):02d}:{int(time_diff_sec):02d}.{time_diff_ms:03d}"

        return time_diff_str
    except ValueError:
        return "0"


def time_format_parse(time_log: str):
    """Takes the EMIT-chip time log and formats it. The output will have the following format: \n
        {"chip_id" : xxxxxxx, "time": "Qx": [{}]}"""
    time_format = "%H:%M:%S.%f"
    split_string = time_log.split("\\t")

    # The USB ID is always found in this location.
    usb_id = split_string[3][1:]
    chip_id = split_string[1][1:]
    total_time = "00:00:00.000"
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
                seconds_diff = time_diff_sformat(
                    prev_station_timestamp, timestamp, time_format)
                diff_format = time_diff_lformat(
                    prev_station_timestamp, timestamp, time_format)
            else:
                seconds_diff = "0"
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
    # send a command to the USB device
    ser.write(b"/PP0<CR><LF>")
    while True:
        response = ser.readline()
        if response[1] != 73:
            if response[1] != 80:
                print(time_format_parse(str(response)))
                time.sleep(0.005)