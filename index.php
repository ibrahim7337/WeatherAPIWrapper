<?php
require_once __DIR__ . "/helpers.php";
require_once __DIR__ . "/RedisCache.php";
require_once __DIR__ . "/WeatherService.php";

loadEnv(__DIR__ . "/.env");

$city = $_GET['city'] ?? "cairo";
$cacheKey = "weather:$city";

$cache = new RedisCache();

if ($cache->exists($cacheKey)) {
    $data = json_decode($cache->get($cacheKey), true);
    $source = "⏱ From Cache";
} else {
    $weather = new WeatherService($city);
    $data = $weather->fetchWeather();
    $cache->set($cacheKey, $data);
    $source = "🌐 From API";
}

$today = $data['days'][0];
$celsius = round(($today['temp'] - 32) * 5 / 9, 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Weather App</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f2f2f2;
        padding: 2rem;
        text-align: center;
    }

    .weather-box {
        background: #fff;
        padding: 2rem;
        border-radius: 10px;
        display: inline-block;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    input[type="text"] {
        padding: 0.5rem;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button {
        padding: 0.5rem 1rem;
        border: none;
        background: #007bff;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background: #0056b3;
    }

    .source {
        color: gray;
        font-size: 0.9rem;
    }
    </style>
</head>

<body>

    <h1>🌤️ Weather App</h1>
    <form method="get">
        <input type="text" name="city" placeholder="Enter city name" value="<?= htmlspecialchars($city) ?>">
        <button type="submit">Get Weather</button>
    </form>

    <div class="weather-box">
        <h2><?= $data['resolvedAddress'] ?></h2>
        <p><strong>Date:</strong> <?= $today['datetime'] ?></p>
        <p><strong>Temperature:</strong> <?= $celsius ?> °C</p>
        <p><strong>Humidity:</strong> <?= $today['humidity'] ?>%</p>
        <p><strong>Conditions:</strong> <?= $today['conditions'] ?></p>
        <p><strong>Description:</strong> <?= $today['description'] ?></p>
        <p class="source"><?= $source ?></p>
    </div>

</body>

</html>