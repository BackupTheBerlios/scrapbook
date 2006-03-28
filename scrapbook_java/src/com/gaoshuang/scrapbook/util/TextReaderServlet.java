package com.gaoshuang.scrapbook.util;
import javax.servlet.*;
import javax.servlet.http.*;
import java.io.*;

public class TextReaderServlet extends HttpServlet {

    public void doGet(HttpServletRequest req, HttpServletResponse res)
        throws IOException, ServletException
    {
        // output an HTML page
        res.setContentType("text/html");

        // load a configuration parameter (you must set this yourself)
        String root = getInitParameter("root");


        // print some html
        //ServletOutputStream out = res.getOutputStream();
        PrintWriter out = res.getWriter() ;

        out.println("<html>");
        out.println("<head><title>Log of the Day</title></head>");
        out.println("<body><h1>Today's Message:</h1>");

        // print the file
        InputStream in = null;
        try {
            in = new BufferedInputStream
                (new FileInputStream(root + "/message.txt") );
            int ch;
            while ((ch = in.read()) !=-1) {
                out.print((char)ch);
            }
        }
        finally {
            if (in != null) in.close();  // very important
        }

        // finish up
        out.println("</body></html>");
    }
}