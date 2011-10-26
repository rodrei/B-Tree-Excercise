<?php
//TODO Use autoload
include('NodeAbstract.php');
include('LeaveNode.php');
include('Node.php');


class Btree
{
    private $nodes = array();
    private $root_node;
    private $order;
    
    public function __construct(){
        $this->root_node = new LeaveNode();
    }
    
    public function hasValue($value){
        $node = $this->getLeaveNodeForValue($value);
        return $node->hasValue($value);
    }
    
    public function getLeaveNodeForValue($value){
        $node = $this->root_node;
        //TODO while(true)
        while($node !== NULL){
            if($node instanceof LeaveNode)
                break;
            else{
                $node = $node->getChildNodeFor($value);
            }
        }
        
        return $node;
    }
    
    public function insert($value){
        $c = 0;
        $old_parent = '';
        $node = $this->getLeaveNodeForValue($value);
        $node->insert($value);
        
        
        while($node->needToExpand()){
            $new_nodes = $node->expand();
            $expand_value = $node->getExpandValue();
            
            if($node->getParent() !== NULL){
                $node = $node->getParent();
                $node->insert($expand_value, $new_nodes);
            }
            else{
                $this->root_node = new Node($expand_value, $new_nodes);
                break;
            }
        }
    }
    
    public function getRootNode(){
        return $this->root_node;
    }
    
    private function updateRootNode(){
        $node = $this->root_node;
        while($node !== NULL)
            $node = $node->getParent();
        
        $this->root_node = $node;
    }
    
    
}


?>
