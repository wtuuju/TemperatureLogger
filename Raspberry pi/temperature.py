# -*- coding : Utf-8 -*-
#!/usr/bin/python

import time, urllib, urllib.request
from decimal import Decimal
from read_temp import *

# ------------------------------------------------------------------------------------
# [FR] Parametres / [EN] Settings ----------------------------------------------------
# ------------------------------------------------------------------------------------
urlServeur = 'http://VOTRESERVEUR/log.php'
motdepasseServeur = 'motdepasse'
# ------------------------------------------------------------------------------------

# [FR] Envoyer la temperature au serveur.
# [EN] Send temperature to the server.
def logger(temperature):
	timestamp = time.time()
	url = str(urlServeur) + '?password=' + str(motdepasseServeur) + '&temperature=' + str(temperature) + '&time=' + str(timestamp)
	
	# [FR] Envoie requete et traitement d'erreur HTTP au besoin
	# [EN] Send request and HTTP errors processing
	try:
		requete = urllib.request.urlopen(url)
	except IOError as e:
		if hasattr(e, 'reason'):
			print(str(time.strftime('%d/%m/%y %H:%M:%S')) + " : Echec lors du contact au serveur.")
			print(str(time.strftime('%d/%m/%y %H:%M:%S')) + " : Raison : " + e.reason)
		elif hasattr(e, 'code'):
			print(str(time.strftime('%d/%m/%y %H:%M:%S')) + " : Le serveur n'a pu satisfaire la demande.")
			print(str(time.strftime('%d/%m/%y %H:%M:%S')) + " : Code d' erreur : " + e.code)

# [FR] Mesure la temperature, l'envoie au serveur et l'imprime sur le terminal
# [EN] Measure the temperature, send it to the server and print it to the terminal
temperature = read_temp()
logger(temperature)
print(str(time.strftime('%d/%m/%y %H:%M:%S')) + ' : ' + str(temperature) + ' Deg C')
quit()