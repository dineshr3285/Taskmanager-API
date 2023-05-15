<?php

return [

    'TEMPORARY_URL_EXPIRY_TIME' => 30, //in minutes

    'Signatory_IMAGE_PATH' => 'signatory/',
    'AUTHORIZE_SIGNATURE_IMAGE_PATH' => 'authorize_signatures/',
    'STAFF_SIGNATURE_IMAGE_PATH' => 'staff_signatures/',
    'STAFF_PHOTO_IMAGE_PATH' => 'staff_photo/',

    'TA_APP_DOCUMENTS' => 'ta_app_documents/',
    'TA_APP_COURIER_INFORMATIONS' => 'ta_app_courier_information/',
    'BADGE_APP_DOCUMENT_PATH' => 'badge_app_documents/',
    'BADGE_APP_PHOTOGRAPH_PATH' => 'badge_app_photograph/',
    'BADGE_APP_SIGNATURE_PATH' => 'badge_app_signature/',
    'IMPOUND_DOCUMENT_PATH' => 'impound_documents/',
    'PLANNING_DOCUMENT_PATH' => 'plannings/',
    'AUCTION_DOCUMENT_PATH' => 'auction_documents/',
    'LICENSE_TEMPLATE_DOCUMENT_PATH' => 'license_template_documents/',

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
