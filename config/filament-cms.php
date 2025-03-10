<?php

return [
    /*
     * ---------------------------------------------------
     * Allow Features
     * ---------------------------------------------------
     */
    "features" => [
        "category" => true,
        "posts" => true,
        "comments" => true,
        "theme-manager" => false,
        "forms" => true,
        "form_requests" => true,
        "tickets" => false,
        "apis" => false,
    ],

    /*
     * ---------------------------------------------------
     * Youtube Integration For Posts Meta
     * ---------------------------------------------------
     */
    "youtube_key" => env('YOUTUBE_KEY', null),

    /*
     * ---------------------------------------------------
     * Supported Lanuages For Content
     * ---------------------------------------------------
     */
    "lang" => [
		"en" => "English",
		"es" => "Español"
    ],

    "themes" => [
        "scan" => true,
        "sections" => [
            "/vendor/tomatophp/filament-cms/src/Sections"
        ]
    ]
];
