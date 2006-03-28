/*
 * ForceDownloadServlet.java
 *http://www.experts-exchange.com/Web/Web_Languages/JSP/Q_20842012.html
 * Created on 09 July 2005, 12:18
 */

package com.gaoshuang.scrapbook.util;

import java.io.*;
import java.net.*;

import javax.servlet.*;
import javax.servlet.http.*;

/**
 *
 * @author seangao
 * @version
 */
public class ForceDownloadServlet extends HttpServlet {
    
    private static final String basePath = "/doc";
    
    /** Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
     * @param request servlet request
     * @param response servlet response
     *Force donload an exsiting file
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        String filePath = request.getPathInfo();
        String filename = request.getParameter( "filename" );
        if( filePath == null && filename != null ) filePath = "/" + filename;
        if( filename == null ) filename = filePath;
        if( filename != null ) filename = (new File(filename)).getName();
        
        if( filePath != null ) {
            InputStream in = null;
            OutputStream out = null;
            try {
                in = getServletContext().getResourceAsStream(basePath + filePath);
                if( in != null ) {
                    out = new BufferedOutputStream( response.getOutputStream() );
                    in = new BufferedInputStream( in );
                    String contentType = "application/unknow"; //or "application/octet-stream"
                    System.out.println( "contentType: " + contentType );
                    response.setHeader("Content-Disposition","attachment; filename=\"" + filename + "\"");
                    int c; while( ( c=in.read() ) != -1 ) out.write( c );
                    return;
                }
            } finally {
                if( in != null ) try { in.close(); } catch( Exception e ) {}
                if( out != null ) try { out.close(); } catch( Exception e ) {}
            }
        }
        response.sendError( HttpServletResponse.SC_NOT_FOUND );
    }
    
    
// <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /** Handles the HTTP <code>GET</code> method.
     * @param request servlet request
     * @param response servlet response
     */
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        processRequest(request, response);
    }
    
    /** Handles the HTTP <code>POST</code> method.
     * @param request servlet request
     * @param response servlet response
     */
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        processRequest(request, response);
    }
    
    /** Returns a short description of the servlet.
     */
    public String getServletInfo() {
        return "Force Download";
    }
// </editor-fold>
}
