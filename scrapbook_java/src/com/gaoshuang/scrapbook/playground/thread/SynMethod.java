/*
 *http://www.roseindia.net/java/thread/SynchronizedThreads.shtml
 *THIS ARTICLE IS INCORRECT, ALL WRONG!!!
 */
package com.gaoshuang.scrapbook.playground.thread;


public class SynMethod {

	public static void main(String[] args){
		Share t2 = new Share(null, "Thread Two: ");
		Share t1 = new Share(t2, "Thread One: ");
		t1.start();
	}
}

class Share extends Thread {
	static String msg[] = { "This", "is", "a", "synchronized", "variable" };
	Thread t2;

	Share(Thread t2, String threadname) {
		super(threadname);
		this.t2 = t2;
	}

	public void run() {
		display(getName());
	}

	public void display(String threadN) {

		for (int i = 0; i <= 4; i++){
			System.out.println(threadN + msg[i]);
			try {
				sleep(100);
			} catch (Exception e) {
			}
		}

		if (t2 != null) t2.start();
	}
}