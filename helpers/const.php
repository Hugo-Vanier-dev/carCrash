<?php

$is_localhost = $_SERVER['REMOTE_ADDR'];
if ($is_localhost == '127.0.0.1' || $is_localhost == '::1') {
    define('DB_HOST', '127.0.0.1');
    define('DB_DBNAME', 'carCrash');
    define('DB_USER', 'root');
    define('DB_PWD', '');
    define('DB_PREFIX', 'ujrgugr_');
} else {
    define('DB_HOST', '127.0.0.1');
    define('DB_DBNAME', 'vahu6104_carCrash');
    define('DB_USER', 'vahu6104_HugoVanier');
    define('DB_PWD', 'H99VdsA1201');
    define('DB_PREFIX', 'ujrgugr_');
}
