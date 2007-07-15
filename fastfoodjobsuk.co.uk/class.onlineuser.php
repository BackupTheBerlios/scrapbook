<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `onlineuser` (
	`onlineuserid` int(11) NOT NULL auto_increment,
	`email` VARCHAR(45) NOT NULL,
	`first_name` VARCHAR(45) NOT NULL,
	`last_name` VARCHAR(45) NOT NULL,
	`pass_word` VARCHAR(45) NOT NULL,
	`address_1` VARCHAR(255) NOT NULL,
	`address_2` VARCHAR(255) NOT NULL,
	`address_3` VARCHAR(255) NOT NULL,
	`postcode` VARCHAR(20) NOT NULL,
	`tel` VARCHAR(45) NOT NULL,
	`fax` VARCHAR(45) NOT NULL,
	`dt_created` BIGINT NOT NULL,
	`user_status` ENUM('temp','active','disabled') NOT NULL, PRIMARY KEY  (`onlineuserid`));
*/

/**
* <b>OnlineUser</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 2.6.3 / PHP4
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php4&wrapper=pog&objectName=OnlineUser&attributeList=array+%28%0A++0+%3D%3E+%27email%27%2C%0A++1+%3D%3E+%27first_name%27%2C%0A++2+%3D%3E+%27last_name%27%2C%0A++3+%3D%3E+%27pass_word%27%2C%0A++4+%3D%3E+%27address_1%27%2C%0A++5+%3D%3E+%27address_2%27%2C%0A++6+%3D%3E+%27address_3%27%2C%0A++7+%3D%3E+%27postcode%27%2C%0A++8+%3D%3E+%27tel%27%2C%0A++9+%3D%3E+%27fax%27%2C%0A++10+%3D%3E+%27dt_created%27%2C%0A++11+%3D%3E+%27user_status%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%2845%29%27%2C%0A++1+%3D%3E+%27VARCHAR%2845%29%27%2C%0A++2+%3D%3E+%27VARCHAR%2845%29%27%2C%0A++3+%3D%3E+%27VARCHAR%2845%29%27%2C%0A++4+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++5+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++6+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++7+%3D%3E+%27VARCHAR%2820%29%27%2C%0A++8+%3D%3E+%27VARCHAR%2845%29%27%2C%0A++9+%3D%3E+%27VARCHAR%2845%29%27%2C%0A++10+%3D%3E+%27BIGINT%27%2C%0A++11+%3D%3E+%27ENUM%28%5C%5C%5C%27temp%5C%5C%5C%27%2C%5C%5C%5C%27active%5C%5C%5C%27%2C%5C%5C%5C%27disabled%5C%5C%5C%27%29%27%2C%0A%29
*/
class OnlineUser
{
	var $onlineuserId = '';

	/**
	 * @var VARCHAR(45)
	 */
	var $email;
	
	/**
	 * @var VARCHAR(45)
	 */
	var $first_name;
	
	/**
	 * @var VARCHAR(45)
	 */
	var $last_name;
	
	/**
	 * @var VARCHAR(45)
	 */
	var $pass_word;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $address_1;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $address_2;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $address_3;
	
	/**
	 * @var VARCHAR(20)
	 */
	var $postcode;
	
	/**
	 * @var VARCHAR(45)
	 */
	var $tel;
	
	/**
	 * @var VARCHAR(45)
	 */
	var $fax;
	
	/**
	 * @var BIGINT
	 */
	var $dt_created;
	
	/**
	 * @var ENUM('temp','active','disabled')
	 */
	var $user_status;
	
	var $pog_attribute_type = array(
		"onlineuserId" => array("NUMERIC", "INT"),
		"email" => array("TEXT", "VARCHAR", "45"),
		"first_name" => array("TEXT", "VARCHAR", "45"),
		"last_name" => array("TEXT", "VARCHAR", "45"),
		"pass_word" => array("TEXT", "VARCHAR", "45"),
		"address_1" => array("TEXT", "VARCHAR", "255"),
		"address_2" => array("TEXT", "VARCHAR", "255"),
		"address_3" => array("TEXT", "VARCHAR", "255"),
		"postcode" => array("TEXT", "VARCHAR", "20"),
		"tel" => array("TEXT", "VARCHAR", "45"),
		"fax" => array("TEXT", "VARCHAR", "45"),
		"dt_created" => array("NUMERIC", "BIGINT"),
		"user_status" => array("SET", "ENUM", "'temp','active','disabled'"),
		);
	var $pog_query;
	
