package com.gaoshuang.scrapbook.playground.pattern.visitor;

import java.util.ArrayList;
import java.util.Collection;
import java.util.Iterator;
import java.util.List;

public class Main
{
    public static List<String> getInternsBAD() {
        Collection<Politician> lazyPoliticians = new Congress().loadPoliticians();
        ArrayList<String> interns = new ArrayList<String>();

        for (Politician politician : lazyPoliticians)
        {
            if (politician instanceof Democrat)
            {
                interns.add(((Democrat) politician).getFavoriteIntern());
            }
        }
        return interns;
      }

    public static List<String> getInterns() {
        Collection<Politician> lazyPoliticians = new Congress().loadPoliticians();
        final ArrayList<String> interns = new ArrayList<String>();

        PoliticianVisitor visitor = new PoliticianVisitorAdapter() {
          public void visit(Democrat democrat) {
            interns.add(democrat.getFavoriteIntern());
          }
        };

        for (Iterator iter=lazyPoliticians.iterator(); iter.hasNext(); ) {
          Politician politician = (Politician)iter.next();
          politician.accept(visitor);
        }
        return interns;
      }



    /**
     * @param args
     */
    public static void main(String[] args)
    {
        List<String> interns = getInterns();
        for (String intern : interns  )
        {
            System.out.printf("the interns are %s",intern).println();
        }


    }

}
