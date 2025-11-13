<?php
header('Content-Type: application/json; charset=utf-8');

// Tillåt endast POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Endast POST tillåten.']);
    exit;
}

// Fil för röster (kontrollera att denna är skrivbar för PHP)
$votesFile = __DIR__ . '/votes.txt';

// Tillåtna bilder (option1.jpg – option31.jpg)
$allowed = [];
for ($i = 1; $i <= 31; $i++) {
    $allowed[] = "option{$i}.jpg";
}

// Hämta bildnamn och sanera
$image = $_POST['image'] ?? '';
$image = basename(trim($image));

// Kontrollera giltigt val
if ($image === '' || !in_array($image, $allowed, true)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Ogiltigt val.']);
    exit;
}

// Spara rösten (lägg till rad)
$line = $image . PHP_EOL;
$success = @file_put_contents($votesFile, $line, FILE_APPEND | LOCK_EX);

if ($success === false) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Kunde inte spara rösten. Kontrollera filrättigheter.']);
    exit;
}

// Klart!
echo json_encode(['status' => 'ok', 'message' => "Tack! Du röstade på {$image}"]);
exit;
