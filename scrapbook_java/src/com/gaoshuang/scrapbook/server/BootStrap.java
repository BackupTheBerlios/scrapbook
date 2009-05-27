package com.gaoshuang.scrapbook.server;

import java.io.*;
import java.net.*;
import java.util.*;
import java.lang.reflect.*;



public class BootStrap extends URLClassLoader implements Runnable  {
	private static Properties config = new Properties();	
	static URL[] classPathURLs;
	static {
		try {
			loadConfig("boot.properties");
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		String[] classPaths = sequentialPropertiesToList(config, "classpath");
		classPathURLs = convertPathsToURLs(classPaths);
	}
	
	//Below code is just to proof that we can get class-path of the jar we trying to load
	/*
	static String jarClassPath = null;
	static{
		JarFile jarToLoad;
		try {
			jarToLoad = new JarFile("place where the jar is in");
			Manifest manny = jarToLoad.getManifest();
			jarClassPath = manny.getMainAttributes().getValue("Class-Path");
			jarClassPath = jarClassPath.replace(" ", ":");
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	*/
	public BootStrap() {
		super(classPathURLs);
	}	

	public BootStrap(URL[] urls) {
		super(urls);
	}

	public static void main(String[] args) {
			boot();
	}	
	
	public static void boot(){
			
		Thread bootThread = new Thread(new BootStrap(), "BootStrap");		
		bootThread.setContextClassLoader(new BootStrap());
		bootThread.start();
	}
	
	@SuppressWarnings("unchecked")
	@Override
	public void run() {
		
		//String[] classPaths = sequentialPropertiesToList(config, "classpath");
		String className = config.getProperty("class");
		String methodName = config.getProperty("method");
		String[] args = sequentialPropertiesToList(config, "args");
		
		try {
			Class startClass = this.loadClass(className);
			//Class startClass = Class.forName(className,false,this);
			
			this.loadClass("org.springframework.context.support.ClassPathXmlApplicationContext");
			
			Class[] argTypes = { args.getClass() };

			//String classPath = arrayToCSV(classPaths);
			//System.out.println("Starting " + className + " with classpath " + classPath);
			Method method = startClass.getMethod(methodName, argTypes);
			
			Object[] argObjs = { args };
			method.invoke(null, argObjs);
			
		} catch (ClassNotFoundException e) {
			e.printStackTrace();
		} catch (IllegalArgumentException e) {
			e.printStackTrace();
		} catch (IllegalAccessException e) {
			e.printStackTrace();
		} catch (InvocationTargetException e) {
			e.printStackTrace();
		} catch (SecurityException e) {
			e.printStackTrace();
		} catch (NoSuchMethodException e) {
			e.printStackTrace();
		}
	}	


	private static String[] sequentialPropertiesToList(Properties props, String prefix) {
		
		List<String> list = new LinkedList<String>();
		
		int i = 0;
		String value = props.getProperty(prefix + "." + i);
		while (value != null) {		
			list.add(value);
			value = props.getProperty(prefix + "." + (++i));
		}
		
		return list.toArray(new String[list.size()]);
	}
	
	
	private static URL[] convertPathsToURLs(String[] paths) {
		
		URL[] urls = new URL[paths.length];
		for (int i=0; i<paths.length; i++) {
			try {
				if (paths[i].contains(":/")) {
					urls[i] = new URL(paths[i]);
				}
				else {
					urls[i] = new File(paths[i]).toURI().toURL();
				}
				System.out.println(urls[i]);
			} 
			catch (MalformedURLException e) {
				System.err.println(paths[i] + " is not a valid path");
			}				
		}
		
		return urls;
	}	
	
	private static String arrayToCSV(String[] array) {
		
		StringBuilder csv = new StringBuilder();

		for (int i=0; i<array.length; i++) {
			csv.append(array[i]);
			if (i < array.length-1) {
				csv.append(", ");
			}
		}
		
		return csv.toString();
	}	
	
	private static void loadConfig(String configLocation) throws IOException {
		
		InputStream configStream = null;
		try {
			URL configURL = BootStrap.class.getResource(configLocation);
			if (configURL == null) {
				throw new FileNotFoundException("Bootstrap config not found");
			}
			configStream = configURL.openStream();
			config.load(configStream);
		}		
		finally {
			if (configStream != null) {
				configStream.close();
			}
		}
	}	
	

}
