package com.gaoshuang.scrapbook.tutorial.hibernate;

//http://www.gloegl.de/8.html

import org.hibernate.SessionFactory;
import org.hibernate.Session;
import org.hibernate.Transaction;
import org.hibernate.HibernateException;
import org.hibernate.LockMode;
import org.hibernate.cfg.Configuration;

import java.text.DateFormat;
import java.util.Date;
import java.util.List;

public class EventManager {

	public static void main(String[] args) throws java.text.ParseException {
		System.out.printf("the arg is %s", args).println();
		EventManager instance = new EventManager();
		if (args[0].equals("storeevent")) {
			String title = args[1];
			Date theDate = new Date();
			Long id = instance.storeEvent(title, theDate);
			System.out.println("Saved with id " + id);
		} else if (args[0].equals("list")) {
			List events = instance.listEvents();
			for (int i = 0; i < events.size(); i++) {
				Event theEvent = (Event) events.get(i);
				System.out.println("Event " + theEvent.getTitle() + " Time: "
						+ theEvent.getDate());
			}
		} else if (args[0].equals("storeuser")) {
			String firstname = args[1];
			String lastname = args[2];
			int age = Integer.parseInt(args[3]);
			Long id = instance.storeUser(firstname, lastname, age);
			System.out.println("Saved with id " + id);
		} else if (args[0].equals("addFavouriteEvent")) {
			Long userId = new Long(args[1]);
			Long eventId = new Long(args[2]);
			instance.addFavouriteEvent(userId, eventId);
		} else if (args[0].equals("addFavouriteEvent2")) {
			Long userId = new Long(args[1]);
			Long eventId = new Long(args[2]);
			instance.addFavouriteEvent2(userId, eventId);
		} else if (args[0].equals("addEmail")) {
			Long userId = new Long(args[1]);
			String email = args[2];
			instance.addEmail(userId, email);
		} else if (args[0].equals("participate")) {
			Long userId = new Long(args[1]);
			Long eventId = new Long(args[2]);
			instance.addParticipant(userId, eventId);
		}
		System.exit(0);
	}

	private List listEvents() {
		try {
			Session session = HibernateUtil.currentSession();
			Transaction tx = session.beginTransaction();

			List result = session.createQuery("from Event").list();

			tx.commit();
			hsqlCleanup(session);
			HibernateUtil.closeSession();

			return result;
		} catch (HibernateException e) {
			throw new RuntimeException(e.getMessage());
		}
	}

	private Long storeEvent(String title, Date theDate) {
		try {
			Session session = HibernateUtil.currentSession();
			Transaction tx = session.beginTransaction();

			Event theEvent = new Event();
			theEvent.setTitle(title);
			theEvent.setDate(theDate);

			Long id = (Long) session.save(theEvent);

			tx.commit();
			hsqlCleanup(session);
			HibernateUtil.closeSession();

			return id;
		} catch (HibernateException e) {
			throw new RuntimeException(e);
		}
	}

	private Long storeUser(String firstname, String lastname, int age) {
		try {
			Session session = HibernateUtil.currentSession();
			Transaction tx = session.beginTransaction();

			User theUser = new User();
			theUser.setFirstname(firstname);
			theUser.setLastname(lastname);
			theUser.setAge(age);

			Long id = (Long) session.save(theUser);

			tx.commit();
			hsqlCleanup(session);
			HibernateUtil.closeSession();

			return id;
		} catch (HibernateException e) {
			throw new RuntimeException(e);
		}
	}

	private void addFavouriteEvent(Long userId, Long eventId) {
		try {
			Session session = HibernateUtil.currentSession();
			Transaction tx = session.beginTransaction();

			User user = (User) session.load(User.class, userId);
			Event theEvent = (Event) session.load(Event.class, eventId);

			user.getFavouriteEvents().add(theEvent);

			tx.commit();
			hsqlCleanup(session);
			HibernateUtil.closeSession();

		} catch (HibernateException e) {
			throw new RuntimeException(e);
		}
	}

	private void addFavouriteEvent2(Long userId, Long eventId) {
		try {
			Session session = HibernateUtil.currentSession();
			Transaction tx = session.beginTransaction();

			User user = (User) session.load(User.class, userId);
			Event theEvent = (Event) session.load(Event.class, eventId);

			tx.commit();
			HibernateUtil.closeSession();

			session = HibernateUtil.currentSession();
			tx = session.beginTransaction();

			session.lock(user, LockMode.NONE);

			user.getFavouriteEvents().add(theEvent);

			tx.commit();
			hsqlCleanup(session);
			HibernateUtil.closeSession();

		} catch (HibernateException e) {
			throw new RuntimeException(e);
		}
	}

	private void addEmail(Long userId, String email) {
		try {
			Session session = HibernateUtil.currentSession();
			Transaction tx = session.beginTransaction();

			User user = (User) session.load(User.class, userId);

			user.getEmails().add(email);

			tx.commit();
			hsqlCleanup(session);
			HibernateUtil.closeSession();
		} catch (HibernateException e) {
			throw new RuntimeException(e);
		}
	}

	private void addParticipant(Long userId, Long eventId) {
		try {
			Session session = HibernateUtil.currentSession();
			Transaction tx = session.beginTransaction();

			User user = (User) session.load(User.class, userId);
			Event theEvent = (Event) session.load(Event.class, eventId);

			theEvent.addParticipant(user);

			tx.commit();
			hsqlCleanup(session);
			HibernateUtil.closeSession();
		} catch (HibernateException e) {
			throw new RuntimeException(e);
		}
	}

	private void hsqlCleanup(Session s) {
		try {
			s.connection().createStatement().execute("SHUTDOWN");
		} catch (Exception e) {
		}
	}

}