package com.gaoshuang.scrapbook.playground.pattern.visitor;

public class Republican extends Politician
{
    String buddy;
    public Republican (String buddy)
    {
        this.buddy=buddy;
    }
    public String getGolfBuddy() {
        return buddy;
    }

}
