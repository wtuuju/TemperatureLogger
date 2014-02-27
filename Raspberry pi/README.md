[FR] Tâche cron / [EN] cron job
=================

*/1 * * * * python3.2 /home/pi/temperaturelogger/temperature.py >> out.log

( => chmod a+x temperature.py )

--------

sudo modprobe w1-gpio
sudo modprobe w1-therm