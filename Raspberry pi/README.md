### [FR] Tâche cron / [EN] cron job

( => crontab -e )

*/1 * * * * python3.2 /home/pi/temperaturelogger/temperature.py >> out.log

( => chmod a+x temperature.py )

### [FR] Besoin aussi de ça / [EN] Need this

sudo modprobe w1-gpio
sudo modprobe w1-therm