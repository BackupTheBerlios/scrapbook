package htool;

import java.io.Serializable;
import java.util.Date;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class Users implements Serializable {

    /** identifier field */
    private Integer Id;

    /** nullable persistent field */
    private String Firstname;

    /** nullable persistent field */
    private Date Lastlogin;

    /** nullable persistent field */
    private String Lastname;

    /** nullable persistent field */
    private String Password;

    /** nullable persistent field */
    private String Username;

    /** full constructor */
    public Users(Integer Id, String Firstname, Date Lastlogin, String Lastname, String Password, String Username) {
        this.Id = Id;
        this.Firstname = Firstname;
        this.Lastlogin = Lastlogin;
        this.Lastname = Lastname;
        this.Password = Password;
        this.Username = Username;
    }

    /** default constructor */
    public Users() {
    }

    /** minimal constructor */
    public Users(Integer Id) {
        this.Id = Id;
    }

    public Integer getId() {
        return this.Id;
    }

    public void setId(Integer Id) {
        this.Id = Id;
    }

    public String getFirstname() {
        return this.Firstname;
    }

    public void setFirstname(String Firstname) {
        this.Firstname = Firstname;
    }

    public Date getLastlogin() {
        return this.Lastlogin;
    }

    public void setLastlogin(Date Lastlogin) {
        this.Lastlogin = Lastlogin;
    }

    public String getLastname() {
        return this.Lastname;
    }

    public void setLastname(String Lastname) {
        this.Lastname = Lastname;
    }

    public String getPassword() {
        return this.Password;
    }

    public void setPassword(String Password) {
        this.Password = Password;
    }

    public String getUsername() {
        return this.Username;
    }

    public void setUsername(String Username) {
        this.Username = Username;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("Id", getId())
            .toString();
    }

}
