<?php
header('Content-Type: application/json');

$dataFile = "data.json";

// Načtení stávajícího obsahu
if (file_exists($dataFile)) {
    $currentData = json_decode(file_get_contents($dataFile), true);
    if (!is_array($currentData)) $currentData = [];
} else {
    $currentData = [];
}

// Získání POST dat
$input = json_decode(file_get_contents("php://input"), true);
if (!isset($input["id"]) || !isset($input["exp"])) {
    echo json_encode(["success" => false, "error" => "Chybí data"]);
    exit;
}

// Přidání nového záznamu
$currentData[] = [
    "id" => $input["id"],
    "exp" => intval($input["exp"])
];

// Uložení zpět do souboru
if (file_put_contents($dataFile, json_encode($currentData, JSON_PRETTY_PRINT))) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Nepodařilo se uložit"]);
}
?>
