package middlegen.extranet;

import java.io.Serializable;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class Test1 implements Serializable {

    /** identifier field */
    private Short id;

    /** nullable persistent field */
    private String txt;

    /** full constructor */
    public Test1(Short id, String txt) {
        this.id = id;
        this.txt = txt;
    }

    /** default constructor */
    public Test1() {
    }

    /** minimal constructor */
    public Test1(Short id) {
        this.id = id;
    }

    public Short getId() {
        return this.id;
    }

    public void setId(Short id) {
        this.id = id;
    }

    public String getTxt() {
        return this.txt;
    }

    public void setTxt(String txt) {
        this.txt = txt;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("id", getId())
            .toString();
    }

}
