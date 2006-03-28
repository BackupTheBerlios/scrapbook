package com.gaoshuang.scrapbook.playground.pattern.visitor;

public interface PoliticianVisitor
{
    public void visit(Democrat dem);
    public void visit(Republican rep);

}
