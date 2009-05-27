/* $RCSfile: ThreadScope.java,v $
* Created on 8 Jan 2007 by sean.gao
* $Source: /home/xubuntu/berlios_backup/github/tmp-cvs/scrapbook/Repository/scrapbook_java/src/com/gaoshuang/scrapbook/spring/ThreadScope.java,v $
* $Id: ThreadScope.java,v 1.1 2009/05/27 14:28:42 gaoshuang Exp $
*/ 
package com.gaoshuang.scrapbook.spring;

import java.util.HashMap;
import java.util.Map;

import org.springframework.beans.factory.ObjectFactory;
import org.springframework.beans.factory.config.Scope;

/** 
 * TODO description here
 * @author sean.gao
 * @version $Revision: 1.1 $
 */
public class ThreadScope implements Scope {

    private final ThreadLocal threadScope = new ThreadLocal() {
        protected Object initialValue() {
          return new HashMap();
        }
      };
    
    public Object get(String name, ObjectFactory objectFactory) {
      Map scope = (Map) threadScope.get();
      Object object = scope.get(name);
      if(object==null) {
        object = objectFactory.getObject();
        scope.put(name, object);
      }
      return object;
    }

    public Object remove(String name) {
      Map scope = (Map) threadScope.get();
      return scope.remove(name);
    }

    public void registerDestructionCallback(String name, Runnable callback) {
    }
    /** @see org.springframework.beans.factory.config.Scope#getConversationId()
     */
    public String getConversationId()
    {
        // TODO Auto-generated method stub
        return null;
    }
    
  }