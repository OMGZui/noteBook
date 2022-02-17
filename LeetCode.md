# 算法思路

## 一、数组

### 1、TwoSum

- 迭代
- 利用哈希表Map存value和index

## 二、链表

应用：LRU 缓存

### 21、MergeTwoSortedLists

- 迭代+双指针，哨兵头节点-1

### 206、ReverseLinkedList

- 迭代+双指针，pre指针在前，cur指针为null，pre指针一直指向cur
- 递归，f(n) = f(n-1) + f(1)，递：头节点和剩余节点的解决方式，归：head.next.next = head; head.next = null;

### 141、LinkedListCycle

- 快慢指针，fast.next.next == low.next;

## 三、栈

应用：函数调用、浏览器前进后退

### 20、ValidParentheses

- 栈，左闭合进 右闭合出


## 四、队列

应用：阻塞队列、并发队列

## 五、排序

### 1、冒泡排序


## 六、查找

## 七、跳表

应用：Redis 中的有序集合（Sorted Set）

比较：

- 按照区间来查找数据这个操作，红黑树的效率没有跳表高
- 跳表更容易代码实现
- 红黑树比跳表的出现要早一些，很多编程语言中的 Map 类型都是通过红黑树来实现的

## 八、散列表

应用：HashTable

解决散列冲突：

- 开放寻址法  当数据量比较小、装载因子小的时候，适合采用开放寻址法。这也是 Java 中的ThreadLocalMap使用开放寻址法解决散列冲突的原因。
- 链表法  基于链表的散列冲突处理方法比较适合存储大对象、大数据量的散列表，而且，比起开放寻址法，它更加灵活，支持更多的优化策略，比如用红黑树代替链表。

```java
    static final int hash(Object key) {
        int h;
        return (key == null) ? 0 : (h = key.hashCode()) ^ (h >>> 16);
    }

    public int hashCode() {
        int h = hash;
        if (h == 0 && value.length > 0) {
            char val[] = value;

            for (int i = 0; i < value.length; i++) {
                h = 31 * h + val[i];
            }
            hash = h;
        }
        return h;
    }


```

## 九、哈希算法

应用：sha1、md5

具体场景：

- 唯一标识
- 数据完整性和正确性
- 安全加密
- 散列函数

- 负载均衡
- 数据分片
- 分布式存储

## 十、二叉树

应用：二叉查找树

## 十一、红黑树

## 十二、堆