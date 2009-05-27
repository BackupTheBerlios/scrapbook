package com.gaoshuang.scrapbook.playground.concurrency;

import static org.junit.Assert.*;
import org.junit.*;
import java.io.*;
import java.util.*;

public class LineCountServerTest {
   @Test
   public void multipleRequests() {
      LineCountServer server = new LineCountServer();
      LineCounter counter1 = new LineCounter(new BufferedReader(
            new StringReader("a")));
      LineCounter counter2 = new LineCounter(new BufferedReader(
            new StringReader("a\nb")));
      Queue<LineCounter> queue = new LinkedList<LineCounter>();
      queue.add(counter1);
      queue.add(counter2);
      server.setRequests(queue);
      server.run();
      assertEquals(1, counter1.getCount());
      assertEquals(2, counter2.getCount());
   }
}

