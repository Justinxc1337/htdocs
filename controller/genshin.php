<?php
include '../view/includeviews/header2.php';
include '../view/genshinshow.php';
// Function to fetch JSON data from API endpoint for a specific ID
function fetchCharacterData($id) {
    $id = $_GET['id'] ?? 1; // get the ID from the query string, default to 1 if not provided
    $url = "https://gsi.fly.dev/characters/$id";    
    // Initialize cURL session
    $curl = curl_init();
    
    // Set cURL options
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Execute cURL request
    $response = curl_exec($curl);
    
    // Close cURL session
    curl_close($curl);
    
    // Decode JSON response
    $data = json_decode($response, true);
    
    // Return character data
    return $data;
}

// Function to display only the name and weapon of a character
function displayCharacterInfo($id) {
    // Fetch character data for the specified ID
    $character = fetchCharacterData($id);
    
    // Check if character data is available and contains the required fields
    if ($character && isset($character['result']['name'], $character['result']['weapon'], $character['result']['rarity'], $character['result']['vision'])) {
        // Extract information
        $name = $character['result']['name'];
        $weapon = $character['result']['weapon'];
        $rarity = $character['result']['rarity'];
        $vision = $character['result']['vision'];
        
        // Display information
        
        echo "<div class='genshin'>Name: $name</div><br>";
        echo "<div class='genshin'>Rarity: $rarity</div><br>";
        echo "<div class='genshin'>Weapon: $weapon</div><br>";
        echo "<div class='genshin'>Vision: $vision</div><br>";

    } else {
        // Display error message if character data is not available or missing required fields
        echo "Character data not found or missing required fields for ID: $id";
    }
}

// Example: Fetch and display name and weapon for character ID 1
$characterId = 1;
displayCharacterInfo($characterId);
?>