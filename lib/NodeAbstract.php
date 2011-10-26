<?php

abstract class NodeAbstract{
    protected $parent;
    protected $expand_value;
    
    public function getParent(){
        return $this->parent;
    }
    
    public function setParent($val){
        $this->parent = $val;
    }
    
    public function getExpandValue(){
        return $this->expand_value;
    }
}

?>
