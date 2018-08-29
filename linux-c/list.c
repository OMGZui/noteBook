#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdbool.h>

#define LEN(arr) ((sizeof(arr) / sizeof(*arr)))
// 声明结点
typedef struct NODE Node;
struct NODE
{
    Node *link;
    int value;
};

// 根据数据创建单链表，并返回头结点
Node *create(int *arr, int len)
{
    // printf("%ld\n", sizeof(Node));   //16 这里为什么是16，是因为需要补齐
    // printf("%ld\n", sizeof(Node *)); // 8
    // printf("%ld\n", sizeof(int));    // 4
    // 头结点
    Node *head = (Node *)malloc(sizeof(Node));
    // 下一个结点
    Node *next = head;
    next->link = NULL;

    int i;
    for (i = 0; i < len; i++)
    {
        // 新结点
        Node *new = (Node *)malloc(sizeof(Node));
        new->value = *(arr + i);
        // 指向下一个结点
        next->link = new;
        new->link = NULL;
        // 新的下一个结点
        next = new;
    }
    return head;
}

// 遍历
void show(Node *head)
{
    Node *next = head->link;
    while (next != NULL)
    {
        // printf("链表的值=%d 地址=%p\n", next->value, next);
        printf("%d  ", next->value);
        next = next->link;
    }
    printf("\n");
}

// 插入
bool insert(Node *head, int pos, int val)
{
    Node *next = head;
    int i = 0;
    // 取到pos个位置的地址，为什么pos-1，是因为我们拿的是下一个地址
    while (next != NULL && i < pos - 1)
    {
        next = next->link;
        i++;
    }

    if (i > pos - 1 || next == NULL)
    {
        return false;
    }

    // 新结点
    Node *new = (Node *)malloc(sizeof(Node));
    new->value = val;

    // 临时结点代表next的下一个结点
    Node *tmp = next->link;

    // 正式插入
    next->link = new;
    new->link = tmp;
    return true;
}

// 链表长度
int length(Node * head)
{
    int n = 0;
    Node * next = head->link;
    while(next != NULL)
    {
        n++;
        next = next->link;
    }
    return n;
}

int main(int argc, char const *argv[])
{
    int arr[] = {1, 2, 3, 4, 5, 10, 9, 8, 7, 6};
    int len = LEN(arr);
    Node *head = create(arr, len);
    show(head);
    if (insert(head, 1, 100))
    {
        show(head);
        printf("长度：%d\n", length(head));
    }
    if (insert(head, 1, -100))
    {
        show(head);
        printf("长度：%d\n", length(head));
    }
    return 0;
}
