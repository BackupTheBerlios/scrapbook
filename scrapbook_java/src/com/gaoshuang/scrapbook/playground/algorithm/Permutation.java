package com.gaoshuang.scrapbook.playground.algorithm;
//http://caterpillar.onlyfun.net/Gossip/AlgorithmGossip/Permutation.htm
public class Permutation
{
    public static void perm(int[] num, int i)
    {
        if (i < num.length - 1)
        {
            for (int j = i; j <= num.length - 1; j++)
            {
                int tmp = num[j];
                // 旋轉該區段最右邊數字至最左邊
                for (int k = j; k > i; k--)
                {
                    num[k] = num[k - 1];
                }
                num[i] = tmp;
                perm(num, i + 1);
                // 還原
                for (int k = i; k < j; k++)
                {
                    num[k] = num[k + 1];
                }
                num[j] = tmp;
            }
        }
        else
        {
            // 顯示此次排列
            for (int j = 1; j <= num.length - 1; j++)
            {
                System.out.print(num[j] + " ");
            }
            System.out.println("");
        }
    }

    public static void main(String[] args)
    {
        //number of digit
        int N = 6;
        int[] num = new int[N + 1];
        for (int i = 1; i <= N; i++)
        {
            num[i] = i;
        }
        perm(num, 1);
    }
}