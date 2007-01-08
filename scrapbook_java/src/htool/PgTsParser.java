package htool;

import java.io.Serializable;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class PgTsParser implements Serializable {

    /** identifier field */
    private String PrsName;

    /** persistent field */
    private Object PrsStart;

    /** persistent field */
    private Object PrsNexttoken;

    /** persistent field */
    private Object PrsEnd;

    /** persistent field */
    private Object PrsHeadline;

    /** persistent field */
    private Object PrsLextype;

    /** nullable persistent field */
    private String PrsComment;

    /** full constructor */
    public PgTsParser(String PrsName, Object PrsStart, Object PrsNexttoken, Object PrsEnd, Object PrsHeadline, Object PrsLextype, String PrsComment) {
        this.PrsName = PrsName;
        this.PrsStart = PrsStart;
        this.PrsNexttoken = PrsNexttoken;
        this.PrsEnd = PrsEnd;
        this.PrsHeadline = PrsHeadline;
        this.PrsLextype = PrsLextype;
        this.PrsComment = PrsComment;
    }

    /** default constructor */
    public PgTsParser() {
    }

    /** minimal constructor */
    public PgTsParser(String PrsName, Object PrsStart, Object PrsNexttoken, Object PrsEnd, Object PrsHeadline, Object PrsLextype) {
        this.PrsName = PrsName;
        this.PrsStart = PrsStart;
        this.PrsNexttoken = PrsNexttoken;
        this.PrsEnd = PrsEnd;
        this.PrsHeadline = PrsHeadline;
        this.PrsLextype = PrsLextype;
    }

    public String getPrsName() {
        return this.PrsName;
    }

    public void setPrsName(String PrsName) {
        this.PrsName = PrsName;
    }

    public Object getPrsStart() {
        return this.PrsStart;
    }

    public void setPrsStart(Object PrsStart) {
        this.PrsStart = PrsStart;
    }

    public Object getPrsNexttoken() {
        return this.PrsNexttoken;
    }

    public void setPrsNexttoken(Object PrsNexttoken) {
        this.PrsNexttoken = PrsNexttoken;
    }

    public Object getPrsEnd() {
        return this.PrsEnd;
    }

    public void setPrsEnd(Object PrsEnd) {
        this.PrsEnd = PrsEnd;
    }

    public Object getPrsHeadline() {
        return this.PrsHeadline;
    }

    public void setPrsHeadline(Object PrsHeadline) {
        this.PrsHeadline = PrsHeadline;
    }

    public Object getPrsLextype() {
        return this.PrsLextype;
    }

    public void setPrsLextype(Object PrsLextype) {
        this.PrsLextype = PrsLextype;
    }

    public String getPrsComment() {
        return this.PrsComment;
    }

    public void setPrsComment(String PrsComment) {
        this.PrsComment = PrsComment;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("PrsName", getPrsName())
            .toString();
    }

}
