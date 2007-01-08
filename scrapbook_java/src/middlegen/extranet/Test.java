package middlegen.extranet;

import java.io.Serializable;
import java.sql.Array;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class Test implements Serializable {

    /** identifier field */
    private Integer id;

    /** nullable persistent field */
    private String testtxt;

    /** nullable persistent field */
    private Array testtest;

    /** full constructor */
    public Test(Integer id, String testtxt, Array testtest) {
        this.id = id;
        this.testtxt = testtxt;
        this.testtest = testtest;
    }

    /** default constructor */
    public Test() {
    }

    /** minimal constructor */
    public Test(Integer id) {
        this.id = id;
    }

    public Integer getId() {
        return this.id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getTesttxt() {
        return this.testtxt;
    }

    public void setTesttxt(String testtxt) {
        this.testtxt = testtxt;
    }

    public Array getTesttest() {
        return this.testtest;
    }

    public void setTesttest(Array testtest) {
        this.testtest = testtest;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("id", getId())
            .toString();
    }

}
