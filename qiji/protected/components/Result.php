<?php

class Result
{
    public $succ;
    public $msg;
    public $data;

    function __construct($succ=false,$msg='',$data=null){
        $this->succ = $succ;
        $this->msg = $msg;
        $this->data = $data;
    }
}