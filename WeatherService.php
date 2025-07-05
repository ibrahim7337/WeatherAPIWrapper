<?php

// Handles API requests (fetch weather data)

class WeatherService
{
    private $city;
    private $apiKey;
    private $baseUrl;
    private $unit;
    private $contentType;

    public function __construct($city)
    {
        $this->city = $city;
        $this->apiKey = getenv('WEATHER_API_KEY');
        $this->baseUrl = getenv('WEATHER_API_BASE');
        $this->unit = getenv('WEATHER_UNIT');
        $this->contentType = getenv('WEATHER_CONTENT_TYPE');
    }

    public function fetchWeather()
    {
        $url = "{$this->baseUrl}/{$this->city}?unitGroup={$this->unit}&key={$this->apiKey}&contentType={$this->contentType}";
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}