/*
 * ClassVersionChecker.java
 *http://forum.java.sun.com/thread.jspa?forumID=31&threadID=624398
 * Created on 09 July 2005, 05:55
JDK 1.1 45.3 

JDK 1.2 46.0 

JDK 1.3 47.0 

JDK 1.4 48.0 

JDK 1.5 49.0 

When i examine the class, as i referred earlier, Second Four Byte gave me the value 0 3 0 45. So i concluded that my class file is compiled in JDK 1.1.

From java world:
"The second four bytes of the class file contain the major and minor version numbers. These numbers identify the version of the class file format to which a particular class file adheres and allow JVMs to verify that the class file is loadable. Every JVM has a maximum version it can load, and JVMs will reject class files with later versions."

 */

package scrapbook.util;

/**
 *
 * @author seangao
 */
public class ClassVersionChecker {
    
    /** Creates a new instance of ClassVersionChecker */
    public ClassVersionChecker() {} 
    public static void main( String[] args ) throws Exception {
        java.io.FileInputStream fileInputStream=new java.io.FileInputStream("C:\\Item.class");
        byte readbyte;
        int i=3;
        while(i < 8 ) {
            System.out.println(fileInputStream.read());
            i++;
        }
    }
}
