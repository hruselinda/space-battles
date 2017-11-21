<?php

function p($array){
    echo '<pre>'. print_r($array, true).'</pre>';
}

define('DS', DIRECTORY_SEPARATOR);

require __DIR__.DS.'vendor'.DS.'autoload.php';

//
//spl_autoload_register(function ($className){
//    $path = __DIR__.DS.'lib'.DS.str_replace('\\', DS, $className).'.php';
//
//    if(file_exists($path)){
//        require $path;
//    }
//});



$configuration = array(
    'db_dsn' => 'mysql:host=localhost; dbname=dasolut2_mydb',
    'db_user' => 'dasolut2_chushki',
    'db_pass' => 'Hrustini6te'
);



