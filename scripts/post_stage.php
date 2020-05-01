<?php
define('QUEUE', 'PrometheusStats');

$jobFileName = sys_get_temp_dir() . '/' . uniqid() . '.php';
$res = copy(__DIR__ . '/create_job.php', $jobFileName);

$jobName = "Job to initialize recurring Job for Metrics for Prometheus";

$q = new ZendJobQueue();

$q->createQueue(QUEUE);

$id = $q->createPhpCliJob(
    $jobFileName,
    null,
    [
        'name' => $jobName,
        'queue_name' => QUEUE,
        'schedule_time' => time() + 15
    ]
);