<?php
//
//class Stack{
//    protected $shortestPath;
//    protected $size;
//
//    public function __construct($size = 40) {
//        $this->shortestPath = array();
//        $this->size = $size;
//    }
//
//    public function push($item){
//
//        if (count($this->shortestPath) < $this->size) {
//            array_unshift($this->shortestPath, $item);
//        } else {
//            echo "Array is full";
//        }
//
//    }
//
//    public function pop(){
//        if($this->isEmpty()){
//            echo "Array is Empty";
//        }
//        else{
//            return array_shift($this->shortestPath);
//        }
//    }
//    public function top() {
//        return current($this->shortestPath);
//    }
//
//    public function isEmpty() {
//
//        return empty($this->stack);
//    }
//
//};
//
//$stack = new Stack();
////$stack->push(10);
////$stack->push(20);
////$stack->push(30);
////$stack->push(40);
////echo $stack->top();
//
//$array =array (
//    array('E','E','E','E','E','O','F'),
//    array('E','O','E','E','E','O','E'),
//    array('E','E','E','O','E','E','E'),
//    array('E','E','O','E','O','E','E'),
//    array('S','E','E','E','E','E','E')
//);
//
//$counter =0;
//$len = count($array);
//for ($i=0;$i<=4;$i++) {
//    for ($j=0;$j<=6;$j++) {
//        $stack->push($array[$i][$j]);
//        $counter = $counter+1.01;
//        //echo "\nThe array is ".$array[$i][$j];
//        if($array[$i][$j] == 'S'){
//
//            break;
//        }
//    }
//}
//echo " Total time is -> " .$counter."\n";
//echo " [The top element is ->".$stack->top()." ] \n";
