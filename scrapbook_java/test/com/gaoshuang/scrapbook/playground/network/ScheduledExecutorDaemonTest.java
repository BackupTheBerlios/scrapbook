/**
 * 
 */
package com.gaoshuang.scrapbook.playground.network;

import junit.framework.TestCase;
import java.util.Date;
import java.util.concurrent.TimeUnit;
/**
 * @author Sean Gao
 * @since 18:16:29 08-Jul-2005
 *
 */
public class ScheduledExecutorDaemonTest extends TestCase
{
    private int count;
    // if error is true, executes only once.
    // if error is false, executes every 1 sec.
    boolean error = false;

    public void test() throws InterruptedException {
        final Thread beeper = new Thread() {
            public void run() {
                System.out.println("run at " + new Date()+" "+count);
                
                //if (error)
                    //throw new RuntimeException("test");
                this.interrupt();
                this.stop();
                this.destroy();
                count++;
            }
        };
        ScheduledExecutorDaemon s = new ScheduledExecutorDaemon(beeper, 1, TimeUnit.SECONDS);
        
        Thread.sleep(10 * 1000);
        s.shutdown();
    }
}
