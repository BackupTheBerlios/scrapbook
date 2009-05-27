package com.gaoshuang.scrapbook.playground;

public class SequencePrecede {

	static int compare(char[] a, char[] b) {
		CompareAsync t1 = new CompareAsync(a, b, 0, a.length / 2 - 1);
		t1.start();

		CompareAsync t2 = new CompareAsync(a, b, a.length / 2, a.length - 1);
		t2.start();

		try {
			t1.join();
			t2.join();
		} catch (InterruptedException e) {
		}
		if (t1.getResult() == 0)
			return t2.getResult();
		else
			return t1.getResult();
	}

	public static void main(String[] args) {

		String list1 = "cegkuy";
		String list2 = "cdfkuy";
		String list3 = "cefcuy";
		String list4 = "cegmvy";
		System.out.println("list1 vs list2 = "
				+ compare(list1.toCharArray(), list2.toCharArray()));
		//System.out.println("list1 vs list3 = " + compare(list1.toCharArray(),
		// list3.toCharArray()));
		// System.out.println("list1 vs list4 = " + compare(list1.toCharArray(),
		// list4.toCharArray()));
	}
    class CompareAsync extends Thread {

        private char a[];

        private char b[];

        private int from, to;

        private int r;

        CompareAsync(char aa[], char bb[], int f, int t) {
            a = aa;
            b = bb;
            from = f;
            to = t;
        }

        public void run() {

            int k = from;
            while (k < to) {
                if (a[k] == b[k]) {
                    k++;
                }
                else
                    break;
            }
            if(a[k] == b[k])
            {
                   r = 0;
            }else if (a[k] < b[k])
            {
                    r = 1;
            } else
            {
                    r = 2;
            }
        }

        int getResult() {

            System.out.println("0 means Equal");
            System.out.println("1 means Less");
            System.out.println("2 means Greater");
            System.out.println("r is " + r);
            return r;
        }

    }
}

