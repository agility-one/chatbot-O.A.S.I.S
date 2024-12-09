<?php
function formatResponses($responses) {
    foreach ($responses as $key => &$response) {
        // Vérifier si la réponse est une chaîne et non un tableau
        if (is_string($response)) {
            // Convertir la chaîne en tableau
            $response = [$response];
        }
        // Pour les réponses déjà sous forme de tableau, ne rien faire
    }
    return $responses;
}

function formatDataGeneric($filePath) {
    // Lire le contenu du fichier JSON
    $jsonContent = file_get_contents($filePath);
    $data = json_decode($jsonContent, true);

    if (isset($data['responses'])) {
        $data['responses'] = formatResponses($data['responses']);
    }

    // Encoder à nouveau les données en JSON formaté
    $formattedJsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    
    // Écrire les données formatées dans le fichier
    file_put_contents($filePath, $formattedJsonContent);
}

// Chemin vers le fichier data-generic.json
$filePath = 'data-generic.json';
formatDataGeneric($filePath);

echo "Le fichier a été formaté avec succès.";
?>