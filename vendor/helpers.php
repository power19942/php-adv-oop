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