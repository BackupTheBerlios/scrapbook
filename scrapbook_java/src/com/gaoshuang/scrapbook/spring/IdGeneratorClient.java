/* $RCSfile: IdGeneratorClient.java,v $
* Created on 11 Jan 2007 by sean.gao
* $Source: /home/xubuntu/berlios_backup/github/tmp-cvs/scrapbook/Repository/scrapbook_java/src/com/gaoshuang/scrapbook/spring/IdGeneratorClient.java,v $
* $Id: IdGeneratorClient.java,v 1.1 2009/05/27 14:28:42 gaoshuang Exp $
* Copyright (c) 2007 SECPay Ltd.  All rights reserved.
*/ 
package com.gaoshuang.scrapbook.spring;

/** 
 * TODO description here
 * @author sean.gao
 * @version $Revision: 1.1 $
 */
public class IdGeneratorClient
{
    private IdGenerator generator;
    public void setGenerator(IdGenerator generator)
    {
        this.generator = generator;
    }
    public long call(int granularity)
    {
        long id = generator.getNextId(granularity);
        System.out.printf("[%d] Is the id", id );
        return id;
    }

}
