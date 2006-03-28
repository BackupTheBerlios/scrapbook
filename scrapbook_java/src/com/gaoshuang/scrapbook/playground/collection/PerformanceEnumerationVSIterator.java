/* http://saloon.javaranch.com/cgi-bin/ubb/ultimatebb.cgi?ubb=get_topic&f=15&t=000747 */
package com.gaoshuang.scrapbook.playground.collection;

import java.util.*;

public class PerformanceEnumerationVSIterator {
public static void main(String[] args){        
		//ArrayList v=new ArrayList(); 
		Vector v=new Vector();
		Object element;        
		Enumeration enumer;        
		Iterator iter;        
		long start;                
		for(int i=0; i<2000000; i++){            
			v.add("New Element");        
		}                
		//enumer=Collections.enumeration(v);//elements();   
		enumer=v.elements(); 
		iter=v.iterator();        
		// *****CODE BLOCK FOR ITERATOR**********************
		start=System.currentTimeMillis();        
		while(iter.hasNext()){            
			element=iter.next();
		}
		System.out.println("Iterator took " + (System.currentTimeMillis()-start));        
		// *************END OF ITERATOR BLOCK************************
		System.gc();   // request to GC to free up some memory
		// *************CODE BLOCK FOR ENUMERATION*******************
		start=System.currentTimeMillis();        
		while(enumer.hasMoreElements()){            
			element=enumer.nextElement();        
		}        
		System.out.println("Enumeration took " + (System.currentTimeMillis()-start));           
		// ************END OF ENUMERATION BLOCK**********************
		
	}}
