# LoginLink for Contao Open Source CMS

Loggt ein bestehendes Mitglied mit einem Loginkey (Token) ein.


## Installation

Install the bundle via Composer:

```
composer require thescrat/contao-loginlink
```


## Konfiguration

Im Root-Seitenelement kann der Login für die Seitenstruktur erlaubt werden.
Ebenfalls kann die Länge des Loginkey ausgewählt werden, der bei der Registrierung generiert wird.
Die Weiterleitung leitet das Mitglied nach dem Login auf die ausgewählte Seite.

## Benutzung
1. Jede öffentliche Seite kann genutzt werden (z.B. /index.html)
2. Der Parameter **?key=** gefolgt vom Loginkey ist notwenig. (z.B. /index.html?key=xxxxxxx)

## Weiterleitung auf eine geschützte Seite
Hierfür zusätzlich **&redirect=** in die URL anhängten mit dem alias der geschützten Seite. (z.B. /index.html?key=xxxxx&redirect=mitgliederbereich)  


