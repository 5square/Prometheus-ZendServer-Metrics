<?php

$sdk = include 'sdk.php';
$config = include 'config.php';
$curl = include 'curl.php';
$pushgateway = $argv[1];

#$statisticsCpuAvg = include 'statistics_cpu_avg.php';
#$data = $statisticsCpuAvg($sdk, $config);

#$statisticsMemoryAvg = include 'statistics_memory_avg.php';
#$data = $statisticsMemoryAvg($sdk, $config);

#$statisticsOplusHits = include 'statistics_oplushits.php';
#$data = $statisticsOplusHits($sdk, $config);

#$statistics_max_request_processing_time = include 'statistics_max_request_processing_time.php';
#$data = $statistics_max_request_processing_time($sdk, $config);

$curl($pushgateway, 'jobqueue_statistics', (include 'jobqueue_statistics.php')($sdk, $config));
