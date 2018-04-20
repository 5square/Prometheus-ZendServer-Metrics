<?php

return function($gateway, $job, $data) {
    $curl = curl_init("http://$gateway/metrics/job/$job");

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    return curl_exec($curl);
};