# -*- coding : Utf-8 -*-
#!/usr/bin/python

try:
	import tkinter as Tkinter
except:
	import Tkinter as Tkinter
import time
from read_temp import *


class simpleapp_tk(Tkinter.Tk):
	def __init__(self,parent):
		Tkinter.Tk.__init__(self,parent)
		self.parent = parent
		self.initialize()

	def initialize(self):
		self.attributes('-fullscreen', 1)

		# [FR] Horloge / [EN] Clock
		self.texte_horloge = Tkinter.StringVar()
		label_horloge = Tkinter.Label(self,textvariable=self.texte_horloge,fg="black",font=("Arial",70))
		label_horloge.pack(anchor="n")

		# Temperature
		self.texte_temperature = Tkinter.StringVar()
		label_temperature = Tkinter.Label(self,textvariable=self.texte_temperature,fg="black",font=("Arial",70))
		label_temperature.pack(anchor="s")


		self.update_texte_horloge()
		self.update_texte_temperature()

	# [FR] Rafraichir le label "label_horloge"
	# [EN] Update label "label_horloge" (clock)
	def update_texte_horloge(self):
		DateHeure = time.strftime("%d/%m %H:%M:%S")
		self.texte_horloge.set(DateHeure)
		self.after(20, self.update_texte_horloge)

	# Rafraichir le label "label_temperature"
	# [EN] Update label "label_temperature"
	def update_texte_temperature(self):
		temperature = str(read_temp()) + " °C"
		self.texte_temperature.set(temperature)
		self.after(60000, self.update_texte_temperature) # 1min

if __name__ == "__main__":
	app = simpleapp_tk(None)
	app.title('Temperature GUI')
	app.mainloop()