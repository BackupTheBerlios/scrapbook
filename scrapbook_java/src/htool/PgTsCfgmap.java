package htool;

import java.io.Serializable;
import java.sql.Array;
import org.apache.commons.lang.builder.EqualsBuilder;
import org.apache.commons.lang.builder.HashCodeBuilder;
import org.apache.commons.lang.builder.ToStringBuilder;


/** @author Hibernate CodeGenerator */
public class PgTsCfgmap implements Serializable {

    /** identifier field */
    private htool.PgTsCfgmapId id;

    /** nullable persistent field */
    private Array DictName;

    /** full constructor */
    public PgTsCfgmap(htool.PgTsCfgmapId id, Array DictName) {
        this.id = id;
        this.DictName = DictName;
    }

    /** default constructor */
    public PgTsCfgmap() {
    }

    /** minimal constructor */
    public PgTsCfgmap(htool.PgTsCfgmapId id) {
        this.id = id;
    }

    public htool.PgTsCfgmapId getId() {
        return this.id;
    }

    public void setId(htool.PgTsCfgmapId id) {
        this.id = id;
    }

    public Array getDictName() {
        return this.DictName;
    }

    public void setDictName(Array DictName) {
        this.DictName = DictName;
    }

    public String toString() {
        return new ToStringBuilder(this)
            .append("id", getId())
            .toString();
    }

    public boolean equals(Object other) {
        if ( (this == other ) ) return true;
        if ( !(other instanceof PgTsCfgmap) ) return false;
        PgTsCfgmap castOther = (PgTsCfgmap) other;
        return new EqualsBuilder()
            .append(this.getId(), castOther.getId())
            .isEquals();
    }

    public int hashCode() {
        return new HashCodeBuilder()
            .append(getId())
            .toHashCode();
    }

}
