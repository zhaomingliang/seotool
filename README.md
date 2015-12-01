<h1>SEO Tool v2 by damianschwyrz.de</h1>
<p>Das Tool bietet im Grunde die gleichen Funktionen, wie die erste Version. Hinzugekommen sind einige neue Funktionen, die Codebasis wurde komplett überarbeitet. Außerdem kommt ein ordentliches Adminpanel zum Einsatz. Ich hab mich da für SB Admin entschieden.</p>
<h2>Voraussetzungen</h2>
<p>Wie auch schon bei der ersten Version: Es ist notwendig einen Cronjob per SSH auszuführen, d.h. ein normaler Webspace reicht in der Regel nicht aus. Ursächlich hierfür ist, dass das auszuführende Programm in Perl geschrieben ist und je nach Anzahl von Keywords bis zu 45 Minuten am Stück aktiv ist. So etwas lässt sich nur schwer mit PHP realisieren, man müsste in den Serverkonfigurationen einiges abändern (Max Exec Time etwa,...).</p>

<strong>Ansonsten:</strong>
<ul>
<li>Server mit SSH-Zugang</li>
<li>PHP 5.6</li>
<li>MYSQL 5.5</li>
<li>PERL 5.20</li>
</ul>

<h2>Installationsanleitung</h2>
