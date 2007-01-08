package test;

import java.io.*;
import java.lang.String;

public class change
{
    public static void main(String arg[])
    {

        //File.list();
        int sign = 0;
        for (int i = 1; i <= 10; i++)
        {
            try
            {
                
                BufferedReader in = new BufferedReader(new FileReader(i+""));
                String str;
                while ((str = in.readLine()) != null)
                {
                    if (sign == 0)
                    {
                        if (!str.equals("An equivalent quantifier-free formula:")) continue;
                        else sign = 1;
                    }
                    else
                    {
                        str = str.replaceAll("\\/\\\\", "&&");
                        str = str.replaceAll("\\[", "(");
                        str = str.replaceAll("]", ")");
                        str = str.replaceAll("\\\\/", "||");
                        try
                        {
                            BufferedWriter out = new BufferedWriter(new FileWriter("output",true));
                            out.write(str);
                            out.close();
                        }
                        catch (IOException e)
                        {
                        }
                    }
                }
                in.close();
            }
            catch (IOException e)
            {
                e.printStackTrace();
            }
        }
    }
}