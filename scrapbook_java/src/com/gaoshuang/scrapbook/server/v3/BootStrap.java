package com.gaoshuang.scrapbook.server.v3;
import java.io.*;
import java.net.*;
import java.util.*;
import java.lang.reflect.*;

public class BootStrap {
	
	public static void main(String[] args) {
		try {
			
			config = loadConfig("boot.properties");			
			
			String className = config.getProperty("class");
			String methodName = config.getProperty("method");	
			String[] methodArgs = sequentialPropertiesToList(config, "args");			
			String[] classPaths = sequentialPropertiesToList(config, "classpath");
			URL[] classPathURLs = convertPathsToURLs(classPaths);			
			
			boot(className, methodName, methodArgs, classPathURLs);
			
		} catch (Exception e) {
			e.printStackTrace();
		}
	}	
	
	@SuppressWarnings("unchecked")
	public static void boot(String className, String methodName, Object[] methodArgs, URL[] classPathURLs) 
		throws ClassNotFoundException, SecurityException, NoSuchMethodException, 
		IllegalArgumentException, IllegalAccessException, InvocationTargetException {
		
		updateLocalCache(classPathURLs);
		
		ClassLoader classLoader = new URLClassLoader(classPathURLs, ClassLoader.getSystemClassLoader());	
		Thread.currentThread().setContextClassLoader(classLoader);
		
		ClassLoader loader = Thread.currentThread().getContextClassLoader();
		Class startClass = loader.loadClass(className);

		Method method = startClass.getMethod(methodName,  new Class[] { methodArgs.getClass() });
		
		String classPath = arrayToString(classPathURLs, File.pathSeparator);		
		System.out.println("Starting " + className + " with classpath " + classPath);	
		
		method.invoke(null,  new Object[] { methodArgs });
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
				if (isLocalFilePath(paths[i])) {
					urls[i] = new File(paths[i]).toURI().toURL();
				}
				else {
					urls[i] = new URL(paths[i]);
				}
			} 
			catch (MalformedURLException e) {
				System.err.println(paths[i] + " is not a valid path");
			}				
		}
		
		return urls;
	}	
	
	private static boolean isLocalFilePath(String path) {
		return !path.contains("://");
	}
	
	private static String arrayToString(Object[] array, String seperator) {
		
		StringBuilder csv = new StringBuilder();

		for (int i=0; i<array.length; i++) {
			csv.append(array[i]);
			if (i < array.length-1) {
				csv.append(seperator);
			}
		}
		
		return csv.toString();
	}	
	
	private static Properties loadConfig(String configLocation) throws IOException {
		
		Properties config = new Properties();
		
		InputStream configStream = null;
		try {
			URL configURL = BootStrap.class.getResource(configLocation);
			if (configURL == null) {
				throw new FileNotFoundException("Configuration not found");
			}
			configStream = configURL.openStream();
			config.load(configStream);
		}		
		finally {
			if (configStream != null) {
				configStream.close();
			}
		}
		
		return config;
	}	
	
	
	private static URL[] updateLocalCache(URL[] classPathURLs) {
		
		for (int i=0; i<classPathURLs.length; i++) {

			URL remoteURL = classPathURLs[i];
			String path = remoteURL.getPath();
			
			if (!remoteURL.getProtocol().equals("file") && path.endsWith(".jar")) {
				
				String name = path.substring(path.lastIndexOf('/') + 1);
				File localFile = new File(name);
				File localTempFile = new File(name + ".tmp");
				long remoteModifiedTime = 0;
				InputStream remoteStream = null;
				OutputStream localStream = null;
				
				try {
					URLConnection conn = remoteURL.openConnection();
					conn.setConnectTimeout(Integer.parseInt(config.getProperty("connect.timeout", "5000")));
					conn.setReadTimeout(Integer.parseInt(config.getProperty("read.timeout", "10000")));
					
					remoteModifiedTime = conn.getLastModified();
					boolean modifed = remoteModifiedTime > localFile.lastModified();
					boolean sizeMismatch = conn.getContentLength() != localFile.length();
					
					if (modifed || sizeMismatch) {
						
						System.out.println("Downloading " + remoteURL + "...");
						
						// Stream remote data to local storage
						remoteStream = conn.getInputStream();
						localStream = new FileOutputStream(localTempFile);
						byte[] buffer = new byte[1024];
						int r = remoteStream.read(buffer);
						while (r > 0) {
							localStream.write(buffer, 0, r);
							r = remoteStream.read(buffer);
						}
						
						// File download complete
						localStream.close();
						localFile.delete();
						localTempFile.renameTo(localFile);
						localFile.setLastModified(remoteModifiedTime);
						
						System.out.println("Saved " + remoteURL + " as " + localFile);		
					}
				} 
				catch (IOException e) {
					e.printStackTrace();
				}
				finally {
					
					// Ensure all streams are closed
					try { localStream.close();  } catch (Exception ignored) {}				
					try { remoteStream.close(); } catch (Exception ignored) {}	
					
					// Update the class path if resource now local
					if (localFile.exists()) {
						try { classPathURLs[i] = localFile.toURI().toURL();
						} catch (MalformedURLException ignored) {}	
					}
				}
			}
		}
		
		return classPathURLs;
	}	
	
	private static Properties config = new Properties();
}
