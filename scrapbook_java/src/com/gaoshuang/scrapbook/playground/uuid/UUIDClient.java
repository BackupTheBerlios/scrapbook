/* $RCSfile: UUIDClient.java,v $
 * Created on 24 Jan 2007 by sean.gao
 * $Source: /home/xubuntu/berlios_backup/github/tmp-cvs/scrapbook/Repository/scrapbook_java/src/com/gaoshuang/scrapbook/playground/uuid/UUIDClient.java,v $
 * $Id: UUIDClient.java,v 1.1 2009/05/27 14:28:42 gaoshuang Exp $
 */
package com.gaoshuang.scrapbook.playground.uuid;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;

import java.util.ArrayList;
import java.util.Date;
import java.util.HashSet;
import java.util.concurrent.atomic.AtomicLong;

/**
 * TODO description here
 * 
 * @author sean.gao
 * @version $Revision: 1.1 $
 */
public class UUIDClient
{
    
    private static final Log logger = LogFactory.getLog(UUIDClient.class);
    
    public static void main(String[] args) throws Exception
    {
        /* convert a hex String to long */
        // Note, there is no lead 0x, case insensitive B27C758E400503429
        String g;
        long l;

        long lngStart = System.currentTimeMillis();
        UUID objUID;
        HashSet<Long> lset = new HashSet<Long>();
        for (int i = 0; i != 100000; i++)
        {
            //g = UID.getAtomicUID();
            //l = Long.parseLong(g.trim(), 16 /* radix */);
            //l = com.secpay.seccard.UUID.getUID(1, 0, false);
            l=UUID.getAtomicLongUUID();
            lset.add(l);
            //logger.info(l);
        }
        logger.info("hashset size: " + lset.size());
        logger.info("Elapsed time(ms): " + (System.currentTimeMillis() - lngStart));

    }
}
