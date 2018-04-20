<?php
define('PHAR', zend_deployment_library_path('ZendServerSDK') . '/zs-client.phar');

return function($args, $config) {

    $_SERVER['argv'] = [$_SERVER['argv'][0]];
    $_SERVER['argc'] = 1;
    
    if (!isset($_SERVER['HOME'])) $_SERVER['HOME'] = '';
    if (!isset($_SERVER['HOMEDRIVE'])) $_SERVER['HOMEDRIVE'] = '';
    if (!isset($_SERVER['HOMEPATH'])) $_SERVER['HOMEPATH'] = '';

    $args = array_merge($args, $config);

    array_walk($args, function($val) {
        $_SERVER['argv'][] = $val;
        $_SERVER['argc']++;
    });

    ob_start();
    include "phar://" . PHAR . "/index.php";
    $data = ob_get_contents();
    ob_end_clean();
    
    return json_decode($data, true);
};