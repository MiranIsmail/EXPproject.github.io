import json
from datetime import datetime


def time_diff_sformat(start_time, end_time):
    time_start = datetime.strptime(start_time, time_format)
    time_goal = datetime.strptime(end_time, time_format)

    # Calculate the time difference
    time_diff = time_goal - time_start

    # Get the time difference in seconds
    time_diff_sec = time_diff.total_seconds()

    return time_diff_sec


def time_diff_lformat(start_time, end_time):
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
    time_diff_str = f"{int(time_diff_hrs):02d}:{int(time_diff_min):02d}:{int(time_diff_sec):02d}:{time_diff_ms:03d}"

    return time_diff_str


if __name__ == "__main__":
    time_format = '%H:%M:%S:%f'

    my_string = "b'\x02D 03 04\tN4243283\tM104\tC253\tU14.10.2021\tW14:46:26.000\tL0120\tX7\tV293-282-4820\tS4243283\tRemiTag IIb\tQ0-102-46353530667-00:00:00.000-22:26:55.075-1\tQ1-102-46353834340-00:00:00.000-22:31:58.748-1\tQ2-102-46354137372-00:00:00.000-22:37:01.780-1\tQ3-102-46354440067-00:00:00.000-22:42:04.475-1\tQ4-102-46354750828-00:00:00.000-22:47:15.236-1\tQ5-102-46355057835-00:00:00.000-22:52:22.309-1\tQ6-102-46355360038-00:00:00.000-22:57:24.512-1\tQ7-102-46355473067-00:00:00.000-22:59:17.541-1\tQ8-102-46355587448-00:00:00.000-23:01:11.922-1\tQ9-102-46355890161-00:00:00.000-23:06:14.635-1\tQ10-102-46356197478-00:00:00.000-23:11:22.018-1\tQ11-102-46356370141-00:00:00.000-23:14:14.681-1\tQ12-102-46356677677-00:00:00.000-23:19:22.217-1\tQ13-102-46356987250-00:00:00.000-23:24:31.790-1\tQ14-102-46357290792-00:00:00.000-23:29:35.332-1\tQ15-102-46357594904-00:00:00.000-23:34:39.510-1\tQ16-102-46357900582-00:00:00.000-23:39:45.188-1\tQ17-102-46358203691-00:00:00.000-23:44:48.297-1\tQ18-102-46358506152-00:00:00.000-23:49:50.758-1\tQ19-102-46358809692-00:00:00.000-23:54:54.298-1\tQ20-102-46359111520-00:00:00.000-23:59:56.203-1\tQ21-102-46359415891-00:00:00.000-00:05:00.574-0\tQ22-102-46359720393-00:00:00.000-00:10:05.076-0\tQ23-102-46360022509-00:00:00.000-00:15:07.192-0\tQ24-102-46360332092-00:00:00.000-00:20:16.775-0\tQ25-102-46360640221-00:00:00.000-00:25:24.970-0\tQ26-102-46360944464-00:00:00.000-00:30:29.213-0\tQ27-102-46361248534-00:00:00.000-00:35:33.283-0\tQ28-102-46361301690-00:00:00.000-00:36:26.439-0\tQ29-102-46361604441-00:00:00.000-00:41:29.190-0\tQ30-102-46361905785-00:00:00.000-00:46:30.600-0\tQ31-102-46362208411-00:00:00.000-00:51:33.226-0\tQ32-102-46362448827-00:00:00.000-00:55:33.642-0\tQ33-102-46362752539-00:00:00.000-01:00:37.354-0\tQ34-102-46363058370-00:00:00.000-01:05:43.185-0\tQ35-102-46363363180-00:00:00.000-01:10:48.061-0\tQ36-102-46363666435-00:00:00.000-01:15:51.316-0\tQ37-102-46363884944-00:00:00.000-01:19:29.825-0\tQ38-102-46364188546-00:00:00.000-01:24:33.427-0\tQ39-102-46364207696-00:00:00.000-01:24:52.577-0\tQ40-102-46364513886-00:00:00.000-01:29:58.833-0\tQ41-102-46364816441-00:00:00.000-01:35:01.388-0\tQ42-102-46365123673-00:00:00.000-01:40:08.620-0\tQ43-102-46365426473-00:00:00.000-01:45:11.420-0\tQ44-102-46365731191-00:00:00.000-01:50:16.138-0\tQ45-102-46365804721-00:00:00.000-01:51:29.734-0\tQ46-102-46365999913-00:00:00.000-01:54:44.926-0\tQ47-101-46366113169-00:00:00.000-01:56:38.182-0\tQ48-101-46366415786-00:00:00.000-02:01:40.799-0\tQ49-101-46366717318-00:00:00.000-02:06:42.331-0\tQ50-101-46367020001-00:00:00.000-02:11:45.080-0\tQ51-101-46367322785-00:00:00.000-02:16:47.864-0\tQ52-101-46367624286-00:00:00.000-02:21:49.365-0\tQ53-101-46367925722-00:00:00.000-02:26:50.801-0\tQ54-101-46368227162-00:00:00.000-02:31:52.241-0\tQ55-101-46368528848-00:00:00.000-02:36:53.993-0\tQ56-101-46368830537-00:00:00.000-02:41:55.682-0\tQ57-101-46369133349-00:00:00.000-02:46:58.494-0\tQ58-101-46369436161-00:00:00.000-02:52:01.306-0\tQ59-101-46369737723-00:00:00.000-02:57:02.868-0\tQ60-101-46370040411-00:00:00.000-03:02:05.622-0\tQ61-101-46370341880-00:00:00.000-03:07:07.091-0\tQ62-101-46370644349-00:00:00.000-03:12:09.560-0\tQ63-101-46370946223-00:00:00.000-03:17:11.434-0\tQ64-101-46371248723-00:00:00.000-03:22:13.934-0\tQ65-101-46371550535-00:00:00.000-03:27:15.812-0\t\x02Q66-101-46371852164-00:00:00.000-03:32:17.441-0\tQ67-101-46372154223-00:00:00.000-03:37:19.500-0\tQ68-101-46372456100-00:00:00.000-03:42:21.377-0\tQ69-101-46372757535-00:00:00.000-03:47:22.812-0\tQ70-101-46373060225-00:00:00.000-03:52:25.569-0\tQ71-101-46373361912-00:00:00.000-03:57:27.256-0\tQ72-101-46373663598-00:00:00.000-04:02:28.942-0\tQ73-253-46409930973-00:00:00.000-14:06:56.317-0\tQ74-253-46412302348-00:00:00.000-14:46:27.692-0\t\x03\r\n'"
    fixed_string = my_string.replace(".", ":")
    split_string = fixed_string.split("\t")

    usb_id = split_string[3][1:]  # The USB ID is always found in this location.

    time_dict = {}

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
                try: 
                    prev_station_timestamp = time_dict[list(time_dict.keys())[-1]][1]
                except IndexError:
                    prev_station_timestamp = None
                    print("You have not passed the start station")

            elif station_id == 90:
                station_name = "Finish"
                prev_station_timestamp = time_dict[list(time_dict.keys())[-1]]

            else:
                station_name = "Undefined" #If nothing applices, you are not a station, e.g. the USB. 

            if (station_name == "Finish" or station_name == str_part[1]) and prev_station_timestamp != None: #if the station has had a previous
                seconds_diff = time_diff_sformat(prev_station_timestamp, timestamp)
                diff_format = time_diff_lformat(prev_station_timestamp, timestamp)
            else:
                seconds_diff = "None"
                diff_format = "None"

            if station_name != "Undefined":
                time_dict[result_id] = [station_name, timestamp, diff_format, seconds_diff]

    json_string = json.dumps(time_dict)
    print(json_string)
