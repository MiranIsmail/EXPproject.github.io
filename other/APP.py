import tkinter as tk
from tkinter import ttk
import formater
import tkinter.messagebox

data = {"chip_id": "4243283", "total_time": "00:00:26.937", "track_time": [["Start", "00:00:00.000", "00:00:00.000", 0, "47086825730"], ["101", "00:00:00.518", "00:00:00.518", 0.52, "47086826248"], ["101", "00:00:15.653", "00:00:15.134", 15.13, "47086841383"], ["102", "00:00:26.937", "00:00:11.284", 11.28, "47086852667"],["Start", "00:00:00.000", "00:00:00.000", 0, "47086825730"], ["101", "00:00:00.518", "00:00:00.518", 0.52, "47086826248"], ["101", "00:00:15.653", "00:00:15.134", 15.13, "47086841383"], ["102", "00:00:26.937", "00:00:11.284", 11.28, "47086852667"],["Start", "00:00:00.000", "00:00:00.000", 0, "47086825730"], ["101", "00:00:00.518", "00:00:00.518", 0.52, "47086826248"], ["101", "00:00:15.653", "00:00:15.134", 15.13, "47086841383"], ["102", "00:00:26.937", "00:00:11.284", 11.28, "47086852667"],["Start", "00:00:00.000", "00:00:00.000", 0, "47086825730"], ["101", "00:00:00.518", "00:00:00.518", 0.52, "47086826248"], ["101", "00:00:15.653", "00:00:15.134", 15.13, "47086841383"], ["102", "00:00:26.937", "00:00:11.284", 11.28, "47086852667"]]}
headings = ['Station ID', 'Start Time','Delta Time']

def start():
    result=tkinter.messagebox.askquestion("RASTS",  "Is the usb-reader plugged in? if not please plugg it in then press yes.")
    if result == 'yes':
        formater.main()

root = tk.Tk()
root.title("RASTS")
root.iconbitmap(r"C:\Users\miran\Desktop\EXPproject\other\logo.ico")

# Create a label
label = ttk.Label(root, text="Hello from RASTS.se", font=('helvetica', 62), background='gray', foreground='white')
label.pack(fill='both', expand=True)

# Create a button to start the program
start_button = ttk.Button(root, text="START", command=start)
start_button.pack(pady=10)

# Create a table
table = ttk.Treeview(root, columns=headings, show='headings')
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

# Create a button to close the window
close_button = ttk.Button(root, text="Close", command=root.destroy)
close_button.pack(pady=10)

root.mainloop()
