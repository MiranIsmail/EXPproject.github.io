import tkinter as tk
from tkinter import ttk
import tkinter.messagebox
import threading
import json
from datetime import datetime
import serial
import time
import requests
from tkinter import *
from PIL import Image, ImageTk
from win32api import GetSystemMetrics
import serial.tools.list_ports as stlp


global_event_id = ""
global_track_name = ""

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
    return result_card


def formater():
    runner= True
    #s = stlp.comports()
    #for port in sorted(s):
        #print(port.product)
        #print("{}: {} [{}]".format(port, desc, manufacturer))
    ser = serial.Serial(port="COM3", baudrate=115200)
    url = 'https://rasts.se/api/Results'
    while runner:
        response = ser.readline()
        if response[1] != 73:
            if response[1] != 80:
                res:dict=time_format_parse(str(response))
                chip_id:str = res.get("chip_id")
                update_options(chip_id)
                #json_string = json.dumps(res)
                #requests.post(url, data= json_string)
                time.sleep(0.1)
                runner = False
    return res


data = {"chip_id": "0", "total_time": "0", "track_time": []}
headings = ['Station ID', 'Start Time','Delta Time']
exit_event = threading.Event()
update_thread = None

def update_table(new_data):
    """This function should update the table with the new_data
    new_data should be a dictionary"""
    # Clear existing data
    table.delete(*table.get_children())

    # Insert new data rows and apply alternating row colors
    row_number = 0
    for row in new_data["track_time"]:
        if row_number % 2 == 0:
            table.insert(parent='', index='end', values=row, tags=('even',))
        else:
            table.insert(parent='', index='end', values=row, tags=('odd',))
        row_number += 1

    # Update column headings
    for col in headings:
        table.heading(col, text=col)

def start():
    """This function is bound to the start button. It should give a warning about
    about if the usb-reader is connected, then run formater.main()"""
    global update_thread  # declare update_thread as global variable
    result = tkinter.messagebox.askquestion("RASTS",  "Is the usb-reader plugged in? if not please plug it in then press yes.")
    if result == 'yes':
        def update(exit_event):
            new_data = formater()
            update_table(new_data)
            if not exit_event.is_set():
                root.after(500, update(exit_event))

        # Create a new thread if one does not exist or if the previous one has finished
        if not update_thread or not update_thread.is_alive():
            exit_event = threading.Event()
            update_thread = threading.Thread(target=update, args=(exit_event,),daemon=True)
            update_thread.start()

def close():
    """This function is bound to the close button. It should stop the program"""
    global update_thread, exit_event  # declare update_thread and exit_event as global variables
    if update_thread and update_thread.is_alive():
        exit_event.set()
        update_thread.join(timeout=1)  # add a timeout of 1 second to the join() method
    root.quit()
    root.destroy()

################################################################
############### !!! Here begins the graphics !!! ############### 
################################################################

root = tk.Tk()
root.title("RASTS")
root.iconbitmap(r"C:\Users\miran\Desktop\EXPproject\other\logo.ico")
root.attributes('-fullscreen',True)
my_note = ttk.Notebook(root)
my_note.pack(fill="both",expand=True)

##############################################################
### This section creates the frames 1 and 2 ie settings and home
f1= Frame(my_note)
f1.pack(fill="both",expand=True)
f2= Frame(my_note)
f2.pack(fill="both",expand=True)
my_note.add(f1,text="Home")
my_note.add(f2,text="Settings")

