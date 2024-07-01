<?php

// URL del JSON
$jsonUrl = "https://puzzles.code100.dev/code100/puzzles/100hits/coordinatesystem.json";
// Aggiunta delle variabili globali point start One e point start phinić

$point_OneStart = array('x' => 145, 'y' => 75);
$point_OneEnd = array('x' => 165, 'y' => 225);

$point_ZeroOne = array('x' => 250, 'y' => 150);
$point_ZeroTwo = array('x' => 410, 'y' => 150);

function CheckOne($point) {

    global $point_OneStart, $point_OneEnd;
    
    // Verificare se il punto è dentro al range
    if ($point['x'] >= $point_OneStart['x'] && $point['x'] <= $point_OneEnd['x'] && $point['y'] >= $point_OneStart['y'] && $point['y'] <= $point_OneEnd['y']) {
        return true;
    } 
    else
        return false;
}

function CheckZero($point, $point_Cicle) {

    // Find the distance between the points
    $distanceX = abs($point_Cicle['x'] - $point['x']);
    $distanceY = abs($point_Cicle['y'] - $point['y']);

    // Radius
    $radius = sqrt(pow($distanceX, 2) + pow($distanceY, 2));

    // Verifica se il raggio è compreso tra 75 e 55
    if ($radius >= 55 && $radius <= 75) {
        return true;
    } 
    else {
        return false;
    }
}

try {
    // Tentativo di leggere il contenuto del JSON
    $jsonData = file_get_contents($jsonUrl);
    if ($jsonData === false) {
        throw new Exception("Impossibile leggere il JSON dall'URL.");
    }

    // Tentativo di decodificare il JSON
    $data = json_decode($jsonData, true);
    if ($data === null) {
        throw new Exception("Errore nella decodifica del JSON.");
    }

    echo "JSON OK. Whidt: {$data['width']}, height: {$data['height']}, Tot Point (n): " . count($data['coords']) . "\n";

    // Estrazione di width e height dal JSON
    $width = $data['width'];
    $height = $data['height'];

    $iTotPoint = 0;

    // Iterare attraverso l'array dei punti
    foreach ($data['coords'] as $coord) {

        // Creazione di un array per il punto
        $point = array('x' => $coord[0], 'y' => $coord[1]);

        // Esegui la funzione 1_CheckOne passando il punto
        if (CheckOne($point)) {
            // Incrementa il valore di $iTotPoint
            $iTotPoint++;
        }
        else if (CheckZero($point,$point_ZeroOne)) {
            // Incrementa il valore di $iTotPoint
            $iTotPoint++;
        }   
        else if (CheckZero($point,$point_ZeroTwo)) {
            // Incrementa il valore di $iTotPoint
            $iTotPoint++;
        }
    }   

    echo "Total Point in 100: $iTotPoint\n";

} catch (Exception $e) {
    // Exception
    echo "Errore: " . $e->getMessage();
}

?>