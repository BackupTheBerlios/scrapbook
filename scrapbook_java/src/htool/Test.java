package htool;

import java.io.Serializable;
import java.sql.Array;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class Test implements Serializable {

    /** identifier field */
    private Integer Id;

    /** nullable persistent field */
    private String Testtxt;

    /** nullable persistent field */
    private Array Testtest;

    /** full constructor */
    public Test(Integer Id, String Testtxt, Array Testtest) {
        this.Id = Id;
        this.Testtxt = Testtxt;
        this.Testtest = Testtest;
    }

    /** default constructor */
    public Test() {
    }

    /** minimal constructor */
    public Test(Integer Id) {
        this.Id = Id;
    }

    public Integer getId() {
        return this.Id;
    }

    public void setId(Integer Id) {
        this.Id = Id;
    }

    public String getTesttxt() {
        return this.Testtxt;
    }

    public void setTesttxt(String Testtxt) {
        this.Testtxt = Testtxt;
    }

    public Array getTesttest() {
        return this.Testtest;
    }

    public void setTesttest(Array Testtest) {
        this.Testtest = Testtest;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("Id", getId())
            .toString();
    }

}
