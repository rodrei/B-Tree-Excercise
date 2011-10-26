<?php

class LeaveNode extends NodeAbstract
{
    private $values = array();
    
    public function __construct($value=NULL, $parent=NULL){
        if(is_array($value)){
            $this->values = $value;
            sort($this->values);
        }
        elseif($value !== NULL){
            $this->values[] = $value;
        }
        $this->parent = $parent;
    }
    
    public function insert($value){
        if(sizeof($this->values) > 3)
            throw new Exception('LeaveNode cant have that many values, it needs to be expanded');
        $this->values[] = $value;
        sort($this->values);
        sizeof($this->values) >= 3 ? false : true;
    }
    
    public function expand(){
        if(sizeof($this->values) != 3)
            throw new Exception('Only LeaveNodes with 3 elements can be expanded');
        
        $nodes = array(new LeaveNode($this->values[0], $this->parent),
                       new LeaveNode(array($this->values[1], $this->values[2]), $this->parent));
        $this->expand_value = $this->values[1];
        
        return $nodes;
    }
    
    public function needToExpand(){
        return (sizeof($this->values) >= 3);
    }
    
    
    public function hasValue($val){
        foreach($this->values as $value){
            if($val == $value) 
                return true;
        }
        return false;
    }
    
    public function debug($depth=0){
        $tab = '';
        for($i=0; $i<= $depth; $i++)
            $tab .= "\t";
        
        echo $tab . "LEAVE NODE: \n";
        echo $tab . "values: " . implode(',', $this->values) . "\n";
    }
}
?>
