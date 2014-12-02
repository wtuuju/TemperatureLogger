## Installation, coté serveur

### Creation de la base de données :
```
$ sqlite3 db.sqlite
Enter ".help" for instructions
Enter SQL statements terminated with a ";"
sqlite> CREATE TABLE temperature_table (id INTEGER PRIMARY KEY, date, temperature, temperature_2)
sqlite> .quit
```