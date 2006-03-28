package com.gaoshuang.scrapbook.secpay;

/*
 * SOAPClient.java
 */
import java.security.Security;
import javax.xml.namespace.QName;

import org.apache.axis.client.Call;
import org.apache.axis.client.Service;

/**
 * This class uses the Apache Axis SOAP Libraries to place a transaction with
 * SECPay using the SECPay test account.
 * 
 * Note: You must have JSSE either as part of JDK1.4 or seperately installed in
 * order to run this client.
 */
public class SOAPClient {

	/**
	 * This method will run a test SOAP transaction through the SECPay system
	 * using the SECPay test account.
	 */
	public static void main(String[] args) {
		try {
			System.setProperty("java.protocol.handler.pkgs",
					"com.sun.net.ssl.internal.www.protocol");
			Security.addProvider(new com.sun.net.ssl.internal.ssl.Provider());

			String endPointAddress = "https://www.secpay.com/java-bin/soap";
			Service service = new Service();
			Call call = (Call) service.createCall();
			call.setTargetEndpointAddress(endPointAddress);
			call.setOperationName(new QName("SECCardService",
					"validateCardFull"));

			Object[] methodParams = {
					"secpay",
					"secpay",
					"TRAN0001",
					"127.0.0.1",
					"Mr Cardholder",
					"4444333322221111",
					"50.00",
					"0105",
					"",
					"",
					"",
					"",
					"name=Fred+Bloggs,company=Online+Shop+Ltd,addr_1=Dotcom+House,addr_2=London+Road,city=Townville,state=Countyshire,post_code=AB1+C23,tel=01234+567+890,fax=09876+543+210,email=somebody%40secpay.com,url=http%3A%2F%2Fwww.somedomain.com",
					"test_status=true,dups=false,card_type=Visa" };

			String returned = (String) call.invoke(methodParams);
			System.out.println("Soap returned: " + returned);
		} catch (javax.xml.rpc.ServiceException serviceException) {
			serviceException.printStackTrace();
			System.exit(-1);
		} catch (java.rmi.RemoteException remoteException) {
			remoteException.printStackTrace();
			System.exit(-1);
		} catch (Exception e) {
			e.printStackTrace();
			System.exit(-1);
		}
	}

}
