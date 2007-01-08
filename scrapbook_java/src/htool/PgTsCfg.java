package htool;

import java.io.Serializable;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class PgTsCfg implements Serializable {

    /** identifier field */
    private String TsName;

    /** persistent field */
    private String PrsName;

    /** nullable persistent field */
    private String Locale;

    /** full constructor */
    public PgTsCfg(String TsName, String PrsName, String Locale) {
        this.TsName = TsName;
        this.PrsName = PrsName;
        this.Locale = Locale;
    }

    /** default constructor */
    public PgTsCfg() {
    }

    /** minimal constructor */
    public PgTsCfg(String TsName, String PrsName) {
        this.TsName = TsName;
        this.PrsName = PrsName;
    }

    public String getTsName() {
        return this.TsName;
    }

    public void setTsName(String TsName) {
        this.TsName = TsName;
    }

    public String getPrsName() {
        return this.PrsName;
    }

    public void setPrsName(String PrsName) {
        this.PrsName = PrsName;
    }

    public String getLocale() {
        return this.Locale;
    }

    public void setLocale(String Locale) {
        this.Locale = Locale;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("TsName", getTsName())
            .toString();
    }

}
