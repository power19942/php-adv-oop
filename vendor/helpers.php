<?php

if (!function_exists('pre')){
    /*
     * Visualize The Given Variable in browser
     *
     * @param mixed $var
     * @return Void
     * */

    function pre($var){
        echo '<pre>';
            print_r($var);
        echo '</pre>';
    }
}

if (!function_exists('array_get')){
    function array_get($array,$key,$default=null){
        return isset($array[$key]) ? $array[$key] : $default ;
    }
}