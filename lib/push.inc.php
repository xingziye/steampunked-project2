<?php
/**
 * @param string $key
 */
return function($key) {
    /*
     * PHP code to cause a push on a remote client.
     */
    $msg = json_encode(array('key'=>$key, 'cmd'=>'reload'));

    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

    $sock_data = socket_connect($socket, '127.0.0.1', 8078);
    if(!$sock_data) {
        echo "Failed to connect";
    } else {
        socket_write($socket, $msg, strlen($msg));
    }
    socket_close($socket);
};