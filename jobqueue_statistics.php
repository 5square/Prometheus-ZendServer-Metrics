<?php

return function($sdk, $config) {
    $args = [
        'jobqueueStatistics'
    ];

    $data = $sdk($args, $config);
var_dump($data);
    $jobqueueStatistics = $data['responseData']['jobqueueStatistics'];

    $args = [
        'jobqueueJobsList', '--filter=status[0]=Running'
    ];


    $total = [];
    $total['Running'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Running'], $config)['responseData']['total'];
    $total['Waiting'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Waiting'], $config)['responseData']['total'];
    $total['Completed'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Completed'], $config)['responseData']['total'];
    $total['Successful'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Successful'], $config)['responseData']['total'];
    $total['Logical failure'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Logical failure'], $config)['responseData']['total'];
    $total['Backend not responding'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Backend not responding'], $config)['responseData']['total'];
    $total['Bad Request'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Bad Request'], $config)['responseData']['total'];
    $total['HTTP error'] = $sdk(['jobqueueJobsList', '--filter=status[0]=HTTP error'], $config)['responseData']['total'];
    $total['Failed to start'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Failed to start'], $config)['responseData']['total'];
    $total['Failed predecessor'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Failed predecessor'], $config)['responseData']['total'];
    $total['Backend timeout'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Backend timeout'], $config)['responseData']['total'];
    $total['Removed'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Removed'], $config)['responseData']['total'];
    $total['Scheduled'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Scheduled'], $config)['responseData']['total'];
    $total['Suspended'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Suspended'], $config)['responseData']['total'];
    $total['Waiting for retry'] = $sdk(['jobqueueJobsList', '--filter=status[0]=Waiting for retry'], $config)['responseData']['total'];
    
    $metrics = '';
    foreach ($total as $status => $total) {
        $status = str_replace(' ', '', ucwords($status));
        $metrics .= "zendserver_jobqueue_jobs{status=\"$status\"} $total\n";
    }

    var_dump($metrics);

    return <<<METRICS

# TYPE zendserver_jobqueue_notprocessed gauge
zendserver_jobqueue_notprocessed{status="waiting"} {$jobqueueStatistics['waiting']}
zendserver_jobqueue_notprocessed{status="scheduled"} {$jobqueueStatistics['scheduled']}
zendserver_jobqueue_notprocessed{status="waitingPredecessor"} {$jobqueueStatistics['waitingPredecessor']}
# TYPE zendserver_jobqueue_inprogress gauge
zendserver_jobqueue_inprogress {$jobqueueStatistics['inProgress']}
# TYPE zendserver_jobqueue_processed counter
zendserver_jobqueue_processed{status="completed"} {$jobqueueStatistics['completed']}
zendserver_jobqueue_processed{status="failed"} {$jobqueueStatistics['failed']}
zendserver_jobqueue_processed{status="logicallyFailed"} {$jobqueueStatistics['logicallyFailed']}
# TYPE zendserver_jobqueue_avgwait gauge
zendserver_jobqueue_avgwait {$jobqueueStatistics['avgWait']}
# TYPE zendserver_jobqueue_avgrun gauge
zendserver_jobqueue_avgrun {$jobqueueStatistics['avgRun']}
# TYPE zendserver_jobqueue_added gauge
zendserver_jobqueue_added {$jobqueueStatistics['added']}
# TYPE zendserver_jobqueue_served counter
zendserver_jobqueue_served {$jobqueueStatistics['served']}

# TYPE zendserver_jobqueue_jobs counter
$metrics

METRICS;
};