<?php  

class Tree{
	
public $data=null;
public function __construct(){
	$select = M('category')->where('cid=2')->find();
	$this->data = $select;
}











}

















?>