##############################################################
### This section handles the images that are used in both frame 1 and 2
label_text = "Hello from RASTS.se"
label_font = ('helvetica', 62)
image = Image.open(r"C:\Users\miran\Desktop\EXPproject\other\app\RASTS.png")
w,h=GetSystemMetrics(0),GetSystemMetrics(1)
resize_image = image.resize((w//3, h//3))
img = ImageTk.PhotoImage(resize_image)
##############################################################
### Picture in frame 1(Home)
label = ttk.Label(f1, text=label_text, font=label_font, background='gray', foreground='white',image=img)
label.pack(fill='both', expand=True)
label.configure(anchor="center")

### Picture in frame 2(settings)
label_f2 = ttk.Label(f2, text=label_text, font=label_font, background='gray', foreground='white',image=img)
label_f2.pack(fill='both', expand=True)
label_f2.configure(anchor="center")


######################################################################################
# This section handles the options in frame 1 
options = ['Option 1', 'Option 2', 'Option 3']
var = tk.StringVar(f1)
var.set(options[0])

menu = tk.OptionMenu(f1, var, *options)
menu.pack()

# function to update options
def update_options(chip_id):
    """This function is a part of a chain that handles options in frame 1"""
    url_id_event = 'https://rasts.se/api/Registration?chip_id='+chip_id
    new_options = []
    get_result:list = requests.get(url_id_event).json()
    print(type(get_result))
    for ev_dict in get_result:
        new_options.append(ev_dict["event_name"])
    
    menu['menu'].delete(0, 'end') # delete old options
    for option in new_options:
        menu['menu'].add_command(label=option, command=tk._setit(var, option)) # add new options
    var.set(new_options[0]) # set default value

######################################################################################


# a button that handles the program start "!!!! see the function start()"
start_button = ttk.Button(f1, text="START", command=start)
start_button.pack(side="top")

# a button that handles app closing "!!! see the function close()"
close_button = ttk.Button(f1, text="Close", command=close)
close_button.pack()

######################################################################################
# This section handles the visualisation of the table that shows results from a chip
table = ttk.Treeview(f1, columns=headings, show='headings')
table.pack(fill='both', expand=True)

# Configure alternating row colors
table.tag_configure('even', background='#f0f0f0')
table.tag_configure('odd', background='white')
row_number = 0

# Insert data rows and apply alternating row colors
for row in data['track_time']:
    if row_number % 2 == 0:
        table.insert(parent='', index='end', values=row, tags=('even',))
    else:
        table.insert(parent='', index='end', values=row, tags=('odd',))
    row_number += 1

# Configure column headings
for col in headings:
    table.heading(col, text=col)

######################################################################################

# function to update options
def update_options_f2(chip_id):
    """this function is part of a chain that updates options in frame 2
    it needs a correct track name to work. !!! No error handling is done here"""
    url_id_event_f2 = 'https://rasts.se/api/Registration?chip_id='+chip_id
    new_options_f2 = []
    get_result_f2:list = requests.get(url_id_event_f2).json()
    print(type(get_result_f2))
    for ev_dict_2 in get_result_f2:
        new_options_f2.append(ev_dict_2["event_name"])
    
    menu_f2['menu'].delete(0, 'end') # delete old options
    for option_f2 in new_options_f2:
        menu_f2['menu'].add_command(label=option_f2, command=tk._setit(var_f2, option_f2)) # add new options
    var_f2.set(new_options_f2[0]) # set default value

def button_clicked_f2():
    """This function updates(!!!triggers another function) the (options) in frame 2 (settings) and uses entry in the same frame"""
    entry_value:str = entry.get()
    update_options_f2(entry_value)

##Label and entry for track name
label_f2_2 = tk.Label(f2,text="Track name:")
label_f2_2.pack()
entry = tk.Entry(f2, validate="key")
entry.pack()

#button that is connected to the function(see command) and is named get events
button_f2_1 = tk.Button(f2, text="Get events", command=button_clicked_f2)
button_f2_1.pack()

##this is the options in frame 2 (settings)
options_f2 = ['Option 1', 'Option 2', 'Option 3']
var_f2 = tk.StringVar(f2)
var_f2.set(options_f2[0])
menu_f2 = tk.OptionMenu(f2, var_f2, *options_f2)
menu_f2.pack()

def button_clicked_f2_2():
    """This function is connected to buhtton _f2_2 and sets the global variale(global global_track_name) to what is inside the 
    entry field"""
    entry_value:str = entry.get()
    global global_track_name
    global_track_name = entry_value #####!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! maybe do a check so that the track exists

def button_clicked_f2_3():
    """This function is connected to button_f2_3 and sets the global variable(global_event_id) to an selected event"""
    global global_event_id
    selected_event = var_f2.get()
    global_event_id = selected_event#####!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! maybe do am error handling

###button named "set track" connected to the function(see command)
button_f2_2 = tk.Button(f2, text="Set track", command=button_clicked_f2_2)
button_f2_2.pack()

###button named "set event" connected to the function(see command)
button_f2_3 = tk.Button(f2, text="Set event", command=button_clicked_f2_3)
button_f2_3.pack()

#run the program
root.mainloop()
