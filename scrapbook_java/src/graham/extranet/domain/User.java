package graham.extranet.domain;

import java.io.Serializable;
import java.util.Date;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class User implements Serializable {

    /** identifier field */
    private Integer id;

    /** nullable persistent field */
    private String firstName;

    /** nullable persistent field */
    private Date lastLogin;

    /** nullable persistent field */
    private String lastName;

    /** nullable persistent field */
    private String password;

    /** nullable persistent field */
    private String userName;

    /** full constructor */
    public User(String firstName, Date lastLogin, String lastName, String password, String userName) {
        this.firstName = firstName;
        this.lastLogin = lastLogin;
        this.lastName = lastName;
        this.password = password;
        this.userName = userName;
    }

    /** default constructor */
    public User() {
    }

    public Integer getId() {
        return this.id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getFirstName() {
        return this.firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public Date getLastLogin() {
        return this.lastLogin;
    }

    public void setLastLogin(Date lastLogin) {
        this.lastLogin = lastLogin;
    }

    public String getLastName() {
        return this.lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public String getPassword() {
        return this.password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getUserName() {
        return this.userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("id", getId())
            .toString();
    }

}
