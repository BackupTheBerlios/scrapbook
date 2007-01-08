package htool;

import java.io.Serializable;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class PgTsDict implements Serializable {

    /** identifier field */
    private String DictName;

    /** nullable persistent field */
    private Object DictInit;

    /** nullable persistent field */
    private String DictInitoption;

    /** persistent field */
    private Object DictLexize;

    /** nullable persistent field */
    private String DictComment;

    /** full constructor */
    public PgTsDict(String DictName, Object DictInit, String DictInitoption, Object DictLexize, String DictComment) {
        this.DictName = DictName;
        this.DictInit = DictInit;
        this.DictInitoption = DictInitoption;
        this.DictLexize = DictLexize;
        this.DictComment = DictComment;
    }

    /** default constructor */
    public PgTsDict() {
    }

    /** minimal constructor */
    public PgTsDict(String DictName, Object DictLexize) {
        this.DictName = DictName;
        this.DictLexize = DictLexize;
    }

    public String getDictName() {
        return this.DictName;
    }

    public void setDictName(String DictName) {
        this.DictName = DictName;
    }

    public Object getDictInit() {
        return this.DictInit;
    }

    public void setDictInit(Object DictInit) {
        this.DictInit = DictInit;
    }

    public String getDictInitoption() {
        return this.DictInitoption;
    }

    public void setDictInitoption(String DictInitoption) {
        this.DictInitoption = DictInitoption;
    }

    public Object getDictLexize() {
        return this.DictLexize;
    }

    public void setDictLexize(Object DictLexize) {
        this.DictLexize = DictLexize;
    }

    public String getDictComment() {
        return this.DictComment;
    }

    public void setDictComment(String DictComment) {
        this.DictComment = DictComment;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("DictName", getDictName())
            .toString();
    }

}
