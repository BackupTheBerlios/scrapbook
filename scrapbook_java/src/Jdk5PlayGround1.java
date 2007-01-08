import java.io.*;
import java.util.ArrayList;
import java.util.Scanner;
import java.sql.Timestamp;
import java.util.Date;
import java.util.concurrent.TimeUnit;

/**
 * Created by IntelliJ IDEA.
 * User: seangao
 * Date: 02-Jul-2005
 * Time: 23:53:51
 * To change this template use File | Settings | File Templates.
 */
public class Jdk5PlayGround1 {
    public Jdk5PlayGround1() {
    }

  // Method that returns a Timestamp
  // object.
  public static Timestamp getCurrentTime()
   {
    // Instantiates a Date object and calls
    // the getTime method, and creates and
    // returns the Timestamp object with the
    // current time. In one line!
    return new Timestamp(new Date().getTime());
   }
    //The main method that calls the
    // getCurrentTime method and returns
    // the Timestamp object and prints
    // to screen


    public static void main(String[] args) throws Exception{

        System.out.println(getCurrentTime());
        Thread.sleep(2000);
        System.out.println(getCurrentTime());
        TimeUnit.MILLISECONDS.sleep(2000);
        System.out.println(getCurrentTime());

        long starttime=System.currentTimeMillis();
        TimeUnit.MILLISECONDS.sleep(2000);
        long endtime=System.currentTimeMillis();
        System.out.println(starttime);
        System.out.println(endtime);
        System.out.println(endtime-starttime);

         Writer writer = new OutputStreamWriter(System.out, "UTF-8");
         writer.write("[%s]屁啦~11111");
         //writer.close();

         OutputStream out = new FileOutputStream("seanwrite.txt");
         Writer writer1 = new OutputStreamWriter(out, "UTF-8");
         writer1.write("[%s]屁啦~1232123");
         writer1.close();

         //StringBuilder
         System.out.println(" this "+ " is " + " bad");
         System.out.println(new StringBuffer(" this ").append(" is ").append (" ok"));
         System.out.println(new StringBuilder(" this ").append(" is ").append ("  good but only works in JDK"));

         //printf

        //在java中要怎麼用printf
        System.out.printf("[%s]I am %d years old", "popcorny小披披", 18);
        //加上換行
        System.out.printf(new java.util.Locale("UTF-8"),"[%s]小披披我今年%d歲", "小披披popcorny", 18).println();
        //另外也有類似sprintf的method
        String str = String.format("[%s]小披披屁啦~", "小披披moliwang");
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

        writer.close();

    }
}