<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;
    protected $city;
    protected $cacheHours;

    public function __construct()
    {
        $this->apiKey = config('erp.weather_api_key');
        $this->city = config('erp.weather_city', 'Palembang');
        $this->cacheHours = config('erp.weather_cache_hours', 3);
    }

    /**
     * Get 7-day weather forecast with Indonesian classification
     */
    public function getForecast()
    {
        return Cache::remember('weather_forecast', now()->addHours($this->cacheHours), function () {
            try {
                // Call WeatherAPI.com
                $response = Http::get('http://api.weatherapi.com/v1/forecast.json', [
                    'key' => $this->apiKey,
                    'q' => $this->city,
                    'days' => 7,
                    'lang' => 'id',
                ]);

                if (!$response->successful()) {
                    return $this->fallbackForecast();
                }

                $data = $response->json();
                
                return $this->formatForecast($data);
            } catch (\Exception $e) {
                \Log::error('Weather API Error: ' . $e->getMessage());
                return $this->fallbackForecast();
            }
        });
    }

    /**
     * Format forecast data to simple Indonesian format
     */
    protected function formatForecast($data)
    {
        $forecast = [];
        
        if (!isset($data['forecast']['forecastday'])) {
            return $this->fallbackForecast();
        }

        foreach ($data['forecast']['forecastday'] as $day) {
            $tempC = $day['day']['avgtemp_c'];
            $humidity = $day['day']['avghumidity'] ?? 50;
            $precip = $day['day']['totalprecip_mm'] ?? 0;
            $conditionCode = $day['day']['condition']['code'] ?? 1000;
            
            $forecast[] = [
                'tanggal' => \Carbon\Carbon::parse($day['date'])->isoFormat('dddd, D MMMM Y'),
                'tanggal_singkat' => \Carbon\Carbon::parse($day['date'])->isoFormat('D MMM'),
                'suhu_avg' => round($tempC),
                'suhu_min' => round($day['day']['mintemp_c']),
                'suhu_max' => round($day['day']['maxtemp_c']),
                'kelembaban' => $humidity,
                'presipitasi' => $precip,
                'klasifikasi' => $this->classifyWeather($tempC, $humidity, $precip, $conditionCode),
                'kondisi' => $day['day']['condition']['text'] ?? 'Tidak ada data',
                'icon' => $this->getIconClass($conditionCode),
            ];
        }

        return $forecast;
    }

    /**
     * Classify weather based on temperature, humidity and rain
     */
    protected function classifyWeather($temp, $humidity, $precip, $conditionCode)
    {
        // 1. Dingin / Lembab: temp < 27 OR humidity high (> 80) OR rain forecast
        // Rain condition codes: 1063, 1150-1201 (Light to moderate rain)
        $isRainy = ($precip > 0.5) || ($conditionCode >= 1063 && $conditionCode <= 1276);

        if ($temp < 27 || $humidity > 80 || $isRainy) {
            return 'Dingin / Lembab';
        }

        // 2. Panas: temp > 32
        if ($temp > 32) {
            return 'Panas';
        }

        // 3. Normal: 27 - 32 AND no heavy rain
        return 'Normal';
    }

    /**
     * Get weather icon class based on condition code
     */
    protected function getIconClass($code)
    {
        // WeatherAPI.com condition codes
        $iconMap = [
            1000 => '☀️', // Sunny/Clear
            1003 => '⛅', // Partly cloudy
            1006 => '☁️', // Cloudy
            1009 => '☁️', // Overcast
            1063 => '🌦️', // Patchy rain
            1150 => '🌧️', // Light drizzle
            1183 => '🌧️', // Light rain
            1186 => '🌧️', // Moderate rain
            1189 => '🌧️', // Heavy rain
            1192 => '⛈️', // Thunder
        ];

        return $iconMap[$code] ?? '🌤️';
    }

    /**
     * Fallback forecast for when API fails
     */
    protected function fallbackForecast()
    {
        $forecast = [];
        
        for ($i = 0; $i < 7; $i++) {
            $date = now()->addDays($i);
            
            $forecast[] = [
                'tanggal' => $date->isoFormat('dddd, D MMMM Y'),
                'tanggal_singkat' => $date->isoFormat('D MMM'),
                'suhu_avg' => 28,
                'suhu_min' => 24,
                'suhu_max' => 32,
                'kelembaban' => 60,
                'presipitasi' => 0,
                'klasifikasi' => 'Normal',
                'kondisi' => 'Data cuaca tidak tersedia',
                'icon' => '🌤️',
            ];
        }

        return $forecast;
    }
}
