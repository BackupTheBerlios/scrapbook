package com.gaoshuang.scrapbook.playground.concurrency;

import java.io.*;
import java.util.*;
import java.util.concurrent.*;

public class LineCountServer extends Thread {
   private Queue<LineCounter> queue =
      new LinkedList<LineCounter>();
   private CountDownLatch latch;

   public void setRequests(Queue<LineCounter> queue) {
      this.queue = queue;
   }

   public void run() {
      latch = new CountDownLatch(queue.size());
      while (!queue.isEmpty()) {
         final LineCounter counter = queue.remove();
         new Thread(new Runnable() {
            public void run() {
               execute(counter);
               latch.countDown();
            }
         }).start();
      }
      waitOnLatch();
   }

   private void waitOnLatch() {
      while (true) {
         try {
            latch.await();
            break;
         } catch (InterruptedException e) {
         }
      }
   }

   protected void execute(LineCounter counter) {
      counter.run();
      synchronized (this) {
         System.out.println(counter.getFilename() + " " +
                            counter.getCount());
      }
   }
}

