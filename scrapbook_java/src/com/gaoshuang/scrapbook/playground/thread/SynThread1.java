package com.gaoshuang.scrapbook.playground.thread;

public class SynThread1 {
	public static void main(String[] args) {
		//String myVar = "abc";
		Share2 t1 = new Share2("abc1: ");
		t1.start();

		Share2 t2 = new Share2("abc1: ");
		t2.start();
		System.out.println("abc"=="abc");
	}
}

class Share2 extends Thread {
	String myVar = null;
	static String msg[] = { "This", "is", "a", "synchronized", "variable" };

	Share2(String threadname) {
		super(threadname);
		myVar = threadname;
	}

	public void run() {
		display(getName());
	}

	public void display(String threadN) {
		synchronized (myVar) {
			for (int i = 0; i <= 4; i++) {
				System.out.println(threadN + msg[i]);
				try {
					this.sleep(100);
				} catch (Exception e) {
				}
			}
		}

	}

}
