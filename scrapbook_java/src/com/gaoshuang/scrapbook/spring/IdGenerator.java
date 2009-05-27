/* $RCSfile: IdGenerator.java,v $
* Created on 8 Jan 2007 by sean.gao
* $Source: /home/xubuntu/berlios_backup/github/tmp-cvs/scrapbook/Repository/scrapbook_java/src/com/gaoshuang/scrapbook/spring/IdGenerator.java,v $
* $Id: IdGenerator.java,v 1.1 2009/05/27 14:28:42 gaoshuang Exp $
*/ 
package com.gaoshuang.scrapbook.spring;

/** 
 * TODO description here
 * @author sean.gao
 * @version $Revision: 1.1 $
 */
public interface IdGenerator
{
    public long getNextId(int granularity);
}
