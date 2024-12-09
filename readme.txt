Chatbot O.A.S.I.S
-------------------

Description :
--------------

O.A.S.I.S est un chatbot interactif conçu pour répondre à diverses questions, fournir des informations, et exécuter des commandes spécifiques. Il est capable de lire des messages à voix haute, d'ouvrir des pages web, et d'exécuter des commandes terminales. Ce chatbot est conçu pour être un assistant polyvalent et utile.
Il a été développé grâce a un système GPT 4, et il utilise les langages html css js et php.
Il a été conçu pour être portable sous linux, microsoft, apple, et bsd de par sa technologie web.
Il peut être égalemnt mis en container dans une solution apache ou nginx ou un pod de kubernetes.
Il est sous licence GNU GENERAL PUBLIC LICENSE v3.

Fonctionnalités :
------------------
1. Réponses aux Questions

Le chatbot peut répondre à une variété de questions prédéfinies. Les réponses sont stockées dans un fichier JSON (data-generic.json). Si une question n'est pas reconnue, elle est enregistrée dans un fichier de log (unrecognized-questions.json) pour une future amélioration.

2. Synthèse Vocale

Le chatbot peut lire les réponses à voix haute en utilisant la synthèse vocale. Cette fonctionnalité est activée par défaut pour toutes les réponses.

3. Commandes Spéciales (taper : liste des commandes)

Le chatbot peut exécuter plusieurs commandes spéciales comme par exemple :

    heure : Affiche l'heure actuelle.

    date : Affiche la date actuelle.

    clear : Efface les messages affichés.

    stop : Arrête la synthèse vocale.

    cherche ou recherche : Permet de rechercher un mot ou phrase avec google ex: "(re)cherche technicien informatique"

    terminal : Ouvre un terminal web pour exécuter des commandes.

    google : Ouvre Google dans un nouvel onglet.

    bing : Ouvre Bing dans un nouvel onglet.

    wikipedia : Ouvre Wikipédia en français dans un nouvel onglet.

    projets raspberry : Ouvre la page des projets Raspberry Pi.

    meteo : Ouvre la météo de Digoin.

    metar : Ouvre la carte météo de Paris.

et bien d'autres encore ! A vous de lui donner toute la puissance !

4. Recherche Google

Le chatbot peut effectuer des recherches Google pour des mots ou des phrases en utilisant les mots-clés "cherche" et "recherche". Par exemple, en tapant "cherche chien de chasse", le chatbot ouvrira une page Google avec les résultats de recherche pour "chien de chasse".

5. Terminal Web

Le chatbot inclut un terminal web intégré qui permet d'exécuter des commandes système. Les résultats des commandes sont affichés dans le terminal. La commande clear efface les résultats du terminal.

6. Ajout de Réponses

Le chatbot permet d'ajouter de nouvelles réponses via un formulaire intégré. Les nouvelles questions et réponses sont enregistrées dans le fichier data-generic.json.

Fichiers du chatbot et leurs rôles respectifs :
------------------------------------------------
1. index.html (ou frontend.html à renommer)

Ce fichier contient l'interface utilisateur du chatbot, y compris le style CSS et le script JavaScript pour gérer les interactions utilisateur, et lancer les commandes intégrés au chatbot. (liste des commandes)
Il est possible de commenter et/ou supprimer (meilleur solution niveau sécurité) la fonction formulaire comme indiqué dans le fichier pour les non administrateurs afin de ne pas polluer la base de données.

2. backend.php

Ce fichier traite les requêtes utilisateur, génère des réponses basées sur les données stockées, et enregistre les questions non reconnues.

3. add-response.php

Ce fichier permet d'ajouter de nouvelles questions et réponses au fichier data-generic.json via un formulaire.

4. term.php

Ce fichier gère les commandes du terminal web, exécute les commandes système et affiche les résultats.

5. data-generic.json

Ce fichier contient les questions et réponses prédéfinies que le chatbot utilise pour répondre aux utilisateurs.

6. unrecognized-questions.json

Ce fichier enregistre les questions non reconnues par le chatbot pour une future amélioration.

7. format-data.php

lancer ce script 1 fois par jour, pour mettre en forme les questions et réponses, cela permet de voir et insérer plus facilement des mots ou phrases clefs et réponses en mode manuel si nécessaire.

Installation :
--------------- 

    Clonez le dépôt sur votre serveur web.

    Assurez-vous que PHP est installé et configuré sur votre serveur.

    Placez tous les fichiers dans le répertoire racine de votre serveur web.

    Accédez à index.html via votre navigateur pour utiliser le chatbot.

Installation et configuration du Serveur web php :
---------------------------------------------------
1) Télécharger le dossier php8.3x selon ce que vous voulez utiliser.

https://windows.php.net/downloads/releases/php-8.3.14-nts-Win32-vs16-x64.zip (FastCGI - CGI)

Non-Thread Safe (NTS)
----------------------
  - Non Sécurité des Threads : Cette version ne gère pas les threads et est donc plus rapide, mais moins stable dans un environnement multi-thread.

  - Gestion des Données Partagées : Utilise une seule copie de stockage pour tous les threads, ce qui peut entraîner des blocages fréquents.

  - Utilisation : Idéale pour les serveurs web utilisant FastCGI ou CGI, où chaque requête PHP est exécutée dans son propre processus.