	function OnlineUser($email='', $first_name='', $last_name='', $pass_word='', $address_1='', $address_2='', $address_3='', $postcode='', $tel='', $fax='', $dt_created='', $user_status='')
	{
		$this->email = $email;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->pass_word = $pass_word;
		$this->address_1 = $address_1;
		$this->address_2 = $address_2;
		$this->address_3 = $address_3;
		$this->postcode = $postcode;
		$this->tel = $tel;
		$this->fax = $fax;
		$this->dt_created = $dt_created;
		$this->user_status = $user_status;
	}
	
	
	/**
	* Gets object from database
	* @param integer $onlineuserId 
	* @return object $OnlineUser
	*/
	function Get($onlineuserId)
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select * from `onlineuser` where onlineuserid='".(int)$onlineuserId."' LIMIT 1";
		$Database->Query($this->pog_query);
		return $this->populate($Database);
	}
	
	function populate($Database, $i=0)
	{
		$thisObjectName = get_class($this);
		$newObject = new $thisObjectName();
		$newObject->onlineuserId = $Database->Result($i, "onlineuserid");
		$newObject->email = $Database->Unescape($Database->Result($i, "email"));
		$newObject->first_name = $Database->Unescape($Database->Result($i, "first_name"));
		$newObject->last_name = $Database->Unescape($Database->Result($i, "last_name"));
		$newObject->pass_word = $Database->Unescape($Database->Result($i, "pass_word"));
		$newObject->address_1 = $Database->Unescape($Database->Result($i, "address_1"));
		$newObject->address_2 = $Database->Unescape($Database->Result($i, "address_2"));
		$newObject->address_3 = $Database->Unescape($Database->Result($i, "address_3"));
		$newObject->postcode = $Database->Unescape($Database->Result($i, "postcode"));
		$newObject->tel = $Database->Unescape($Database->Result($i, "tel"));
		$newObject->fax = $Database->Unescape($Database->Result($i, "fax"));
		$newObject->dt_created = $Database->Unescape($Database->Result($i, "dt_created"));
		$newObject->user_status = $Database->Unescape($Database->Result($i, "user_status"));
    return $newObject;
	}	
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $onlineuserList
	*/
	function GetList($fcv_array, $sortBy='', $ascending=true, $limit='')
	{
		$sqlLimit = ($limit != '' && $sortBy == ''?"LIMIT $limit":'');
		if (sizeof($fcv_array) > 0)
		{
			$onlineuserList = Array();
			$Database = new DatabaseConnection();
			$this->pog_query = "select * from `onlineuser` where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$this->pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) != 1)
					{
						$this->pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]) && $this->pog_attribute_type[$fcv_array[$i][0]][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]][0] != 'SET')
					{
						$this->pog_query .= "`".strtolower($fcv_array[$i][0])."` ".$fcv_array[$i][1]." '".$Database->Escape($fcv_array[$i][2])."'";
					}
					else
					{
						$this->pog_query .= "`".strtolower($fcv_array[$i][0])."` ".$fcv_array[$i][1]." '".$fcv_array[$i][2]."'";
					}
				}
			}
			$this->pog_query .= " order by onlineuserid asc $sqlLimit";
			$Database->Query($this->pog_query);
			
			for ($i=0; $i < $Database->Rows(); $i++)
			{
				$onlineuserList[] = $this->populate($Database, $i);
			}
			if ($sortBy != '')
			{
				$f = '';
				$onlineuser = new OnlineUser();
				if (isset($onlineuser->pog_attribute_type[$sortBy]) && ($onlineuser->pog_attribute_type[$sortBy][0] == "NUMERIC" || $onlineuser->pog_attribute_type[$sortBy][0] == "SET"))
				{
					$f = 'return $onlineuser1->'.$sortBy.' > $onlineuser2->'.$sortBy.';';
				}
				else if (isset($onlineuser->pog_attribute_type[$sortBy]))
				{
					$f = 'return strcmp(strtolower($onlineuser1->'.$sortBy.'), strtolower($onlineuser2->'.$sortBy.'));';
				}
				usort($onlineuserList, create_function('$onlineuser1, $onlineuser2', $f));
				if (!$ascending)
				{
					$onlineuserList = array_reverse($onlineuserList);
				}
				if ($limit != '')
				{
					$limitParts = explode(',', $limit);
					if (sizeof($limitParts) > 1)
					{
						return array_slice($onlineuserList, $limitParts[0], $limitParts[1]);
					}
					else
					{
						return array_slice($onlineuserList, 0, $limit);
					}
				}
			}
			return $onlineuserList;
		}
		return null;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $onlineuserId
	*/
	function Save($updatePassword=false)
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select `onlineuserid` from `onlineuser` where `onlineuserid`='".$this->onlineuserId."' LIMIT 1";
		$Database->Query($this->pog_query);
		
		if ($Database->Rows() > 0) //update
		{
			$password=$this->pass_word;
			if ($updatePassword)
				$password=PASSWORD($password);
			$this->pog_query = "update `onlineuser` set 
			`email`='".$Database->Escape($this->email)."', 
			`first_name`='".$Database->Escape($this->first_name)."', 
			`last_name`='".$Database->Escape($this->last_name)."', 
			`pass_word`='".$password."', 
			`address_1`='".$Database->Escape($this->address_1)."', 
			`address_2`='".$Database->Escape($this->address_2)."', 
			`address_3`='".$Database->Escape($this->address_3)."', 
			`postcode`='".$Database->Escape($this->postcode)."', 
			`tel`='".$Database->Escape($this->tel)."', 
			`fax`='".$Database->Escape($this->fax)."', 
			`dt_created`='".$Database->Escape($this->dt_created)."', 
			`user_status`='".$this->user_status."' where `onlineuserid`='".$this->onlineuserId."'";
		}
		else
		{
			$this->pog_query = "insert into `onlineuser` (`email`, `first_name`, `last_name`, `pass_word`, `address_1`, `address_2`, `address_3`, `postcode`, `tel`, `fax`, `dt_created`, `user_status` ) values (
			'".$Database->Escape($this->email)."', 
			'".$Database->Escape($this->first_name)."', 
			'".$Database->Escape($this->last_name)."', 
			PASSWORD('".$this->pass_word."'), 
			'".$Database->Escape($this->address_1)."', 
			'".$Database->Escape($this->address_2)."', 
			'".$Database->Escape($this->address_3)."', 
			'".$Database->Escape($this->postcode)."', 
			'".$Database->Escape($this->tel)."', 
			'".$Database->Escape($this->fax)."', 
			'".$Database->Escape($this->dt_created)."', 
			'".$this->user_status."' )";
		}
		$Database->InsertOrUpdate($this->pog_query);
		if ($this->onlineuserId == "")
		{
			$this->onlineuserId = $Database->GetCurrentId();
		}
		return $this->onlineuserId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $onlineuserId
	*/
	function SaveNew()
	{
		$this->onlineuserId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "delete from `onlineuser` where `onlineuserid`='".$this->onlineuserId."'";
		return $Database->Query($this->pog_query);
	}
	
	
	/**
	* Deletes a list of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param bool $deep 
	* @return 
	*/
	function DeleteList($fcv_array)
	{
		if (sizeof($fcv_array) > 0)
		{
			$Database = new DatabaseConnection();
			$pog_query = "delete from `onlineuser` where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) !== 1)
					{
						$pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]) && $this->pog_attribute_type[$fcv_array[$i][0]][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]][0] != 'SET')
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$Database->Escape($fcv_array[$i][2])."'";
					}
					else
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$fcv_array[$i][2]."'";
					}
				}
			}
			return $Database->Query($pog_query);
		}
	}
}
?>