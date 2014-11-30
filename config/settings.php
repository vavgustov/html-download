<?php

return [

    // root directory to download files
    'directory' => [
        'folder' => __DIR__ . '/../files',
        'mode' => 0770,
    ],

    // list of files to download
    'download' => [
        [
            'folder' => 'trefis',
            'url' => 'http://www.trefis.com/companies',
        ],
    ],

];