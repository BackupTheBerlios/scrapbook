//http://jroller.com/comments/eu/Weblog/neat_trick_to_reduce_size

package com.gaoshuang.scrapbook.playground;

import java.util.Arrays;

public class EuxxASMStringTrick{
    
  static final String[] OPCODESOLD = {
    "NOP",
    "ACONST_NULL",
    "ICONST_M1", 
    "ICONST_0",
    "ICONST_1",
    "ICONST_2",
    "ICONST_3",
    "ICONST_4",
    "ICONST_5",
    "LCONST_0"
  };   
    
    private static String[] OPCODESGOOD;
    static
    {
        String s = "DNOPLACONST_NULLJICONST_M1IICONST_0IICONST_1"
                + "IICONST_2IICONST_3IICONST_4IICONST_5ILCONST_0";
        
        OPCODESGOOD = new String[11];
        int i = 0;
        int len = 0;
        for (int j = 0; j < s.length(); j += len) {
            len = s.charAt(j++) - 'A';
            OPCODESGOOD[i++] = (len == 0) ? null : s.substring(j, j + len);
            System.out.println(OPCODESGOOD[i-1]);
        }
    }
    
    public static void main(String[] args) {
        System.out.printf(Arrays.toString(OPCODESOLD));
        System.out.printf(Arrays.toString(OPCODESGOOD));
        
    }
    
}
