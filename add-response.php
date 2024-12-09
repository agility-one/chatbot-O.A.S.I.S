<?php
$dataFile = 'data-generic.json';
$data = json_decode(file_get_contents($dataFile), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $question = htmlspecialchars($input['question'], ENT_NOQUOTES | ENT_HTML401, 'UTF-8');
    $response = htmlspecialchars($input['response'], ENT_NOQUOTES | ENT_HTML401, 'UTF-8');

    $data['responses'][$question] = $response;

    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}
?>