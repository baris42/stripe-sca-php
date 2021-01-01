<?php
//oturumla başlatıyoruz. hata raporlamasını başlatıyoruz.
ini_set('display_errors', E_ALL);
ini_set('display_startup_errors', E_ALL);
error_reporting(E_ALL);
ob_start();
session_start();

//tarih verisini istemiyoruz .
date_default_timezone_set('Europe/Istanbul');

//stripe credentials
define('PKKEY','*****');
define('SKKEY','*****');


//database credentials
define('DBHOST','***');
define('DBUSER','****');
define('DBPASS','****');
define('DBNAME','****');
define('PORT','*****');

//db2 bilgiler
define('DBHOST2','*******');
define('DBUSER2','***');
define('DBPASS2','****');
define('DBNAME2','****');
define('PORT2','****');


try {

    //create PDO connection
    $db = new PDO("mysql:host=".DBHOST.";port=".PORT.";charset=utf8;dbname=".DBNAME, DBUSER, DBPASS);
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    //create PDO connection
    $db2 = new PDO("mysql:host=".DBHOST2.";port=".PORT2.";charset=utf8;dbname=".DBNAME2, DBUSER2, DBPASS2);
    //$db_spornet->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
    $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
    $db2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch(PDOException $e) {
    //show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';

}
///stripe library
require_once 'vendor/autoload.php';
require_once 'fonksiyon.php';
?>