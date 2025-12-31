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
        $this->city = config('erp.weather_city', 'Jakarta');
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
            
            $forecast[] = [
                'tanggal' => \Carbon\Carbon::parse($day['date'])->isoFormat('dddd, D MMMM Y'),
                'tanggal_singkat' => \Carbon\Carbon::parse($day['date'])->isoFormat('D MMM'),
                'suhu_avg' => round($tempC),
                'suhu_min' => round($day['day']['mintemp_c']),
                'suhu_max' => round($day['day']['maxtemp_c']),
                'klasifikasi' => $this->classifyTemperature($tempC),
                'kondisi' => $day['day']['condition']['text'] ?? 'Tidak ada data',
                'icon' => $this->getIconClass($day['day']['condition']['code'] ?? 1000),
            ];
        }

        return $forecast;
    }

    /**
     * Classify temperature as Panas/Normal/Dingin
     */
    protected function classifyTemperature($temp)
    {
        if ($temp >= config('erp.weather_temp_hot', 30)) {
            return 'Panas';
        } elseif ($temp < config('erp.weather_temp_cold', 20)) {
            return 'Dingin';
        }
        
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
                'klasifikasi' => 'Normal',
                'kondisi' => 'Data cuaca tidak tersedia',
                'icon' => '🌤️',
            ];
        }

        return $forecast;
    }

    /**
     * Get recommendations based on weather
     */
    public function getRecommendations()
    {
        $forecast = $this->getForecast();
        $recommendations = [];

        // Count hot/cold days in next 3 days
        $next3Days = array_slice($forecast, 0, 3);
        $hotDays = collect($next3Days)->where('klasifikasi', 'Panas')->count();
        $coldDays = collect($next3Days)->where('klasifikasi', 'Dingin')->count();

        if ($hotDays >= 2) {
            $recommendations[] = [
                'type' => 'warning',
                'message' => 'Cuaca panas {$hotDays} hari ke depan. Proses fermentasi bisa lebih cepat, perhatikan kualitas tempe.',
            ];
            $recommendations[] = [
                'type' => 'info',
                'message' => 'Permintaan mungkin menurun saat cuaca panas. Pertimbangkan mengurangi produksi.',
            ];
        }

        if ($coldDays >= 2) {
            $recommendations[] = [
                'type' => 'success',
                'message' => 'Cuaca dingin {$coldDays} hari ke depan. Fermentasi lebih stabil dan permintaan biasanya meningkat.',
            ];
        }

        // Check today's weather
        $today = $forecast[0] ?? null;
        if ($today && $today['klasifikasi'] === 'Panas') {
            $recommendations[] = [
                'type' => 'warning',
                'message' => 'Cuaca hari ini panas. Pastikan tempat fermentasi tidak terlalu panas.',
            ];
        }

        return $recommendations;
    }
}
