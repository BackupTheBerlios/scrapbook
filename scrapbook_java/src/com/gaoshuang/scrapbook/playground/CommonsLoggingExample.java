/**
 * 
 */
package com.gaoshuang.scrapbook.playground;



/**
 * @author seangao
 * @since 20-Jun-2005
 *
 */
public class CommonsLoggingExample  {
    
    public static void main(String[] args)
    {
    /**
    * get Log instance from Fatory - this will return an instance of the Logger that is configured
    * in the commons-logging.properties file. The Log class provides a common wrapper regardless
    * of the actual implementation
    */
    Log log = LogFactory.getLog(CommonsLoggingExample.class);

    log.info("Test info message");
    log.warn("Test warn message");
    log.error("Test error message");
    log.debug("Test debug message");
    }

}
