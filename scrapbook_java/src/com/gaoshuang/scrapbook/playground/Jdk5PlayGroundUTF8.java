package com.gaoshuang.scrapbook.playground;

import java.util.ArrayList;
import java.util.Scanner;

/**
 * Created by IntelliJ IDEA.
 * User: seangao
 * Date: 02-Jul-2005
 * Time: 23:53:51
 * To change this template use File | Settings | File Templates.
 */
public class Jdk5PlayGroundUTF8 {
    public Jdk5PlayGroundUTF8() {
    }

    public static void main(String[] args) {
        //printf
        //在java中要怎麼用printf
        System.out.printf("[%s]I am %d years old", "popcorny", 18);
        //加上換行
        System.out.printf("[%s]我今年%d歲乐拉", "popcorny", 18).println();
        //另外也有類似sprintf的method
        String str = String.format("[%s]屁啦是不是亚~", "moliwang");
        System.out.println(str);
        //其實主要這些功能都是由新的java.util.Formatter來提供的
        //可以去看一下這個class的javadoc

        /*
        scanf
        習慣用C的人輸出可能用printf
        輸入的話可能喜歡用scanf
        但是呢 在java沒有& (dereference)這個operator
        所以我們沒辦法像scanf這樣使用
        取而代之的 我們使用java.util.Scanner來達到這個目的
        */
        Scanner sc1 = new Scanner(System.in);
        int i = sc1.nextInt();
        String name = sc1.next();
        System.out.println(i + " " + name);
        //也可以從字串輸入
        Scanner sc = new Scanner("Add 1 2 3");
        String op = sc.next();
        int x = sc.nextInt();
        int y = sc.nextInt();
        int z = sc.nextInt();
        sc.close();
        System.out.println(op + " " + x + "" + y + " " + z);

        /*
        Auto (Un)Boxing
        helps 以基本型態帶入generic type的型態參數
        */
        //如果我們想要用int為內容的ArrayList我們可能會想要這麼寫
        //ArrayList<int> intList = new ArrayList<int>();  //illegal
        //但是因為type parameter一定要是reference type
        // 所以這樣是違法的因此我們要改成這樣寫
        ArrayList<Integer> intList = new ArrayList<Integer>(); //OK
        //這樣就可以用了但是你可能會想到那不是還是跟以前一樣麻煩
        // 加進去也是要轉換成wrapper
        // 不用!!!因為我們有Autoboxing跟unboxing
        intList.add(3);//auto boxing
        intList.add(5);  //auto boxing
        intList.add(100); //auto boxing
        int x1 = intList.get(0); //auto unboxing
        int y1 = intList.get(1); //auto unboxing

        //在enhanced for loop使用primitive type
        //在剛剛的intList中這樣使用可以嘛
        for (int i1 : intList) {
            System.out.printf("the number is %d", i1).println();
        }

    }
}