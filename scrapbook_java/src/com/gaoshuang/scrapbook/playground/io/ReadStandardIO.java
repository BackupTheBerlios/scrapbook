package com.gaoshuang.scrapbook.playground.io;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;

public class ReadStandardIO{

	  public static void main(String[] args) throws IOException{

	      InputStreamReader inp = new InputStreamReader(System.in);
	      BufferedReader br = new BufferedReader(inp);

	      PrintWriter pw = new PrintWriter(System.out);
	      BufferedWriter bw= new BufferedWriter(pw);
	      System.out.println("Enter text : ");

	     String str = br.readLine();

	     bw.write("You entered String : ");

	     bw.write(str);
	     bw.close();
	  }
	}