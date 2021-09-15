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
    
    public $length;
    
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
    
    //链表中环的检测
    public function hasCircle()
    {
        $slow = $this->head->next;
        $fast = $this->head->next;
        
        while($fast && $fast->next) {
            $slow = $slow->next;
            $fast = $fast->next->next;
            if ($slow === $fast) {
                return true;
            }
        }
        return false;
    }
    
    //删除链表倒数第 n 个结点
    public function removeNthFromEnd($n)
    {
        $fast = $this->head;
        $slow = $this->head;
        
        while($n--)
        {
            $fast = $fast->next;
        }
        
        while($fast->next)
        {
            $fast = $fast->next;
            $slow = $slow->next;
        }
        
        $slow->next = $slow->next->next;
    }
    
    //head->1->2->3->4->5->NULL
    //1. head 哨兵节点 不用考虑第一个节点的特殊性
    //2. head->next == null 如果删除倒数第一个，获取到倒数第二个head->next = head->next->next
    public function removeNthFromEnd2($n)
    {
        $this->getNthFromEnd($this->head, $n);
    }
    public function getNthFromEnd($head, $n)
    {
        if ($head->next == null) return 1;
        
        $m = $this->getNthFromEnd($head->next, $n);
        
        echo $head->data,',',$m,"<br>";
        
        if ($m == $n) {
            $head->next = $head->next->next;
        }
        
        return $m + 1;
    }
    
    //链表的中间结点
    public function getMidNode()
    {
        $slow = $this->head->next;
        $fast = $this->head->next;
        
        while($fast && $fast->next)
        {
            $fast = $fast->next->next;
            $slow = $slow->next;
        }
        
        return $slow;
    }
    
    //单链表反转
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
    
    //head->1->2->3->4->5->NULL
    public function reverseBetween($beg, $end)
    {
        $prev = $this->head;
        $curr = $this->head->next;
        $i = 1;
        for(;$i<$beg;$i++)
        {
            $prev = $curr;
            $curr = $curr->next;
        }
        
        $begNode = $prev;
        $endNode = $curr;
        for(;$i<=$end;$i++)
        {
            $tmp = $curr->next;
            $curr->next = $prev;
            $prev = $curr;
            $curr = $tmp;
        }
        
        $begNode->next = $prev;
        $endNode->next = $curr;
        
        return true;
    }
    
    //head->c->b->a->null 
    public function printData()
    {
        if (null == $this->head->next) {
             //echo 'NULL';
             return false;
        }
        
        $curNode = $this->head;
        
        $length = $this->getLength();
        while($curNode->next != null && $length--){
            echo $curNode->next->data . ' -> ';
            
            $curNode = $curNode->next;
        }
        echo 'NULL<br>' . PHP_EOL;
        
        return true;
    }

    public function testBuildCircle()
    {
        $node1 = new LinkedNode(1);
        $node2 = new LinkedNode(2);
        $node3 = new LinkedNode(3);
        $node4 = new LinkedNode(4);
        $this->head->next = $node1;
        $node1->next = $node2;
        $node2->next = $node3;
        $node3->next = $node4;
        $node4->next = $node2;
        $this->length = 5;
    }
}

function isPalindrome(SingleLinkedList $list)
{
    if ($list->getLength() <= 1) return false;
    
    $slow = $list->head->next;
    $fast = $list->head->next;
    $pre = null;
    
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

//两个有序的链表合并
function mergeList($list1, $list2)
{
    $newList = new SingleLinkedList();
    $root = $newList->head;
    
    $list1 = $list1->head->next;
    $list2 = $list2->head->next;
    
    while($list1 && $list2) {
        if ($list1->data <= $list2->data) {
            $root->next = $list1;
            $list1 = $list1->next;
        } else {
            $root->next = $list2;
            $list2 = $list2->next;
        }
        $root = $root->next;
    }
    
    if ($list1) {
        $root->next = $list1;
    }
    
    if ($list2) {
        $root->next = $list2;
    }
    
    $newList->length = 100;
    $newList->printData();
}

$singleLinedList1 = new SingleLinkedList();
$singleLinedList1->insert('4');
$singleLinedList1->insert('2');
$singleLinedList1->insert('1');
$singleLinedList1->printData();

$singleLinedList2 = new SingleLinkedList();
$singleLinedList2->insert('5');
$singleLinedList2->insert('4');
$singleLinedList2->insert('3');
$singleLinedList2->insert('1');
$singleLinedList2->printData();

mergeList($singleLinedList1, $singleLinedList2);
/*
$singleLinedList->removeNthFromEnd2(5);
$singleLinedList->printData();

$singleLinedList->removeNthFromEnd(1);
$singleLinedList->printData();


var_dump($singleLinedList->getMidNode());

//链表反转
$singleLinedList->reverse();
$singleLinedList->printData();

//链表部分反转
$singleLinedList->reverseBetween(2, 3);
$singleLinedList->printData();

//回文串判断
var_dump(isPalindrome($singleLinedList));
*/