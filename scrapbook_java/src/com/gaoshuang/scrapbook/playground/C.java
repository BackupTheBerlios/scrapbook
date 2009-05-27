package com.gaoshuang.scrapbook.playground;

import java.lang.reflect.Field;
import java.util.logging.Logger;

class C {
	private static Logger logger =
		 Logger.getLogger(Logger.class.getName());
	/** Used as an identifier so we know where the object was created */
	String id;
	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	static int gcCount = 0;

	public C(String id) {
		this.id = id;

			System.out.println("initializer " + id );

	}

	public static void main(String a[]) {
		String s1 ="s111";
		changeString(s1,"s2222222222222222");
		logger.info("s1 is "+s1);
		C c1 = new C("1");
		C c2 = m1(c1);
		C c3 = new C("3");
		C c4 = new C("4");		
		c2 = c3; // 6
		//c2 = null;
		//c1=null;
		//c3=c4;
		c4=null;

		// Force the garbage collector to run
		System.gc();	
		try {
			// Wait for a while so the GC has time to run and we dont just exit
			Thread.sleep(1000);
		} catch (Exception e) {
		} finally {
			System.out.println("I counted " + gcCount
					+ " garbage collected objects");
			logger.info("c1.id is "+c1.id);
		}

	}

	static C m1(final C ob1) {
		 ob1.setId("111");
		//ob1 = new C("m1");
		return ob1;
	}
	
	
	static void changeString( final String s, String value) {
		//final makes sure this not allowed, even without the final, this will not change s1's value anyway
		//http://renaud.waldura.com/doc/java/final-keyword.shtml
		//s=value;
		Field stringValue=null;

		// String has a private char [] called "value"
		// if it does not, find the char [] and assign it to value
		try {
			stringValue = String.class.getDeclaredField("value");
		} catch (NoSuchFieldException ex) {
			// safety net in case we are running on a VM with a
			// different name for the char array.
			Field[] all = String.class.getDeclaredFields();
			for (int i = 0; stringValue == null && i < all.length; i++) {
				if (all[i].getType().equals(char[].class)) {
					stringValue = all[i];
				}
			}
		}
		if (stringValue != null) {
			stringValue.setAccessible(true); // make field public
		}
		
		try {
			stringValue.set(s, value.toCharArray());
		} catch (IllegalArgumentException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IllegalAccessException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

	}	

	/**
	 * This gets called when the GC kills off the object
	 */
	protected void finalize() {
		gcCount++;
		System.out.println(id + " has died");
	}
}

class c2 {

	{
		System.out.println("initializer");
	}
	public static void main(String a[]) {
		System.out.println("main");

		c2 ob1 = new c2();
	}
}
