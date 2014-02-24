# -*- coding : Utf-8 -*-
#!/usr/bin/python

import os, glob

os.system('modprobe w1-gpio')
os.system('modprobe w1-therm')

# ------------------------------------------------------------------------------------
# [FR] Parametres / [EN] Settings ----------------------------------------------------
# ------------------------------------------------------------------------------------
device_file='/sys/bus/w1/devices/28-000004238bf7/w1_slave'  # Our DS18B20
precisionMesure = 1
# ------------------------------------------------------------------------------------

# [FR] Mesure la temperature. Le nombre de décimale est definie par la variable 'precisionMesure'
# [EN] Measure the temperature. Number of decimal is defined by the variable 'precisionMesure'
def read_temp():
	f = open(device_file, 'r')
	lines = f.readlines()
	f.close()
	temp_string = lines[1].strip()[-5:]
	temp_c = round(float(temp_string)/1000.0,precisionMesure)
	return temp_c