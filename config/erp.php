<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Business Settings
    |--------------------------------------------------------------------------
    */
    'business_name' => env('BUSINESS_NAME', 'UMKM Tempe 3 Puteri'),
    
    /*
    |--------------------------------------------------------------------------
    | Inventory Settings
    |--------------------------------------------------------------------------
    */
    'stock_warning_threshold' => env('STOCK_WARNING_THRESHOLD', 10),
    'high_stock_threshold' => env('HIGH_STOCK_THRESHOLD', 100),
    'expiry_warning_days' => env('EXPIRY_WARNING_DAYS', 2),
    
    /*
    |--------------------------------------------------------------------------
    | Production Settings
    |--------------------------------------------------------------------------
    */
    'batch_cycle_days' => 4, // Fixed 4-day cycle for tempe production
    
    /*
    |--------------------------------------------------------------------------
    | Weather Settings
    |--------------------------------------------------------------------------
    */
    'weather_api_key' => env('WEATHER_API_KEY'),
    'weather_city' => env('WEATHER_CITY', 'Palembang'),
    'weather_cache_hours' => 3,
    
    // Temperature classification (Celsius)
    'weather_temp_hot' => 30,      // > 30°C = Panas
    'weather_temp_cold' => 20,     // < 20°C = Dingin
    // Between 20-30°C = Normal
    
    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    */
    'payment_methods' => [
        'transfer_bank' => 'Transfer Bank',
        'cod' => 'Bayar di Tempat (COD)',
    ],
    
    'shipping_methods' => [
        'ambil_sendiri' => 'Ambil di Tempat',
        'kurir' => 'Kurir/Ekspedisi',
    ],
    
    // Simulated payment gateway
    'payment_gateway' => [
        'enabled' => true,
        'name' => 'SimulasiPay',
        'banks' => [
            'BCA' => 'Bank Central Asia',
            'BRI' => 'Bank Rakyat Indonesia',
            'Mandiri' => 'Bank Mandiri',
            'BNI' => 'Bank Negara Indonesia',
        ],
    ],
];
