<?php

class LinkedNode
{
    public $data;
    public $next;
    
    public function __construct($data = null)
    {
        $this->data = $data;
        $this->next = null;//后继指针
    }
}

// 头结点
// 尾节点
// head -> node1 -> node2 -> null
class SingleLinkedList
{
    public $head;
    
    private $length;
    
    public function __construct()
    {
        $this->head = new LinkedNode();
        $this->length = 0;
    }
    
    public function getLength()
    {
        return $this->length;
    }
    
    public function insert($data)
    {
        $this->insertDataAfter($this->head, $data);
        return $this->getLength();
    }
    
    public function insertDataAfter($originNode, $data)
    {
        return $this->insertNodeAfter($originNode, new LinkedNode($data));
    }
    
    public function insertNodeAfter($originNode, $newNode)
    {
        $newNode->next = $originNode->next;
        $originNode->next = $newNode;
        
        $this->length++;
        return $newNode;
    }
    
    public function reverse()
    {
        if ($this->getLength() <= 0) return false;
        
        $pre = null;
        $remain = null;
        $node = $this->head->next;
        while($node != null) {
            $remain = $node->next;
            $node->next = $pre;
            $pre = $node;
            $node = $remain;
        }
        $this->head->next = $pre;
        
        return true;
    }
    
    //head->c->b->a->null 
    public function printData()
    {
        if (null == $this->head->next) return false;
        
        $curNode = $this->head;
        
        $length = $this->getLength();
        while($curNode->next != null && $length--){
            echo $curNode->next->data . ' -> ';
            
            $curNode = $curNode->next;
        }
        echo 'NULL' . PHP_EOL;
        
        return true;
    }
}

function isPalindrome(SingleLinkedList $list)
{
    if ($list->getLength() <= 1) return false;
    
    $slow = $list->head->next;
    $fast = $list->head->next;
    $pre = $remain = null;
    
    while($fast != null && $fast->next != null){
        //快指针走2步
        $fast = $fast->next->next;
        
        //慢指针走1步
        $remain = $slow->next;
        $slow->next = $pre;
        $pre = $slow;
        $slow = $remain;
    }
    
    //奇数
    if ($fast != null) {
        $slow = $slow->next;
    }
    
    while($slow != null) {
        if ($slow->data !== $pre->data) {
            return false;
        }
        $slow = $slow->next;
        $pre = $pre->next;
    }
    
    return true;
}

$singleLinedList = new SingleLinkedList();
echo $singleLinedList->insert('a');
echo $singleLinedList->insert('b');
echo $singleLinedList->insert('c');
echo $singleLinedList->insert('d');
echo $singleLinedList->insert('e');
echo '<br>';
$singleLinedList->printData();
$singleLinedList->reverse();
$singleLinedList->printData();
var_dump(isPalindrome($singleLinedList));