<?php

class myValue {
    public $value = 0;

    function incVal() {
        $this->value++;
    }

    function decVal() {
        $this->value--;
    }
}


$newValue = new myValue() ;

$newValue->incVal();
$newValue->incVal();
$newValue->decVal();

echo $newValue->value ;