<?php

class test {
    function __construct()
    {
        echo $this->file;
        $this->file = 20 ;
        $this->run();
    }

    function __get($name)
    {
        return $name ;
    }
    public function name(){
        return 'name function';
    }

    function __set($name, $value)
    {
        echo "set working $name - $value".'<br>';
    }

    function run(){
        echo [$this,'name'];
    }
}

new test();