<?php
// Set up API credentials
$app_id = '62d2798b';
$app_key = '80eec9b8f18f564328a1c86e01110d56';

// Define ingredient to search for
$ingredient = 'apple';

// Make API request
$url = "https://api.edamam.com/api/food-database/v2/parser?app_id={$app_id}&app_key={$app_key}&ingr={$ingredient}";
$response = file_get_contents($url);
$data = json_decode($response, true);

// Get category information
$category = $data['hints'][0]['food']['category'];

// Display category information
echo "The category of {$ingredient} is {$category}.";
?>
