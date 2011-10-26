<?php

class Node extends NodeAbstract
{
    private $values = array();
    private $childs = array();
    
    public function __construct($value, $childs, $parent=NULL){
        for($i=0; $i<=1; $i++)
            $childs[$i]->setParent($this);
        $this->values[] = $value;
        $this->childs = $childs;
        $this->parent = $parent;
    }
    
    public function insert($value, $new_child_nodes){
        if(sizeof($this->values) == 3){
            $this->debug();
            throw new Exception('Trying to insert 4 values in a NODE');
        }
        //child to replace
        $child_index = $this->getChildNodeIndexFor($value);
        $child_node = $this->childs[$child_index];
        
        $this->values[] = $value;
        sort($this->values);
        
        $childs = array_slice($this->childs, 0, $child_index);
        $childs = array_merge($childs, $new_child_nodes);
        $childs = array_merge($childs, array_slice($this->childs, $child_index + 1));
        $this->childs = $childs;
    }
    
    public function getChildNodeFor($value){
        $i = $this->getChildNodeIndexFor($value);
        return $this->childs[$i];
    }
    
    public function getChildNodeIndexFor($value){
        foreach($this->values as $i => $val){
            if($value < $val)
                return $i;
        }
        
        return sizeof($this->childs) - 1;
    }
    
    public function expand(){
        if(sizeof($this->childs) != 4){
            //$this->debug();
            throw new Exception('Only Nodes with 4 elements can be expanded');
        }
        $this->expand_value = $this->values[1];
        
        $nodes = array();
        $nodes[] = new Node($this->values[0], array_slice($this->childs, 0, 2), $this->parent);
        $nodes[] = new Node($this->values[2], array_slice($this->childs,2), $this->parent);
        return $nodes;
        
    }
    
    public function needToExpand(){
        return (sizeof($this->childs) >= 4);
    }
    
    public function debug($depth=0){
        $tab = '';
        for($i=0; $i<= $depth; $i++)
            $tab .= "\t";
        echo $tab . "MAIN NODE: \n";
        echo $tab . "values: " . implode(',', $this->values) . "\n";
        foreach($this->childs as $i => $child){
            echo $tab . "CHILD $i: \n";
            if($child) $child->debug($depth+1);
        }
    }
    
    
    
    
}
?>
