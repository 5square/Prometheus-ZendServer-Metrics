<?php
define('QUEUE', 'PrometheusStats');

$jobName = "Create Metrics for Prometheus";
$schedule     = '*/1 * * * *';

$q = new ZendJobQueue();

$id = $q->createPhpCliJob(
    zend_deployment_library_path('PrometheusStats') . '/index.php',
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