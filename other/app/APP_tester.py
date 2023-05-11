from APP import split_time, seconds_to_time_format, time_formater, time_format_parse
import unittest
import random
import datetime
class TestAPP(unittest.TestCase):
    def test_split_time(self):
        hour = random.randint(0, 256)
        minute = random.randint(0, 256)
        second = random.random()
        time:str=str(hour)+":"+str(minute)+":"+str(second)
        self.assertEqual(split_time(time), (hour, minute, second),"split_time failed")

    def test_seconds_to_time_format(self):
        seconds_1 = random.randint(0, 59)
        seconds_2 = 60
        rand_choise =random.choice([seconds_1, seconds_2])
        if rand_choise == seconds_1:
            self.assertEqual(seconds_to_time_format(rand_choise), (0,0,rand_choise,0), "seconds_to_time_format failed")
        else:
            self.assertEqual(seconds_to_time_format(rand_choise), (0,1,0,0), "seconds_to_time_format failed")


if __name__ == '__main__':
    unittest.main()