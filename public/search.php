<?php

    require(__DIR__ . "/../includes/config.php");
    
    // numerically indexed array of places
    $places = [];
    
    $queries = explode(',', $_GET["geo"]);
    
    //$places = query("SELECT * FROM places WHERE place_name LIKE ? OR admin_name1 LIKE ? OR postal_code LIKE ?", $queries, $queries, $queries);
        
    
    //iterate over each search term to look for matches
    for($i = 0, $amount = count($queries); $i < $amount; $i++)
    {
        if ($i == 0)
        {
            $places = query("SELECT * FROM places WHERE place_name LIKE ? OR admin_name1 LIKE ? OR postal_code LIKE ?", $queries[$i], $queries[$i], $queries[$i]);
        }
        else
        {
            $more_places = query("SELECT * FROM places WHERE place_name LIKE ? OR admin_name1 LIKE ? OR postal_code LIKE ?", $queries[$i], $queries[$i], $queries[$i]);
            $places = array_merge($places, $more_places); 
        }
    }
        
    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($places, JSON_PRETTY_PRINT));
    
?>
