<?php
return [
    'pdftotext' => [
        'lib_path' => env('PDFTOTEXT_LIB_PATH', '/usr/local/bin/pdftotext'),
    ],
    'scma_api' => [
        'url' => env('SCMA_API_URL', 'http://scma-api.mgdsw.info:15080/api/v1/'),
    ],
    'ftrss' => [
        'url' => env('FTRSS_API_URL', 'http://ftrss.newshawx.net/api/v1/alerts.json?rows=50'),
    ],
    'rssapp' => [
        'url' => env('RSS_APP', 'http://sfdev-rss.sfdapps.ae/'),
    ],
    'warningrisk' => [
        'url' => env('WARNING_RISK', 'http://riskdev1.mgdsw.info'),
    ],
    'sdssapp' => [
        'url' => env('SDSS_APP', 'https://dssstg.mgdsw.info'),
    ]
];
?>