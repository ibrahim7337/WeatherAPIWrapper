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
        $this->apiKey = 'DRXYHMJ3E8LVK8UZ7CTCRTRTL';
        $this->baseUrl = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline";
        $this->unit = "us";
        $this->contentType = "json";
    }

    public function fetchWeather()
    {
        $url = "{$this->baseUrl}/{$this->city}?unitGroup={$this->unit}&key={$this->apiKey}&contentType={$this->contentType}";
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}