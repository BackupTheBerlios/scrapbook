//http://www.jroller.com/page/wireframe?entry=eclipse_and_test_driven_development
package com.gaoshuang.scrapbook.playground.tdd;

import junit.framework.TestCase;

public class MyServiceTest extends TestCase
{
    public void testDoSomething() {
        MyService service = new MyService();
        assertNotNull(service.doSomething());
    }
}
