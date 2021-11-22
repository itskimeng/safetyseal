<?php
    require 'vendor/autoload.php';

    $aws = new Aws\S3\S3Client([
        'region'  => 'us-east-2',
        'version' => 'latest',
        'credentials' => [
            'key'    => "AKIA2MWVZU5E3K6TZITV",
            'secret' => "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",
        ]
    ]);
