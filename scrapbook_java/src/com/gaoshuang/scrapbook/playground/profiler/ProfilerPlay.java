/*http://www.netbeans.org/kb/articles/case-study-nb-profiler.html
 * ProfilerPlay.java
 *
 * Created on 02 August 2005, 15:35
 *
 * To change this template, choose Tools | Options and locate the template under
 * the Source Creation and Management node. Right-click the template and choose
 * Open. You can then make changes to the template in the Source Editor.
 */

package com.gaoshuang.scrapbook.playground.profiler;


import java.util.*;
import java.io.*;

/**
 *
 * @author Sean Gao
 */
public class ProfilerPlay {
    Hashtable hashtable = new Hashtable();
    Square sq[] = new Square[10];    
    
    /** Creates a new instance of ProfilerPlay */
    public ProfilerPlay() {
    }
    
   /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        ProfilerPlay testhash = new ProfilerPlay();
        for(int i=0; i<100000; i++) {
            testhash.create(i);
            testhash.use(i);
            testhash.release();
        }
    }

    // Create Square objects.
    void create(int i) {
        for(int j=0; j<10; j++) {
            long index = j+i*10;
            sq[j] = new Square(index);
            hashtable.put(sq[j].num, sq[j]);
        }
    }

    // Use Square objects.
    void use(int i) {
        for(int j=0; j<10; j++) {
            System.out.print(((Square)(hashtable.get(sq[j].num))).square + " ");
        }
        System.out.println();
    }

    void release() {
        for(int j=0; j<10; j++) {
            sq[j] = null;
        }
    }

}

class Square {
    String num;
    String square;
    public Square(long num) {
        this.num = new Long(num).toString();
        this.square = new Long(num*num).toString();
    }
}

