<?php

// URL JSON
$jsonUrl = "https://puzzles.code100.dev/code100/puzzles/100hits/coordinatesystem.json";

// Global variables

$point_OneStart = array('x' => 145, 'y' => 75);
$point_OneEnd = array('x' => 165, 'y' => 225);

$point_ZeroOne = array('x' => 250, 'y' => 150);
$point_ZeroTwo = array('x' => 410, 'y' => 150);

// Digit 1
function CheckOne($point) {

    global $point_OneStart, $point_OneEnd;
    
    // Verify if the point is inside the rectangle
    if ($point['x'] >= $point_OneStart['x'] && $point['x'] <= $point_OneEnd['x'] && $point['y'] >= $point_OneStart['y'] && $point['y'] <= $point_OneEnd['y']) {
        return true;
    } 
    else
        return false;
}

// Digit 0, check from center circle
function CheckZero($point, $point_Cicle) {

    // Find the distance between the points, from the center of the circle
    $distanceX = abs($point_Cicle['x'] - $point['x']);
    $distanceY = abs($point_Cicle['y'] - $point['y']);

    // Radius
    $radius = sqrt(pow($distanceX, 2) + pow($distanceY, 2));

    // Verify if the point is inside the circle
    if ($radius >= 55 && $radius <= 75) {
        return true;
    } 
    else {
        return false;
    }
}

try {
    // Read the JSON from the URL
    $jsonData = file_get_contents($jsonUrl);
    if ($jsonData === false) {
        throw new Exception("JSON file not found / read.");
    }

    // Decode the JSON
    $data = json_decode($jsonData, true);
    if ($data === null) {
        throw new Exception("Decoding JSON failed.");
    }

    echo "JSON OK. Whidt: {$data['width']}, height: {$data['height']}, Tot Point (n): " . count($data['coords']) . "\n";

    // Get the width and height
    $width = $data['width'];
    $height = $data['height'];

    // Initialize the total points
    $iTotPoint = 0;

    // Loop through the points in coords
    foreach ($data['coords'] as $coord) {

        // Create an array with the x and y coordinates
        $point = array('x' => $coord[0], 'y' => $coord[1]);

        // Check if the point is inside the rectangle
        if (CheckOne($point)) {
            // Found a point inside the rectangle
            $iTotPoint++;
        }
        else if (CheckZero($point,$point_ZeroOne)) {
            // Found a point inside the first zero
            $iTotPoint++;
        }   
        else if (CheckZero($point,$point_ZeroTwo)) {
            // Found a point inside the second zero
            $iTotPoint++;
        }
    }   

    echo "Total Point in 100: $iTotPoint\n";

} catch (Exception $e) {
    // Exception
    echo "Errore: " . $e->getMessage();
}

?>