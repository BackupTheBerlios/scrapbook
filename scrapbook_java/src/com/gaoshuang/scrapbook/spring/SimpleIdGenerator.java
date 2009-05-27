/* $RCSfile: SimpleIdGenerator.java,v $
* Created on 8 Jan 2007 by sean.gao
* $Source: /home/xubuntu/berlios_backup/github/tmp-cvs/scrapbook/Repository/scrapbook_java/src/com/gaoshuang/scrapbook/spring/SimpleIdGenerator.java,v $
* $Id: SimpleIdGenerator.java,v 1.1 2009/05/27 14:28:42 gaoshuang Exp $
*/ 
package com.gaoshuang.scrapbook.spring;

import java.util.concurrent.atomic.AtomicLong;

/** 
 * TODO description here
 * @author sean.gao
 * @version $Revision: 1.1 $
 */
public class SimpleIdGenerator implements IdGenerator
{
    private AtomicLong id = new AtomicLong(0L);
    
    public long getNextId(int granularity) {
      return id.getAndAdd(granularity);
    }
}
