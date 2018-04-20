<?php

return (function (){
    $etcDir = '/usr/local/zend/etc';

    $ini = parse_ini_file($etcDir . '/zend_database.ini');

    $apiName = 'admin';

    if ($ini['zend.database.type'] == 'SQLITE') {

        $dbPath = '/usr/local/zend/var/db/gui.db';

        $db = new SQLite3($dbPath);

        $result = $db->query("SELECT HASH FROM GUI_WEBAPI_KEYS WHERE NAME='admin';");
        return [
            'name' => $apiName,
            'hash' => $result->fetchArray(SQLITE3_ASSOC)['HASH']
        ];
    }
})();