ou alors :
-----------

https://windows.php.net/downloads/releases/php-8.3.14-Win32-vs16-x64.zip (MPM Worker)

Thread Safe (TS)
-----------------
  - Sécurité des Threads : Cette version est conçue pour être utilisée dans des environnements où plusieurs threads peuvent exécuter du code PHP simultanément.

  - Gestion des Données Partagées : Elle crée une copie locale des données partagées pour chaque thread afin d'éviter les conditions de concurrence critiques.

  - Utilisation : Recommandée pour les serveurs web utilisant des modèles de concurrence basés sur les threads, comme Apache avec le module MPM Worker.

2) activer JIT avec php 8.3x (si besoin)

zend_extension=opcache (decommenter cette ligne)

et dans la section [opcahe] mettre ou activer ces lignes :
-----------------------------------------------------------
[opcache]
; Determines if Zend OPCache is enabled

opcache.enable=1
opcache.jit_buffer_size=100M
opcache.jit=tracing

vérifier si cgi ou mpm worker :
--------------------------------
php -i | grep Thread

Thread Safety = disabled (thread safe est désactivé)
Thread Safety = enabled (thread safe est activé)

sous linux (system debian like) pour mpm worker et fastcgi en simultané :
--------------------------------------------------------------------------
sudo apt-get install libapache2-mod-fcgid (télécharger les paquets)

sudo a2enmod actions fcgid alias (active les modules)
sudo a2enmod mpm_worker

configurer apache en conséquence :
-----------------------------------

<IfModule mpm_worker_module>
    StartServers           2
    MinSpareThreads        25
    MaxSpareThreads        75
    ThreadLimit            64
    ThreadsPerChild        25
    MaxRequestWorkers      150
    MaxConnectionsPerChild 0
</IfModule>

<IfModule mod_fcgid.c>
    AddHandler fcgid-script .fcgi
    FcgidConnectTimeout 20
    FcgidProcessLifeTime 3600
    FcgidMaxProcesses 20
    FcgidMaxProcessesPerClass 8
    FcgidMinProcessesPerClass 0
    FcgidIdleTimeout 300
    FcgidIdleScanInterval 120
    FcgidBusyTimeout 300
    FcgidBusyScanInterval 80
    FcgidErrorScanInterval 30
    FcgidZombieScanInterval 30
    FcgidMaxRequestLen 8131072
</IfModule>


3) créer un script php.cmd (sous win32) et le placer dans c:\windows (si vous désirez utiliser en développement le serveur php embarqué)

@echo off
:: Serveur Web Embedded PHP
set "PHP_PATH=c:\php83"
set "WEB_DIR=c:\www"
echo.
echo "Serveur Web Embedded is running !"
echo.
"%PHP_PATH%\php.exe" -S 0.0.0.0:8000 -t "%WEB_DIR%"

4) puis win + r et tapez php, le serveur php embeded est maintenant lancé.

version linux :
----------------
nano serveur_web.sh

#!/bin/bash
# Serveur Web Embedded PHP

PHP_PATH="/chemin/vers/php" # Remplacer par le chemin vers PHP du système
WEB_DIR="/chemin/vers/www"  # Remplacer par le chemin du répertoire web

echo
echo "Le Serveur Web Embedded est en cours d'exécution !"
echo

$PHP_PATH/php -S 0.0.0.0:8000 -t $WEB_DIR

Chemins par Défaut pour PHP 8.3x sous debian :
-----------------------------------------------
   - Exécutable PHP : /usr/bin/php8.3

   - Répertoire des fichiers de configuration PHP : /etc/php/8.3/

   - Fichier de configuration principal pour Apache : /etc/php/8.3/apache2/php.ini

   - Fichier de configuration principal pour la ligne de commande : /etc/php/8.3/cli/php.ini

   - Répertoire des modules PHP : /usr/lib/php/8.3/

   - Répertoire des fichiers de configuration des modules : /etc/php/8.3/mods-available/

puis :
-------
chmod +x serveur_web.sh (rendre le script executable)

./serveur_web.sh (lancer le script)

Utilisation :
--------------

    Interagir avec le chatbot : Tapez votre message dans le champ de saisie et appuyez sur Entrée.

    Utiliser les commandes spéciales : Tapez les commandes spéciales comme "heure", "date", "clear", etc.

    Ajouter de nouvelles réponses : Utilisez le formulaire intégré pour ajouter de nouvelles questions et réponses.

    Utiliser le terminal web : Ouvrez le terminal web et tapez vos commandes système.

Exemple de Questions et Réponses :
-----------------------------------
Questions

    "bonjour"

    "comment vas-tu ?"

    "donne moi des informations"

    "parle moi de toi"

Réponses

    "Bonjour ! Comment ça va ?"

    "Je vais bien, merci ! Et toi ?"

    "Quelles informations recherches-tu ?"

    "Je suis O.A.S.I.S, un assistant virtuel développé pour interagir avec toi et répondre à tes questions."

nathalie x') : https://www.youtube.com/watch?v=i0OPx6q6Hlk