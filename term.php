<?php
// curl -X POST -d "command=notepad" http://127.0.0.1:8000/raspberry/php-brain/term.php (à distance)

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['command'])) {
    $command = $_POST['command'];
    $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

    if ($command === 'clear') {
        // Effacer les résultats
        echo "<pre>Résultats effacés</pre>";
        exit; // S'assurer de ne rien traiter après cette commande
    }

    if ($isWindows) {
        // Utiliser chcp 65001 pour changer l'encodage en UTF-8
        $command = "chcp 65001 >NUL & " . $command;
        // Exécuter la commande et capturer la sortie
        $output = shell_exec($command . " 2>&1");
    } else {
        // Exécuter des commandes sous Linux
        // $command .= " > /dev/null 2>&1 &";
        $output = shell_exec($command . " 2>&1");
    }

    if ($output !== null) {
        // Convertir l'encodage en UTF-8 si nécessaire
        if ($isWindows) {
            $output = mb_convert_encoding($output, 'UTF-8', 'UTF-8');
        }
        echo "<pre>" . htmlspecialchars($output, ENT_QUOTES, 'UTF-8') . "</pre>";
    } else {
        echo "Fermeture de l'application graphique OK !";
    }
} else {
    echo "Aucune commande reçue.";
}
?>