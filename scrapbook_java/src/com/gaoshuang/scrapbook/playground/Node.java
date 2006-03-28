//http://dev.csdn.net/article/33/33241.shtm

package com.gaoshuang.scrapbook.playground;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;

import org.apache.commons.lang.builder.EqualsBuilder;
import org.apache.commons.lang.builder.HashCodeBuilder;
import org.apache.commons.lang.builder.ToStringBuilder;
import org.apache.commons.lang.builder.ToStringStyle;

/**
 * 
 * <p>
 * Title: RuleNode
 * </p>
 * <p>
 * Description: This class implements a persisted tree node.
 * </p>
 * 
 * @hibernate.class table="node"
 * 
 * @author sean gao
 * @version 1.0
 */
public class Node /* extends BaseEntity */implements Serializable {

	private String name;// name

	private String description;// description

	private Node parent;// parent

	private java.util.Set children;// children

	public static void main(String[] args) {
	}

	public String getID() {
		return ID;
	}

	public void setID(String ID) {
		this.ID = ID;
	}

	/*
	 * Returns the node name.
	 * 
	 * @return String
	 * 
	 * @hibernate.property column="name" not-null="true" unique="true"
	 */
	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public Node getParent() {
		return parent;
	}

	public void setParent(Node parent) {
		this.parent = parent;
	}

	public String getDescription() {
		return description;
	}

	public void setDescription(String description) {
		this.description = description;
	}

	public String toString() {
		return name;
	}

	/**
	 * Returns the node's children.
	 * 
	 * @return List
	 * 
	 * @hibernate.list cascade="all-delete-orphan" inverse="true"
	 * @hibernate.collection-one-to-many class="net.thogau.myfuse.model.Node"
	 * @hibernate.collection-key column="parent_name"
	 */
	public java.util.Set getChildren() {
		return children;
	}

	public void setChildren(java.util.Set children) {
		this.children = children;
	}

	/**
	 * @see java.lang.Object#equals(Object)
	 */
	public boolean equals(Object object) {
		if (!(object instanceof Node)) {
			return false;
		}
		Node rhs = (Node) object;
		return new EqualsBuilder().append(this.name, rhs.name).append(
				this.children, rhs.children).append(this.parent, rhs.parent)
				.append(this.id, rhs.id).isEquals();
	}

	/**
	 * @see java.lang.Object#hashCode()
	 */
	public int hashCode() {
		return new HashCodeBuilder(1036586079, -537109207).append(this.name)
				.append(this.parent.getName()).append(this.id).toHashCode();
	}

	/**
	 * @see java.lang.Object#toString()
	 */
	public String toString() {
		return new ToStringBuilder(this, ToStringStyle.MULTI_LINE_STYLE)
				.append("name", this.name).append("parent", this.parent)
				.append("id", this.id).append("position", this.getPosition())
				.toString();
	}
}
