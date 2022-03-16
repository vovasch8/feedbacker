<?php

function loadFiles($class_name){
    $array_path = array(
        '/model/',
        '/controller/',
        '/components/'
    );

        foreach ($array_path as $file){
            $path = ROOT . $file . $class_name . '.php';

            if(is_file($path)){
                include_once $path;
            }
        }

}

spl_autoload_register('loadFiles');