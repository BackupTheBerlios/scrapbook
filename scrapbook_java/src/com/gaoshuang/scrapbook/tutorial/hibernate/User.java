package com.gaoshuang.scrapbook.tutorial.hibernate;

import java.util.List;
import java.util.Set;
import java.util.HashSet;


public class User {
	private int age;
	private String firstname;
	private String lastname;
	private Long id;
	private List<String> stringList;
	private String[] stringArray;
	private Set favouriteEvents = new HashSet();
	private Set emails = new HashSet();
	private Set eventsJoined = new HashSet();
	
	protected Set getEventsJoined() {
		return eventsJoined;
	}
	
	protected void setEventsJoined(Set newEventsJoined) {
		eventsJoined = newEventsJoined;
	}
	
	public Set getEmails() {
		return emails;
	}
	
	public void setEmails(Set newEmails) {
		emails = newEmails;
	}
	
	public Set getFavouriteEvents() {
		return favouriteEvents;
	}
	
	public void setFavouriteEvents(Set newFavouriteEvents) {
		favouriteEvents = newFavouriteEvents;
	}
	
	public int getAge() {
		return age;
	}
	
	public void setAge(int newAge) {
		age = newAge;
	}
	
	public String getLastname() {
		return lastname;
	}
	
	public void setLastname(String newLastname) {
		lastname = newLastname;
	}
	
	public String getFirstname() {
		return firstname;
	}
	
	public void setFirstname(String newFirstname) {
		firstname = newFirstname;
	}
	
	private Long getId() {
		return id;
	}
	
	private void setId(Long newId) {
		id = newId;
	}

	public List getStringList() {
		return stringList;
	}


	public String[] getStringArray() {
		return stringArray;
	}

	public void setStringArray(String[] stringArray) {
		this.stringArray = stringArray;
	}

	public void setStringList(List<String> stringList) {
		this.stringList = stringList;
	}
}