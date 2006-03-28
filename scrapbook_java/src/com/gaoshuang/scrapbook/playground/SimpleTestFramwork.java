package com.gaoshuang.scrapbook.playground;
/*
Simple test framework
  to demostrate varargs
  see http://java.sun.com/j2se/1.5.0/docs/guide/language/varargs.html
  */
import java.util.Scanner;

public class SimpleTestFramwork {
    public static void main(String[] args) {
        int passed = 0;
        int failed = 0;

        if (args.length==0)
        {
          Scanner sc1 = new Scanner(System.in);
          args = new String[]{sc1.next()};  
        }

        for (String className : args ) {
            try {
                Class c = Class.forName(className);
                c.getMethod("test").invoke(c.newInstance());
                passed++;
            } catch (Exception ex) {
                System.out.printf("%s failed: %s%n", className, ex);
                failed++;
            }
        }
        System.out.printf("passed=%d; failed=%d%n", passed, failed);
    }
}
