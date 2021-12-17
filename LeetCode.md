# 算法思路

## 一、数组

### 1、TwoSum

- 迭代
- 利用哈希表Map存value和index

## 二、链表

### 21、MergeTwoSortedLists

- 迭代+双指针，哨兵头节点-1

### 206、ReverseLinkedList

- 迭代+双指针，pre指针在前，cur指针为null，pre指针一直指向cur
- 递归，f(n) = f(n-1) + f(1)，递：头节点和剩余节点的解决方式，归：head.next.next = head; head.next = null;

### 141、LinkedListCycle

- 快慢指针，fast.next.next == low.next;

## 三、栈



## 四、队列

## 五、排序

## 六、查找

## 七、跳表

## 八、散列表

## 九、哈希算法

## 十、二叉树

## 十一、红黑树

## 十二、堆