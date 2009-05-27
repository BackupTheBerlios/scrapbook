package com.gaoshuang.scrapbook.playground.ui;
import java.awt.Color;
import java.awt.Graphics;
import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.IOException;
import java.net.MalformedURLException;
import java.net.URL;

import javax.imageio.ImageIO;
import javax.swing.JPanel;
import javax.swing.Timer;


public class SeanPanel extends JPanel implements ActionListener {
	
	private Image image;
	private double rotate = 0;
	private double move = 0;
	
	public void setImage(Image image) {
		this.image = image;
	}

	public SeanPanel() {
		
		Timer tim = new Timer(4, this);
		tim.start();
	}
	
	@Override
	public void paintComponent(Graphics g) {
		
		if (image != null) {
			Graphics2D g2d = (Graphics2D) g;
			g2d.setColor(Color.WHITE);
			g2d.fillRect(0, 0, getWidth(), getHeight());
			
			g2d.translate(move, 0);
			g2d.rotate(rotate);
			g2d.drawImage(image, 0, 0, this);
			g2d.dispose();
		}

	}

	@Override
	public void actionPerformed(ActionEvent e) {
		
		if (image == null) return;
		
		rotate += Math.PI / 80;
		move += 1;
		if (move > getWidth()) {
			move = -image.getWidth(this);
		}
		repaint();
	}
	
}
