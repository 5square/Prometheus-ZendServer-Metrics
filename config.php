<?php

return (function () {
    $webApi = include 'webapi.php';

    $config = [
        "--zskey={$webApi['name']}",
        "--zssecret={$webApi['hash']}",
        "--output-format=json"
    ];

    return $config;
}) ();