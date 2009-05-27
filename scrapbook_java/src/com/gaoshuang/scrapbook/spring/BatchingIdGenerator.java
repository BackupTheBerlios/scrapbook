/* $RCSfile: BatchingIdGenerator.java,v $
* Created on 8 Jan 2007 by sean.gao
* $Source: /home/xubuntu/berlios_backup/github/tmp-cvs/scrapbook/Repository/scrapbook_java/src/com/gaoshuang/scrapbook/spring/BatchingIdGenerator.java,v $
* $Id: BatchingIdGenerator.java,v 1.1 2009/05/27 14:28:42 gaoshuang Exp $
*/ 
package com.gaoshuang.scrapbook.spring;

/** 
 * TODO description here
 * @author sean.gao
 * @version $Revision: 1.1 $
 */
public class BatchingIdGenerator implements IdGenerator {

    private IdGenerator generator;
    private int batchSize = 10;
    
    private long current = 0;
    private long max;
    
    public BatchingIdGenerator() 
    {
    }    
    
   public BatchingIdGenerator(IdGenerator generator) 
   {
      this.generator = generator;
   }

    public void setBatchSize(int batchSize) {
      this.batchSize = batchSize;
    }
    
    public void setGenerator(IdGenerator generator)
    {
        this.generator = generator;
    }

    public long getNextId(int granularity) {
      long id = current + granularity;
      if(id>max) 
      {
        current = generator.getNextId(batchSize);  
        max = current + batchSize;
        return current;
      }
      else if ((id + granularity)>max)
      {
          current = generator.getNextId(batchSize);  
          max = current + batchSize;
          return id;
      }
      
    }

  }