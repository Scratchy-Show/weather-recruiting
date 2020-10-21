# Weather

Exercice à la suite d'une candidature spontanée.
Énoncé de l'exercice dans le fichier `instructions_exo-sf.md`.

------------------------------------------------------------------------------------------------------------------------------------------

## Badge Codacy
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/422049829cd14200a1063a2b62b94a14)](https://www.codacy.com/gh/Scratchy-Show/weather-recruiting/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Scratchy-Show/weather-recruiting&amp;utm_campaign=Badge_Grade)

------------------------------------------------------------------------------------------------------------------------------------------
## Environnement utilisé pour le développement

* Symfony 4.4.15

* Composer 1.10.15

* Wampserver 3.2.3
  * PHP 7.4.9
  * Apache 2.4.46
    
------------------------------------------------------------------------------------------------------------------------------------------

## Installer le projet

 1. Télécharger et installer WampServer (ou équivalent : MampServer, XampServer, LampServer).
 2. Téléchargez le clone du projet dans le dossier www de WampServer :
```
git clone https://github.com/Scratchy-Show/weather-recruiting.git
```

 3. Créer un compte sur le site `https://openweathermap.org/` pour obtenir une clé API.
 4. Renseigner la variable d'environnement `WEATHER_API_KEY` dans le fichier `.env` avec la clé API.
 5. **Installer les dépendances** - Dans le répertoire racine du projet, ouvrez le CLI (Command-Line Interface) et exécutez la commande :
```
composer install
```

 6. **Lancer le serveur Symfony** - Exécuter la commande :
```
symfony server:start
```

 7. **Accéder au site** - Saisissez l'adresse indiquée par le serveur web dans votre navigateur :
```
Example: <http://127.0.0.1:8000>
```
