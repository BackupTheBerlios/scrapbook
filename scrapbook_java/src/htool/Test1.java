package htool;

import java.io.Serializable;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class Test1 implements Serializable {

    /** identifier field */
    private Short Id;

    /** nullable persistent field */
    private String Txt;

    /** full constructor */
    public Test1(Short Id, String Txt) {
        this.Id = Id;
        this.Txt = Txt;
    }

    /** default constructor */
    public Test1() {
    }

    /** minimal constructor */
    public Test1(Short Id) {
        this.Id = Id;
    }

    public Short getId() {
        return this.Id;
    }

    public void setId(Short Id) {
        this.Id = Id;
    }

    public String getTxt() {
        return this.Txt;
    }

    public void setTxt(String Txt) {
        this.Txt = Txt;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("Id", getId())
            .toString();
    }

}
