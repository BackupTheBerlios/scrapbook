package com.gaoshuang.scrapbook.playground.ui;
import java.awt.BorderLayout;
import java.awt.FlowLayout;
import java.awt.Image;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.IOException;
import java.net.MalformedURLException;
import java.net.URL;

import javax.imageio.ImageIO;
import javax.swing.Box;
import javax.swing.JButton;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JMenu;
import javax.swing.JMenuBar;
import javax.swing.JMenuItem;
import javax.swing.SwingUtilities;
import javax.swing.SwingWorker;
import javax.swing.Timer;


public class SeanFrame extends JInternalFrame implements ActionListener, Runnable {
	
	private SeanPanel seanPanel = new SeanPanel(); 
	private Thread runner;
	
	public SeanFrame() {
		super("SeanFrame",
		          true, //resizable
		          true, //closable
		          true, //maximizable
		          true);
		          
		add(seanPanel);
		
		JMenuBar menuBar = new JMenuBar();
		
		JMenu fileMenu = new JMenu("File");
		
		JMenuItem startItem = new JMenuItem("Load image");
		startItem.setActionCommand("START");
		startItem.addActionListener(this);
		
		fileMenu.add(startItem);
		
		JMenuItem stopItem = new JMenuItem("Stop image loading");
		stopItem.setActionCommand("STOP");
		stopItem.addActionListener(this);		
		
		fileMenu.add(stopItem);
		
		menuBar.add(fileMenu);
		
		setJMenuBar(menuBar);
	}


	@Override
	public void actionPerformed(ActionEvent evt) {
		
		String action = evt.getActionCommand();
		
		if (action.equals("START")) {
			
			if (runner != null) {
				runner.interrupt();
			}
			runner = new Thread(this);
			runner.start();
		}
		else if (action.equals("STOP")) {
			runner.interrupt();
		}
	}
	
	public void run() {
		System.out.println("Started!");
		try {
			Image image = ImageIO.read(new URL("http://www.google.co.uk/logos/spring09.gif"));
			seanPanel.setImage(image);
			
		} 
		catch (MalformedURLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}	
		System.out.println("Stopped!");
	}
}
