<?php
$dataFile = 'data-generic.json';
$data = json_decode(file_get_contents($dataFile), true)['responses'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $message = htmlspecialchars($input['message'], ENT_QUOTES, 'UTF-8');
    $response = get_response($message, $data);
    $voiceRequired = ($response == "Je ne suis pas sûr de comprendre ta question.");

    if ($voiceRequired) {
        log_interaction($message);
        echo json_encode(['response' => $response, 'recognized' => false, 'voiceRequired' => true]);
    } else {
        echo json_encode(['response' => $response, 'recognized' => true, 'voiceRequired' => false]);
    }
}

function get_response($message, $data) {
    $message = strtolower($message); // Convertir le message en minuscules
    $bestMatch = null;
    $bestMatchLength = 0;

    foreach ($data as $key => $responses) {
        $keywords = explode(", ", strtolower($key)); // Convertir les mots-clés en minuscules
        foreach ($keywords as $keyword) {
            // Utiliser des expressions régulières pour rechercher des mots et des phrases clés
            if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $message)) {
                $keywordLength = strlen($keyword);
                if ($keywordLength > $bestMatchLength) {
                    $bestMatch = $responses;
                    $bestMatchLength = $keywordLength;
                }
            }
        }
    }

    if ($bestMatch !== null) {
        // Vérification et sélection d'une réponse aléatoire
        if (is_array($bestMatch)) {
            return $bestMatch[array_rand($bestMatch)];
        } else {
            return $bestMatch;
        }
    }

    return "Je ne suis pas sûr de comprendre ta question.";
}

function log_interaction($message) {
    $logFile = 'unrecognized-questions.json';
    $logData = json_decode(file_get_contents($logFile), true) ?? [];
    if (!in_array($message, $logData)) {
        $logData[] = $message;
        file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
?>