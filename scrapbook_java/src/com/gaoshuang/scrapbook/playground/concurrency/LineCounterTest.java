//http://www.developer.com/java/article.php/3713031
package com.gaoshuang.scrapbook.playground.concurrency;

import static org.junit.Assert.*;
import java.io.*;
import org.junit.*;

public class LineCounterTest {
   private BufferedReader reader;

   @Test
   public void returns0WhenEmpty() {
      write("");
      assertEquals(0, count());
   }

   @Test
   public void returns1WhenOneLine() {
      write("a");
      assertEquals(1, count());
   }

   @Test
   public void returns2WhenTwoLines() {
      write("a\na");
      assertEquals(2, count());
   }

   @Test
   public void returnsNForNLines() {
      write("a\nb\nc");
      assertEquals(3, count());
   }

   @Test
   public void countsMultipleEmptyLines() {
      write("a\nb\n\nc");
      assertEquals(4, count());
   }

   @Test
   public void handlesEndOfLineAsLastCharacter() {
      write("a\n");
      assertEquals(1, count());
   }

   @Test
   public void resetsCountOnException() {
      reader = new BufferedReader(new StringReader(" ") {
      }) {
         @Override
         public String readLine() throws IOException {
            throw new IOException();
         }
      };
      assertEquals(LineCounter.NOT_CALCULATED, count());
   }

   private void write(String contents) {
      reader = new BufferedReader(new StringReader(contents));
   }

   private int count() {
      LineCounter counter = new LineCounter(reader);
      counter.run();
      return counter.getCount();
   }

   @Test
   public void supportsFiles() throws IOException {
      File temp = File.createTempFile("LineCountTest", ".txt");
      BufferedWriter writer = null;
      try {
         writer = new BufferedWriter(new FileWriter(temp));
         writeLine(writer, "a");
         writeLine(writer, "b");
         writer.close();
         LineCounter counter = new LineCounter(temp);
         counter.run();
         assertEquals(2, counter.getCount());
      }
      finally {
         writer.close();
         temp.delete(); // risky!
      }
   }

   @Test(expected = FileNotFoundException.class)
   public void failsConstructionOnFileNotFound()
      throws FileNotFoundException {
      File unlikelyFile = new File("zzzzznotexisting");
      assertFalse(unlikelyFile.exists());
      new LineCounter(unlikelyFile);
   }

   @Test
   public void supportsMultithreading()
      throws InterruptedException {
      write("a\nb\nc");
      LineCounter counter = new LineCounter(reader);
      Thread thread = new Thread(counter);
      thread.start();
      thread.join();
      assertEquals(3, counter.getCount());
   }

   private void writeLine(BufferedWriter writer, String text)
      throws IOException {
      writer.write(text);
      writer.newLine();
   }
}

