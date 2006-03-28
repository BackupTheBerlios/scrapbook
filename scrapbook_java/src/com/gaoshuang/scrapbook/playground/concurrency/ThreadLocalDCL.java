//http://www.javaworld.com/javaworld/jw-11-2001/jw-1116-dcl.html
package com.gaoshuang.scrapbook.playground.concurrency;

import java.util.ResourceBundle;

class ThreadLocalDCL {

    private static final String resourceFile = "com.BLAH.BLAH";
    private static ThreadLocal initHolder = new ThreadLocal();
    private static ResourceBundle resource = null;

    public ResourceBundle getResource() {
      if (initHolder.get() == null) {
        synchronized(this) {
          if (resource == null)
            resource = ResourceBundle.getBundle(resourceFile);
          initHolder.set(Boolean.TRUE);
        }
      }
      return resource;
    }
  }
