<?php

function autoLoader($className) {
    $directories = array(
       './Controller/',       
       './Model/',       
       './Service/',        
       './Config/',        
       './Helper/',
       './Classes/',       
       './lib/',
    );

    $fileNameFormats = array(
        '%s.php',
        '%s.class.php',
        '%s.class',
        'class.%s.php',
        '%s.inc.php'
    );

    // this is to take care of the PEAR style of naming classes
    $path = str_ireplace('_', '/', $className);
    if (@include_once $path . '.php') {
        return;
    }
    foreach ($directories as $directory) {
        foreach ($fileNameFormats as $fileNameFormat) {
            $path = $directory . sprintf($fileNameFormat, $className);
            if (file_exists($path)) {
                include_once $path;
                return;
            }
        }
    }
}
spl_autoload_register('autoLoader');

?>