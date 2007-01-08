package middlegen.extranet;

import java.io.Serializable;
import java.util.Date;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class User implements Serializable {

    /** identifier field */
    private Integer id;

    /** nullable persistent field */
    private String firstname;

    /** nullable persistent field */
    private Date lastlogin;

    /** nullable persistent field */
    private String lastname;

    /** nullable persistent field */
    private String password;

    /** nullable persistent field */
    private String username;

    /** full constructor */
    public User(Integer id, String firstname, Date lastlogin, String lastname, String password, String username) {
        this.id = id;
        this.firstname = firstname;
        this.lastlogin = lastlogin;
        this.lastname = lastname;
        this.password = password;
        this.username = username;
    }

    /** default constructor */
    public User() {
    }

    /** minimal constructor */
    public User(Integer id) {
        this.id = id;
    }

    public Integer getId() {
        return this.id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getFirstname() {
        return this.firstname;
    }

    public void setFirstname(String firstname) {
        this.firstname = firstname;
    }

    public Date getLastlogin() {
        return this.lastlogin;
    }

    public void setLastlogin(Date lastlogin) {
        this.lastlogin = lastlogin;
    }

    public String getLastname() {
        return this.lastname;
    }

    public void setLastname(String lastname) {
        this.lastname = lastname;
    }

    public String getPassword() {
        return this.password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getUsername() {
        return this.username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("id", getId())
            .toString();
    }

}
