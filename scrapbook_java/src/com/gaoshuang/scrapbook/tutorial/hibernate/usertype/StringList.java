package com.gaoshuang.scrapbook.tutorial.hibernate.usertype;

//http://blog.nona.name/archives/37.html
import java.io.Serializable;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Types;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collection;
import java.util.Collections;
import java.util.List;

import org.apache.commons.collections.CollectionUtils;
import org.apache.commons.lang.ArrayUtils;
import org.apache.commons.lang.StringUtils;
import org.hibernate.Hibernate;
import org.hibernate.HibernateException;
import org.hibernate.usertype.UserType;

public class StringList implements UserType {
	private List list;

	private static final String DELIM_CHAR = ",";

	public int[] sqlTypes() {

		return new int[] { Types.VARCHAR };

	}

	public Class returnedClass() {

		return List.class;

	}

	public boolean equals(Object x, Object y) throws HibernateException {
		if (x == y)
			return true;
		if (x != null && y != null) {
			return CollectionUtils.isEqualCollection((List) x, (List) y);
		}
		return false;
	}

	public Object nullSafeGet(ResultSet resultSet, String[] names, Object owner)
			throws HibernateException, SQLException {

		String value = (String) Hibernate.STRING.nullSafeGet(resultSet,
				names[0]);
		if (value != null) {
			String[] arr = StringUtils.split(value, DELIM_CHAR);
			//use an array list otherwise the object type is abstractArray which throws an exception on add()
			list = new ArrayList(Arrays.asList(arr));
			return list;
		} else
			return null;

	}

public void nullSafeSet(PreparedStatement st, Object value, int index)
			throws HibernateException, SQLException {

		String[] strings; 
		
		if (value == null) 
			strings= new String[0];
		else
		{
			List l = (List)value;
			strings = new String[l.size()];
			strings =(String[])l.toArray(strings);
		}

		String var = StringUtils.join(strings, DELIM_CHAR);

		Hibernate.STRING.nullSafeSet(st, var, index);

	}	

    public Object deepCopy(Object value) throws HibernateException {
    	List sourcelist=(List)value;
    	List targetlist = new ArrayList();
    	targetlist.addAll(sourcelist);
		return targetlist;
	}

	public boolean isMutable() {

		return false;

	}

	public int hashCode(Object value) throws HibernateException {
		return value.hashCode();
	}

	public Serializable disassemble(Object value) throws HibernateException {
		return (Serializable) value;
	}

	public Object assemble(Serializable cached, Object owner)
			throws HibernateException {
		return cached;
	}

	public Object replace(Object original, Object target, Object owner)
			throws HibernateException {
		return original;
	}

}
