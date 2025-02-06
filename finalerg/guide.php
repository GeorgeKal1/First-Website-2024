<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiKey = '8b086032454d2f9166620c8bf1ad1bef';
    $city = trim($_POST['city']);

    if (empty($city)) {
        echo "<p>Please enter a city name.</p>";
    } else {
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=" . $apiKey . "&units=metric";

        $response = file_get_contents($apiUrl);

        if ($response === FALSE) {
            echo "<p>City not found</p>";
        } else {
            $results = json_decode($response, true);
            
            if (isset($results['cod']) && $results['cod'] == 200) {
                $weather = "<h2>Weather in " . htmlspecialchars($results['name']) . "</h2>";
                $weather .= "<p>Temperature: " . htmlspecialchars($results['main']['temp']) . "°C</p>";
                $weather .= "<p>Condition: " . htmlspecialchars($results['weather'][0]['description']) . "</p>";
                echo $weather;
            } else {
                echo "<p>City not found</p>";
            }
        }
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Guide</title>

    <link rel="stylesheet" href="style1.css">
    <link rel="icon" href="images/logo.jpeg" type="jpeg"> 
</head>
<body>
    <div style="border-bottom: 2px solid grey;"></div>
    <div style="display: flex; justify-content: space-between; text-align: center; width: 100%;">
        <div style="flex: 1;"><a href="arxiki.html">Info</a></div>
        <div style="flex: 1;"><a href="products.html">Products</a></div>
        <div style="flex: 1;"><a href="signUp.html" target="_blank">SignUp</a></div>
        <div style="flex: 1;"><a href="discount.html">Discount🤑</a></div>
        <div style="flex: 1;"><a href="ChrComp.html">Christmas Competition</a></div>
        <div style="flex: 1;"><a href="orders.html" target="_blank">Order</a></div>
        <div style="flex: 1;"><a href="guide.html">Guide</a></div>
    </div>
    <div style="border-top: 2px solid grey;"></div>

    <h1>Weather app</h1>
    <h2>Μάθε για τις συνθήκες καιρού στην πόλη σου</h2>

    <img src="images/logo.jpeg" style="width: 8vw; height: auto; float: right; ">
    <form class="weatherform" method="POST">
        <div style="display: flex; width: 80%;">
            <div style="flex: 1;">
                <label for="city" class="label1">Δώσε την πόλη σου (αγγλικά)</label><br><br>
                <input type="text" placeholder="e.g. Berlin" name="city" id="city">
                <input type="submit" value="Submit">
            </div>
            <div style="flex:1;">
                <div id="weather">
                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        echo $weather;
                    } ?>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
