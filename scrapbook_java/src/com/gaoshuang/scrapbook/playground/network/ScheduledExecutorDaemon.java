/**
 * 
 */
package com.gaoshuang.scrapbook.playground.network;
import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.TimeUnit;

/**
 * @author Sean Gao
 * @since 18:12:26 08-Jul-2005
 * @see http://altair.cs.oswego.edu/pipermail/concurrency-interest/2005-April/001423.html
 */
public class ScheduledExecutorDaemon
{
    private final ScheduledExecutorService scheduler =
        Executors.newSingleThreadScheduledExecutor();
    
    public ScheduledExecutorDaemon(Runnable command, long period, TimeUnit timeUnit) {
        scheduler.scheduleAtFixedRate(command, 0, period, timeUnit);
    }
    
    public void shutdown() {
        scheduler.shutdown();
    }

}
