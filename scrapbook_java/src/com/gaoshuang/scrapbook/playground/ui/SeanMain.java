package com.gaoshuang.scrapbook.playground.ui;import javax.swing.JDesktopPane;
import javax.swing.JFrame;
import javax.swing.SwingUtilities;
import javax.swing.UIManager;
import javax.swing.UnsupportedLookAndFeelException;


public class SeanMain extends JFrame {

	public static void main(String[] args) {
		
		SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				
				try {
					UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
				} catch (ClassNotFoundException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				} catch (InstantiationException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				} catch (IllegalAccessException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				} catch (UnsupportedLookAndFeelException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				
				SeanFrame f = new SeanFrame();
				f.setVisible(true);
				f.setLocation(20, 20);
				f.pack();
				
				SeanFrame f2 = new SeanFrame();
				f2.setVisible(true);
				f2.setLocation(40, 40);
				f2.pack();				

				JDesktopPane desktop = new JDesktopPane();
				desktop.add(f);
				desktop.add(f2);

				
				SeanMain frame = new SeanMain();	
				frame.setName("SeanMain");
				
				frame.setSize(640, 480);				
				frame.setContentPane(desktop);
				
				frame.setVisible(true);	
				frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
				
			}
		});
	}
	
}
