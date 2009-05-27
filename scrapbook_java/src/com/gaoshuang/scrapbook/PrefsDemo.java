/**
 * 
 */
package com.gaoshuang.scrapbook;

import java.io.FileOutputStream;
import java.util.prefs.BackingStoreException;
import java.util.prefs.Preferences;

/**
 * @author Sean Gao
 * @since 10:11:18 08-Jul-2005
 *
 */
public class PrefsDemo
{
    public static void main(String args[]) 
    { 
      String keys[] = 
        {"sunway","copyright","author"}; 
      String values[] = 
        {"sunway technology company",
      "copyright 2002","turbochen@163.com"}; 

      /* 建立一个位于user root下的
    /com/sunway/spc节点参数项*/ 
      Preferences prefsdemo = 
        Preferences.userRoot()
      .node("/com/sunway/spc"); 

      /* 储存参数项*/ 
      for (int i=0 ; i < keys.length; i++) 
      { 
        prefsdemo.put(keys[i], values[i]); 
      } 

      /* 导出到XML文件 */ 
      try 
      { 
        FileOutputStream fos = new 
      FileOutputStream("prefsdemo.xml"); 
        prefsdemo.exportNode(fos); 
      } catch (Exception e) 
      { 
        System.err.println
      ("Cannot export nodes: " + e); 
      } 

      /* 去掉注释可以清除注册表中的参数项*/ 
      /**/
      try 
        { 
           prefsdemo.removeNode(); 
        } catch (BackingStoreException e) 
        { 
        } /**/ 

    } 
  }
