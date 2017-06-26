<?php

namespace System;

class File
{
    const DS = DIRECTORY_SEPARATOR ;

    private $root;

    public function __construct($root)
    {
        $this->root = $root;
    }

    public function exists($file){
        return file_exists($file);
    }


    public function require($file){
        require($file);
    }

    public function toVendor($path){
        return $this->to('vendor/'.$path);
    }

    public function to($path){
        return $this->root.static::DS . str_replace(['/','\\'],static::DS,$path);
    }
}
