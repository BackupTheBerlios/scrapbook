/* $RCSfile: UUID.java,v $
* Created on 24 Jan 2007 by sean.gao
* $Source: /home/xubuntu/berlios_backup/github/tmp-cvs/scrapbook/Repository/scrapbook_java/src/com/gaoshuang/scrapbook/playground/uuid/UUID.java,v $
* $Id: UUID.java,v 1.1 2009/05/27 14:28:42 gaoshuang Exp $
*/ 
/**http://javafaq.nu/java-article1092.html
 * (0 - 7) IPAddress as HEX - 8 bytes 
(8 - 19) CurrentTimeMillis() as HEX - Display all 12 bytes 
(20 - 23) SecureRandom() as HEX - Keep only 4 significant bytes. Since this is "random" it doesn't really matter how many bytes you keep or eliminate 
(24 - 31) System.identityHashCode as Hex - 8 bytes 
 * 
 * **/
package com.gaoshuang.scrapbook.playground.uuid;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.apache.log4j.Category;

import java.net.InetAddress;
import java.security.SecureRandom;
import java.util.concurrent.atomic.AtomicLong;

public class UUID {
    private static final Log logger = LogFactory.getLog(UUID.class);

    public UUID() {
    }
    
    //System.currentTimeMillis()*10 means the AtomicLong part of the id will catch up with the Clock as long as the ids are generated less then 10000/s
    private static AtomicLong initId = new AtomicLong(System.currentTimeMillis()*10);    
    
    private static long getAtomicId(int granularity) {
      return initId.getAndAdd(granularity);
    }
    //getRandomDecimalString(5) is ok, but it is only future proof for about 200 years
    private static String initRandomDecimal = getRandomDecimalString(4);
    //private static String initRandomDecimal = "99999";
    private static String initRandomHex = getRandomHexString(4);
    
    private static String getRandomDecimalString(int length) 
    {
        String strTemp = "99999999";
        try 
        {
            //Get Random Segment
            SecureRandom prng = SecureRandom.getInstance("SHA1PRNG");
    
            strTemp = String.valueOf(Math.abs(prng.nextInt()));
            while (strTemp.length() < 8) {
                strTemp = '0' + strTemp;
            }    
        }
        catch (java.security.NoSuchAlgorithmException ex) {
            logger.error("No Such Algorithm Exception Caught: " + ex.getMessage());
        }
        return strTemp.substring(strTemp.length()-length);
      }
    
    private static String getRandomHexString(int length) 
    {
        String strTemp = "AAAAAAAA";
        try 
        {
            //Get Random Segment
            SecureRandom prng = SecureRandom.getInstance("SHA1PRNG");
    
            strTemp = Integer.toHexString(prng.nextInt());
            while (strTemp.length() < 8) {
                strTemp = '0' + strTemp;
            }    
        }
        catch (java.security.NoSuchAlgorithmException ex) {
            logger.error("No Such Algorithm Exception Caught: " + ex.getMessage());
        }
        return strTemp.substring(8-length);
      }
    
    /*
     * (first 10 or 11) AtomicLong bsed on time when the UID object is first initialised
     *(optional 1- 3) requires machines to be numbered (e.g 1, 01, 001). length depends on how many machines are in the cluster
     *(next 2 - 5) random numbers (could be a static one or a new one every time)
     */

    // this one has better performance (about 6 times faster on jdk 5) with a static initRandomDecimal;
    public static long getAtomicLongUUID()
    {
        return Long.valueOf(getAtomicId(1) + initRandomDecimal);
    }
    
    // this version is one is more "random" with calling getRandomDecimalString() every time;
    // It is safer in a clustered environment, or on servers that not running on standard times
    //getRandomDecimalString(5) is ok, but it is only future proof for about 200 years and the long will then get out of range
    public static long getAtomicLongWithRandomSuffixUUID()
    {
        return Long.valueOf(getAtomicId(1) + getRandomDecimalString(4));
    }

    // this version has a static "machine number" which is different for different server
    public static long getAtomicLongWithMachineNumberUUID(int machineNumber)
    {
        return Long.valueOf(getAtomicId(1) + String.valueOf(machineNumber) + getRandomDecimalString(4));
    }
    
    public static String getAtomicUID() {
      return (Long.toHexString(getAtomicId(1))+initRandomHex);      
    }    
           

    /* (0 - 7) IPAddress as HEX - 8 bytes 
    (8 - 19) CurrentTimeMillis() as HEX - Display all 12 bytes 
    (20 - 23) SecureRandom() as HEX - Keep only 4 significant bytes. Since this is "random" it doesn't really matter how many bytes you keep or eliminate 
    (24 - 31) System.identityHashCode as Hex - 8 bytes 
     * 
     * **/    
    public String getUID() {
        String strRetVal = "";
        String strTemp = "";
        try {
            // Get IPAddress Segment
            InetAddress addr = InetAddress.getLocalHost();

            byte[] ipaddr = addr.getAddress();
            for (int i = 0; i < ipaddr.length; i++) {
                Byte b = new Byte(ipaddr[i]);

                strTemp = Integer.toHexString(b.intValue() & 0x000000ff);
                while (strTemp.length() < 2) {
                    strTemp = '0' + strTemp;
                }
                strRetVal += strTemp;
            }

            strRetVal += ':';

            //Get CurrentTimeMillis() segment
            strTemp = Long.toHexString(System.currentTimeMillis());
            while (strTemp.length() < 12) {
                strTemp = '0' + strTemp;
            }
            strRetVal += strTemp + ':';

            //Get Random Segment
            SecureRandom prng = SecureRandom.getInstance("SHA1PRNG");

            strTemp = Integer.toHexString(prng.nextInt());
            while (strTemp.length() < 8) {
                strTemp = '0' + strTemp;
            }

            strRetVal += strTemp.substring(4) + ':';

            //Get IdentityHash() segment
            strTemp = Long.toHexString(System.identityHashCode((Object) this));
            while (strTemp.length() < 8) {
                strTemp = '0' + strTemp;
            }
            strRetVal += strTemp;

        }
        catch (java.net.UnknownHostException ex) {
            logger.error("Unknown Host Exception Caught: " + ex.getMessage());
        }
        catch (java.security.NoSuchAlgorithmException ex) {
            logger.error("No Such Algorithm Exception Caught: " + ex.getMessage());
        }

        return strRetVal.toUpperCase();
    }

    public static void main(String[] args) throws Exception {
        long lngStart = System.currentTimeMillis();
        for (int i = 0; i < 1000; i++) {
           
            //UID objUID = new UID();
            //logger.info(objUID.getUID());
            logger.info(getAtomicLongUUID());
            //logger.info(getAtomicUID());
            
        }
        logger.info("Elapsed time: " + (System.currentTimeMillis() - lngStart));
    }
}

