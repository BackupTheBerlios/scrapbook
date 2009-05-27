package com.gaoshuang.scrapbook.server.v2;
import java.io.*;
import java.net.*;
import java.util.*;
import java.lang.reflect.*;


public class BootStrap implements Runnable {
	
	public static void main(String[] args) {
		try {
			BootStrap booter = new BootStrap("boot.properties");
			booter.boot();
		}		
		catch (IOException ex) {
			ex.printStackTrace();
		}
	}	
	
	private BootStrap(String configLocation) throws IOException {
		loadConfig(configLocation);
	}
	
	private void loadConfig(String configLocation) throws IOException {
		
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
	
	public void boot() {
		
		String[] classPaths = sequentialPropertiesToList(config, "classpath");
		URL[] classPathURLs = convertPathsToURLs(classPaths);
		
		Thread bootThread = new Thread(this, "Boot Thread");
		
		ClassLoader classLoader = new URLClassLoader(classPathURLs, ClassLoader.getSystemClassLoader());		
		bootThread.setContextClassLoader(classLoader);
		System.out.println(classLoader);
		bootThread.start();
	}
	
	@SuppressWarnings("unchecked")
	@Override
	public void run() {
		
		String className = config.getProperty("class");
		String methodName = config.getProperty("method");
		String[] args = sequentialPropertiesToList(config, "args");
		
		try {
			ClassLoader loader = Thread.currentThread().getContextClassLoader();
			System.out.println(loader);
			Class startClass = loader.loadClass(className);
			
			Class[] argTypes = { args.getClass() };

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
	
	private Properties config = new Properties();	
}
