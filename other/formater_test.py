import json
from datetime import datetime
import serial
import time

def time_diff_sformat(start_time, end_time,time_format):
    """Sends out..."""
    time_start = datetime.strptime(start_time, time_format)
    time_goal = datetime.strptime(end_time, time_format)

    # Calculate the time difference
    time_diff = time_goal - time_start

    # Get the time difference in seconds
    time_diff_sec = time_diff.total_seconds()

    return time_diff_sec


def time_diff_lformat(start_time, end_time,time_format):
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


def time_format_parse(time_log:str):
    time_format = '%H:%M:%S.%f'
    split_string = time_log.split("\\t")
    
    usb_id = split_string[3][1:]  # The USB ID is always found in this location.
    chip_id = split_string[1][1:]

    time_dict = {}
    result_card = {"id": chip_id, "time": time_dict}

    for str in split_string:
        str_part = str.split("-")  # The seperator is -.

        # make sure it is a timestamp. It always starts with a Q.
        if str_part[0][0] == "Q":

            result_id = str_part[0]
            station_id = int(str_part[1])
            timestamp_id = str_part[2]
            timestamp = str_part[3]

            station_name = ""

            if station_id == 0:
                station_name = "Start"

            elif station_id > 100 and station_id < 201:
                station_name = str_part[1]
                try: #Since all new entries appear last in dict we can index it in the last possition to get previous. 
                    prev_station_timestamp = time_dict[list(time_dict.keys())[-1]][1] 
                except IndexError:
                    prev_station_timestamp = None
                    print("You have not passed the start station")

            elif station_id == 90:
                station_name = "Finish"
                prev_station_timestamp = time_dict[list(time_dict.keys())[-1]][1]

            else:
                station_name = "Undefined" #If nothing applices, you are not a station, e.g. the USB. 

            if (station_name == "Finish" or station_name == str_part[1]) and prev_station_timestamp != None: #if the station has had a previous
                seconds_diff = time_diff_sformat(prev_station_timestamp, timestamp,time_format)
                diff_format = time_diff_lformat(prev_station_timestamp, timestamp,time_format)
            else:
                seconds_diff = "None"
                diff_format = "None"

            if station_name != "Undefined":
                time_dict[result_id] = [station_name, timestamp, diff_format, seconds_diff]

    json_string = json.dumps(result_card)
    return json_string

if __name__ == "__main__":
    # ser = serial.Serial(port="COM5", baudrate=115200)
    # # send a command to the USB device
    # ser.write(b"/PP0<CR><LF>")
    # while True:
    #     response = ser.readline()
    #     if response[1] != 73:
    #         if response[1] != 80:
    #             print(time_format_parse(str(response)))
    #             time.sleep(0.005)
    print(time_format_parse(str(b'\x02D 04 11\tN4242145\tM103\tC253\tU14.10.2021\tW14:46:18.000\tL0120\tX7\tV295-285-4820\tS4242145\tRemiTag IIb\tQ0-0-46424898727-00:00:00.000-14:02:22.305-0\tQ1-101-46424904730-00:00:06.003-14:02:28.308-0\tQ2-253-46424911326-00:00:12.599-14:02:34.904-0\tQ3-102-46425004598-00:01:45.871-14:04:08.176-0\tQ4-101-46425006948-00:01:48.221-14:04:10.526-0\tQ5-102-46425011278-00:01:52.551-14:04:14.928-0\tQ6-253-46425013350-00:01:54.623-14:04:17.000-0\tQ7-102-46425023161-00:02:04.434-14:04:26.811-0\tQ8-253-46425027794-00:02:09.067-14:04:31.444-0\tQ9-102-46425060730-00:02:42.003-14:05:04.380-0\tQ10-253-46425068209-00:02:49.482-14:05:11.940-0\tQ11-253-46425308286-00:06:49.559-14:09:12.017-0\tQ12-253-46425318223-00:06:59.496-14:09:21.954-0\tQ13-253-46425323574-00:07:04.847-14:09:27.305-0\tQ14-253-46425383442-00:08:04.715-14:10:27.173-0\tQ15-253-46425453896-00:09:15.169-14:11:37.698-0\tQ16-253-46426343267-00:24:04.540-14:26:27.069-0\tQ17-253-46426375379-00:24:36.652-14:26:59.181-0\tQ18-253-46426548397-00:27:29.670-14:29:52.199-0\tQ19-253-46426654757-00:29:16.030-14:31:38.559-0\tQ20-253-46426774854-00:31:16.127-14:33:38.727-0\tQ21-253-46426780765-00:31:22.038-14:33:44.638-0\tQ22-253-46427159766-00:37:41.039-14:40:03.639-0\tQ23-253-46427165591-00:37:46.864-14:40:09.464-0\tQ24-253-46427439852-00:42:21.125-14:44:43.725-0\tQ25-253-46427535232-00:43:56.505-14:46:19.165-0\t\x03\r\n')))