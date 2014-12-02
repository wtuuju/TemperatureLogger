# -*- coding : Utf-8 -*-
#!/usr/bin/python

import os, glob, time, urllib, urllib.request
from decimal import Decimal

# ------------------------------------------------------------------------------------
# Parametres -------------------------------------------------------------------------
# ------------------------------------------------------------------------------------
urlServeur = 'http://192.168.1.50/temp/log.php'
motdepasseServeur = 'azerty'

CapteursTemperature = ['/sys/bus/w1/devices/28-000004238bf7/w1_slave', '/sys/bus/w1/devices/28-000004ce8f24/w1_slave']
precisionMesure = 1 # Nombre de décimales
# ------------------------------------------------------------------------------------

os.system('modprobe w1-gpio')
os.system('modprobe w1-therm')

# Fonction de mesure de la temperature
def MesurerTemperature():
	temperatureLue = []
	for Capteur in CapteursTemperature :
		f = open(Capteur, 'r')
		fichierCapteur = f.read()
		f.close()
		# On divise en deux ligne et on selectionne la deuxieme. Puis on découpe la ligne en mots à chaque espace. On ne retient que le 10ieme, auquel on lui retire les deux premiers caractères (t=). Ouf :P
		temperatureBrute = (fichierCapteur.split("\n")[1].split(" ")[9])[2:]
		temperatureLue.append(round(float(temperatureBrute)/1000.0,precisionMesure))
	return temperatureLue


# Fonction pour envoyer la temperature au serveur
def EnvoyerTemperature(temperature):
	timestamp = time.time()
	url = str(urlServeur) + '?motdepasse=' + str(motdepasseServeur) + '&date=' + str(timestamp) + '&temperature=' + str(temperature[0]) + '&temperature_2=' + str(temperature[1])

	# Envoie requete et traitement d'erreur HTTP au besoin
	try:
		requete = urllib.request.urlopen(url)
	except IOError as e:
		if hasattr(e, 'reason'):
			print(str(time.strftime('%d/%m/%y %H:%M:%S')) + " : Echec lors du contact au serveur.")
			print(str(time.strftime('%d/%m/%y %H:%M:%S')) + " : Raison : " + e.reason)
		elif hasattr(e, 'code'):
			print(str(time.strftime('%d/%m/%y %H:%M:%S')) + " : Le serveur n'a pu satisfaire la demande.")
			print(str(time.strftime('%d/%m/%y %H:%M:%S')) + " : Code d' erreur : " + e.code)

# Mesure la temperature, l'envoie au serveur et l'imprime sur le terminal
temperature = MesurerTemperature()
EnvoyerTemperature(temperature)
print(str(time.strftime('%d/%m/%y %H:%M:%S')) + ' : ' + str(temperature) + ' Deg C')
quit()
