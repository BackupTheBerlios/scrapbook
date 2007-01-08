//see http://www.hibernate.org/265.html
package com.gaoshuang.scrapbook.tutorial.hibernate.usertype;

import java.io.Serializable;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Types;

import org.hibernate.Hibernate;
import org.hibernate.HibernateException;
import org.hibernate.usertype.UserType;
/**
* a simple base  UserType persists an Enum's name into a text (e.g. TEXT, VARCHAR)
* database column rather than the default int ordinal() value
*
* @author Sean Gao
* @since 06-May-2006
*/
public abstract class StringEnumUserType<E extends Enum<E>> implements UserType {
    
	private Class<E> clazz = null;
	
	protected StringEnumUserType(Class<E> c) { 
	        this.clazz = c; 
	    }
    
	private static final int[] SQL_TYPES = { Types.VARCHAR };
	
	public int[] sqlTypes() {
		return SQL_TYPES;
	}

	public Class returnedClass() {
		return clazz;
	}

	public boolean equals(Object x, Object y) throws HibernateException {

		if (x == y) 
            return true; 
        if (null == x || null == y) 
            return false; 
        return x.equals(y); 

	}

	public Object nullSafeGet(ResultSet resultSet, String[] names, Object owner)
			throws HibernateException, SQLException 
	{
		String name = (String) Hibernate.STRING.nullSafeGet(resultSet, names[0]);
		return resultSet.wasNull() ? null : Enum.valueOf(clazz,name);

	}

	public void nullSafeSet(PreparedStatement st, Object value, int index)
			throws HibernateException, SQLException {

		Hibernate.STRING.nullSafeSet(st, ((Enum)value).name(), index);	

	}

	public Object deepCopy(Object value) throws HibernateException {

		return value; 

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
