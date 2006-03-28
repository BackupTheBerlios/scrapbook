package com.gaoshuang.scrapbook.playground.pattern.visitor;

import java.util.ArrayList;
import java.util.Collection;
import java.util.List;

public class Congress
{


    public static Collection loadPoliticians()
    {
        List<Politician> politicians = new ArrayList<Politician>();
        politicians.add(new Democrat("intern1"));
        politicians.add(new Democrat("intern2"));
        politicians.add(new Republican("buddy1"));
        politicians.add(new Republican("buddy2"));
        return politicians;
    }

}
