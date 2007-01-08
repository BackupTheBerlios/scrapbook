package htool;

import java.io.Serializable;
import org.apache.commons.lang.builder.EqualsBuilder;
import org.apache.commons.lang.builder.HashCodeBuilder;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class PgTsCfgmapId implements Serializable {

    /** identifier field */
    private String TsName;

    /** identifier field */
    private String TokAlias;

    /** full constructor */
    public PgTsCfgmapId(String TsName, String TokAlias) {
        this.TsName = TsName;
        this.TokAlias = TokAlias;
    }

    /** default constructor */
    public PgTsCfgmapId() {
    }

    public String getTsName() {
        return this.TsName;
    }

    public void setTsName(String TsName) {
        this.TsName = TsName;
    }

    public String getTokAlias() {
        return this.TokAlias;
    }

    public void setTokAlias(String TokAlias) {
        this.TokAlias = TokAlias;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("TsName", getTsName())
            .append("TokAlias", getTokAlias())
            .toString();
    }

    public boolean equals(Object other) {
        if ( (this == other ) ) return true;
        if ( !(other instanceof PgTsCfgmapId) ) return false;
        PgTsCfgmapId castOther = (PgTsCfgmapId) other;
        return new EqualsBuilder()
            .append(this.getTsName(), castOther.getTsName())
            .append(this.getTokAlias(), castOther.getTokAlias())
            .isEquals();
    }

    public int hashCode() {
        return new HashCodeBuilder()
            .append(getTsName())
            .append(getTokAlias())
            .toHashCode();
    }

}
