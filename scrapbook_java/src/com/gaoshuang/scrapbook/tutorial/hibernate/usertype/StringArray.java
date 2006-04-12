package com.gaoshuang.scrapbook.tutorial.hibernate.usertype;
//http://blog.nona.name/archives/37.html
import java.io.Serializable;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Types;

import org.apache.commons.lang.ArrayUtils;
import org.apache.commons.lang.StringUtils;
import org.hibernate.Hibernate;
import org.hibernate.HibernateException;
import org.hibernate.usertype.UserType;

public class StringArray implements UserType {

	public int[] sqlTypes() {

		return new int[] { Types.VARCHAR };

	}

	public Class returnedClass() {

		return String[].class;

	}

	public boolean equals(Object x, Object y) throws HibernateException {

		return ArrayUtils.isEquals(x, y);

	}

	public Object nullSafeGet(ResultSet resultSet, String[] names, Object owner)
			throws HibernateException, SQLException {

		String val = (String) Hibernate.STRING.nullSafeGet(resultSet, names[0]);

		String[] arr = StringUtils.split(val, DELIM_CHAR);

		return arr;

	}

	private static final String DELIM_CHAR = ",";

	public void nullSafeSet(PreparedStatement st, Object value, int index)
			throws HibernateException, SQLException {

		String[] strings = (value == null) ? new String[0] : (String[]) value;

		String var = StringUtils.join(strings, DELIM_CHAR);

		Hibernate.STRING.nullSafeSet(st, var, index);

	}

	public Object deepCopy(Object x) throws HibernateException {

		if (x == null)
			return null;

		String[] input = (String[]) x;

		return ArrayUtils.clone(input);

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

	public Object assemble(Serializable cached, Object owner) throws HibernateException {
		return cached;
	}

	public Object replace(Object original, Object target, Object owner) throws HibernateException {
		return original;
	}

}
