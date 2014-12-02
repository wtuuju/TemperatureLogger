## Installation, coté Raspberry Pi
### Tâche cron

```
crontab -e
```
Ajouter à la fin (et adapter le chemin) :
```
*/1 * * * * python3.2 /home/pi/temperaturelogger/temperature.py >> out.log
```
Enregister et quitter. Puis :
```
chmod a+x temperature.py
```

### N'oubliez pas également d'executer ces deux commandes :
```
sudo modprobe w1-gpio
sudo modprobe w1-therm
```