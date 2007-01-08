/**
 *
 */
package scrapbook;

import java.util.Arrays;

/**
 * @author Sean Gao
 * @since 17:44:44 28-Jun-2005
 *
 */
public class ReferenceTester {

    //Object a = new Object();
    //Object b = new Object();
    //String as = "low";
    //String bs = "UP";
    //String[] arraya = new String[] {"1","3","2"};

    public class Inner
    {
        String att;
        public Inner()
        {

        }
        public Inner(String s)
        {
            setAtt(s);
        }
        public void setAtt(String _att) {

            att = _att;
        }

        public String getAtt() {
            return att;
        }


    }

    /**
     *
     * @param c
     * @param d
     * @return
     */
    public void testReference(Object _a, Object _b, String _as, String _bs, String[] _arraya, Inner _inner, int _one)
    {
        _a = new String("this is object a");
        _b = "this is object b";
        _as=_as.toUpperCase();
        _bs.toLowerCase();
        Arrays.sort(_arraya);
        _inner.setAtt("this is the one");
        _one = 2;
        //return _a;
    }

    /**
     * @param args
     */
    public static void main(String[] args)
    {

        ReferenceTester rt = new ReferenceTester();
        Object a = new Object();
        Object b = new Object();
        String as = "low";
        String bs = "UP";
        String[] arraya = new String[] {"1","3","2"};
        Inner theone = rt.new Inner("this is not the one");
        int one = 1;

        //Object e=
            rt.testReference(a, b, as, bs, arraya,theone,one);
        System.out.println(a);
        System.out.println(b.toString());
        //System.out.println(e);
        System.out.println(as);
        System.out.println(bs);
        System.out.println(Arrays.toString(arraya));
        System.out.println(theone.getAtt());
        System.out.println(one);
    }

}
