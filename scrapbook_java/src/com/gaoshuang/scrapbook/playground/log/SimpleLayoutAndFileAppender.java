/*http://supportweb.cs.bham.ac.uk/documentation/tutorials/docsystem/build/tutorials/log4j/log4j.html#LOG4J-Basics-Basics-Example
 * SimpleLayoutAndFileAppender.java
 *
 * Created on 09 August 2005, 11:39
 *
 * To change this template, choose Tools | Options and locate the template under
 * the Source Creation and Management node. Right-click the template and choose
 * Open. You can then make changes to the template in the Source Editor.
 */

package com.gaoshuang.scrapbook.playground.log;
import org.apache.log4j.Level;
import org.apache.log4j.Logger;
import org.apache.log4j.SimpleLayout;
import org.apache.log4j.FileAppender;

/**
 *
 * @author Sean Gao
 */
public class SimpleLayoutAndFileAppender {
    static Logger logger = Logger.getLogger(SimpleLayoutAndFileAppender.class);

    
    /** Creates a new instance of SimpleLayoutAndFileAppender */
    public SimpleLayoutAndFileAppender() {
    }
    
   public static void main(String args[]) {
      SimpleLayout layout = new SimpleLayout();

      FileAppender appender = null;
      try {
         appender = new FileAppender(layout,"output1.txt",false);
      } catch(Exception e) {}

      logger.addAppender(appender);
      logger.setLevel((Level) Level.INFO);

      logger.debug("Here is some DEBUG");
      logger.info("Here is some INFO");
      logger.warn("Here is some WARN");
      logger.error("Here is some ERROR");
      logger.fatal("Here is some FATAL");
   }    
}
