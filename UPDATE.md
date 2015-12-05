<h1>Aktualisierungsanleitung</h1>

<h2>1. Einfach und schnell bzw. alte durch neue Datene ersetzen</h2>
<p>git pull</p>

<h2>2. Datenbank aktualisieren</h2>
<p>Ab und an kommt eine neue Tabelle dazu. Einige nach dem Start etwa, die Tabelle "st_logs". Hier empfiehlt es sich in install/sqldump.sql zu gehen und von dort die jeweilige Anweisung herauszukopieren und in phpMyAdmin auszuführen.</p>

<h2>3. composer.json prüfen</h2>
<p>Wird "git pull" verwendet, erledigt sich das mit den Abhängigkeiten von alleine. Kopiert man allerdings die neuen über die alten Dateien, so kann es sein, dass einige neue Abhängigkeiten fehlen. Um das zu prüfen, hilft ein Blick in die composer.json. Dort findet man alle Abhängiektein und kann diese mit der aktuellen Version vergleichen.</p>
