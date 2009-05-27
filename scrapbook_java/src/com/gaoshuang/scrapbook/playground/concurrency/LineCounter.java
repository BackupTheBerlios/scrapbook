package com.gaoshuang.scrapbook.playground.concurrency;

import java.io.*;

public class LineCounter implements Runnable {
   static final int NOT_CALCULATED = -1;
   private final BufferedReader reader;
   private int count = NOT_CALCULATED;
   private String filename;

   public LineCounter(BufferedReader reader) {
      this.reader = reader;
   }

   public LineCounter(File file) throws FileNotFoundException {
      this(new BufferedReader(new FileReader(file)));
      this.filename = file.getName();
   }

   public String getFilename() {
      return filename;
   }

   public void run() {
      count = 0;
      try {
         while (reader.readLine() != null)
            count++;
      } catch (IOException e) {
         count = NOT_CALCULATED;
      }
   }

   public int getCount() {
      return count;
   }
}
