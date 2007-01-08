/*
 * Project 		: SECPay Merchant Extranet
 * Copyright:  SECPay Limited. All Rights Reserved.
 * 
 * This software is the proprietary information of SECPay Limited.  
 * Use is subject to license terms.
 */

package com.gaoshuang.scrapbook.tutorial.hibernate.usertype;

import com.secpay.core.entity.RoleType;
/**
* @author Sean Gao
* @since 05-May-2006
*/
public class RoleTypeEnumUserType extends StringEnumUserType<RoleType>
{
    public RoleTypeEnumUserType() { 
        super(RoleType.class); 
    } 
}
