<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


try {
    include_once(__DIR__ . '/database.php');
    include_once(__DIR__.'/utils/provider.php');
    include_once(__DIR__.'/ilalin-app/provider.php');
} catch (Exception $e) {
    echo $e;
}
?>