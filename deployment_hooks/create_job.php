<?php
define('QUEUE', 'PrometheusMetrics');

$jobName = "Create Metrics for Prometheus";
$schedule     = '*/1 * * * *';

$q = new ZendJobQueue();

$id = $q->createPhpCliJob(
    zend_deployment_library_path('PrometheusMetrics') . '/index.php',
    [
        'pushgateway:9091'
    ],
    [
        'name' => $jobName,
        'schedule' => $schedule,
        'queue_name' => QUEUE
    ]
);

unlink(__FILE__);