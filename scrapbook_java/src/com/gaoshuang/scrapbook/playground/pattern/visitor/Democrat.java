package com.gaoshuang.scrapbook.playground.pattern.visitor;

public class Democrat extends Politician
{
    public void accept(PoliticianVisitor visitor) {
        visitor.visit(this);
      }

    String intern;
    public Democrat (String intern)
    {
        this.intern=intern;
    }
    public String getFavoriteIntern() {
        return intern;
    }

}
