package com.gaoshuang.scrapbook.tutorial.hibernate;

import java.util.Date;
import java.util.Set;
import java.util.HashSet;

public class Event {
    private String title;
    private Date date;
    private Long id;
    private Set participatingUsers = new HashSet();
    
    protected Set getParticipatingUsers() {
    	return participatingUsers;
    }
    
    protected void setParticipatingUsers(Set newParticipatingUsers) {
    	participatingUsers = newParticipatingUsers;
    }
    
    public void addParticipant(User user) {
    	participatingUsers.add(user);
    	user.getEventsJoined().add(this);
    }
    
    public void removeParticipant(User user) {
    	participatingUsers.remove(user);
    	user.getEventsJoined().remove(this);
    }

    private Long getId() {
        return id;
    }

    private void setId(Long id) {
        this.id = id;
    }

    public Date getDate() {
        return date;
    }

    public void setDate(Date date) {
        this.date = date;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }
}