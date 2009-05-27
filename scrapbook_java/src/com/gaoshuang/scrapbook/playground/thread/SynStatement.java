package com.gaoshuang.scrapbook.playground.thread;

public class SynStatement {
	public static void main(String[] args) {
		Share1 t1 = new Share1("Thread One: ");
		t1.start();
		Share1 t2 = new Share1("Thread Two: ");
		t2.start();
	}
}

class Share1 extends Thread {
	static String msg[] = { "This", "is", "a", "synchronized", "variable" };

	Share1(String threadname) {
		super(threadname);
	}

	public void run() {
		display(getName());
	}

	public void display(String threadN) {
		synchronized (this.getClass()) {
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