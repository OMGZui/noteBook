#include <stdio.h>
#include <time.h>
#include <math.h>

#define PI 3.14159265

int main(int argc, char **argv)
{
    int n = 0;
    double val = PI / 180;
    while (*++argv != NULL && **argv == '-')
    {
        // printf("%s\n", *argv);
        // printf("%c\n", *++*argv);
        switch (*++*argv)
        {
        case 'a':
            printf("参数：%c    ", **argv);
            printf("%ld\n", time(NULL));
            break;
        case 'b':
            printf("参数：%c    ", **argv);
            printf("%f\n", sin(30 * val));
            break;
        }
        n++;
    }
    if (n == 0)
    {
        printf("没有输入参数\n");
    }
    return 0;
}
