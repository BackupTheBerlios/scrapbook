/**
 * 
 */
package scrapbook;

/**
 * @author Sean Gao
 * @since 18:52:35 15-Jul-2005
 */
public class Mistake
{
  
    static class Singleton {
       
        private static Singleton obj = new Singleton();
        public static int counter1;
        public static int counter2=0;
        
        private Singleton() {
            counter1++;
            counter2=100;
            }
        public static Singleton getInstance() {
            return obj;
            
            }
        }
    
    public static void main(String[] args) {
       Singleton obj = Singleton.getInstance();
       public static int i;
       System.out.println("i=="+i);
       System.out.println("obj.counter1=="+obj.counter1);
       System.out.println("obj.counter2=="+obj.counter2);
       }

}
