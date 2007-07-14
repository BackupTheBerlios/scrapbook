<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `gold_membership` (
	`gold_membershipid` int(11) NOT NULL auto_increment,
	`onlineuser_onlineuserid` INT NOT NULL,
	`logo` VARCHAR(255) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`description` TEXT NOT NULL,
	`link` VARCHAR(255) NOT NULL,
	`tel` VARCHAR(45) NOT NULL,
	`dt_created` BIGINT NOT NULL,
	`gold_membership_status` ENUM('temp','active','disabled') NOT NULL, PRIMARY KEY  (`gold_membershipid`));
*/

/**
* <b>Gold_membership</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 2.6.3 / PHP4
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php4&wrapper=pog&objectName=Gold_membership&attributeList=array+%28%0A++0+%3D%3E+%27onlineuser_onlineuserid%27%2C%0A++1+%3D%3E+%27logo%27%2C%0A++2+%3D%3E+%27name%27%2C%0A++3+%3D%3E+%27description%27%2C%0A++4+%3D%3E+%27link%27%2C%0A++5+%3D%3E+%27tel%27%2C%0A++6+%3D%3E+%27dt_created%27%2C%0A++7+%3D%3E+%27gold_membership_status%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27INT%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++2+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++3+%3D%3E+%27TEXT%27%2C%0A++4+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++5+%3D%3E+%27VARCHAR%2845%29%27%2C%0A++6+%3D%3E+%27BIGINT%27%2C%0A++7+%3D%3E+%27ENUM%28%5C%5C%5C%27temp%5C%5C%5C%27%2C%5C%5C%5C%27active%5C%5C%5C%27%2C%5C%5C%5C%27disabled%5C%5C%5C%27%29%27%2C%0A%29
*/
class Gold_membership
{
	var $gold_membershipId = '';

	/**
	 * @var INT
	 */
	var $onlineuser_onlineuserid;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $logo;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $name;
	
	/**
	 * @var TEXT
	 */
	var $description;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $link;
	
	/**
	 * @var VARCHAR(45)
	 */
	var $tel;
	
	/**
	 * @var BIGINT
	 */
	var $dt_created;
	
	/**
	 * @var ENUM('temp','active','disabled')
	 */
	var $gold_membership_status;
	
	var $pog_attribute_type = array(
		"gold_membershipId" => array("NUMERIC", "INT"),
		"onlineuser_onlineuserid" => array("NUMERIC", "INT"),
		"logo" => array("TEXT", "VARCHAR", "255"),
		"name" => array("TEXT", "VARCHAR", "255"),
		"description" => array("TEXT", "TEXT"),
		"link" => array("TEXT", "VARCHAR", "255"),
		"tel" => array("TEXT", "VARCHAR", "45"),
		"dt_created" => array("NUMERIC", "BIGINT"),
		"gold_membership_status" => array("SET", "ENUM", "'temp','active','disabled'"),
		);
	var $pog_query;
	
	function Gold_membership($onlineuser_onlineuserid='', $logo='', $name='', $description='', $link='', $tel='', $dt_created='', $gold_membership_status='')
	{
		$this->onlineuser_onlineuserid = $onlineuser_onlineuserid;
		$this->logo = $logo;
		$this->name = $name;
		$this->description = $description;
		$this->link = $link;
		$this->tel = $tel;
		$this->dt_created = $dt_created;
		$this->gold_membership_status = $gold_membership_status;
	}
	
	
	/**
	* Gets object from database
	* @param integer $gold_membershipId 
	* @return object $Gold_membership
	*/
	function Get($gold_membershipId)
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select * from `gold_membership` where `gold_membershipid`='".intval($gold_membershipId)."' LIMIT 1";
		$Database->Query($this->pog_query);
		return $this->populate($Database);
	}
	
	function populate($Database, $i=0)
	{
		$thisObjectName = get_class($this);
		$newObject = new $thisObjectName();
		$newObject->gold_membershipId = $Database->Result($i, "gold_membershipid");
		$newObject->onlineuser_onlineuserid = $Database->Unescape($Database->Result($i, "onlineuser_onlineuserid"));
		$newObject->logo = $Database->Unescape($Database->Result($i, "logo"));
		$newObject->name = $Database->Unescape($Database->Result($i, "name"));
		$newObject->description = $Database->Unescape($Database->Result($i, "description"));
		$newObject->link = $Database->Unescape($Database->Result($i, "link"));
		$newObject->tel = $Database->Unescape($Database->Result($i, "tel"));
		$newObject->dt_created = $Database->Unescape($Database->Result($i, "dt_created"));
		$newObject->gold_membership_status = $Database->Result($i, "gold_membership_status");
		return $newObject;
	}	
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $gold_membershipList
	*/
	function GetList($fcv_array, $sortBy='', $ascending=true, $limit='')
	{
		$sqlLimit = ($limit != '' && $sortBy == ''?"LIMIT $limit":'');
		if (sizeof($fcv_array) > 0)
		{
			$gold_membershipList = Array();
			$Database = new DatabaseConnection();
			$this->pog_query = "select * from `gold_membership` where ";
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
			$this->pog_query .= " order by gold_membershipid asc $sqlLimit";
			$Database->Query($this->pog_query);

			for ($i=0; $i < $Database->Rows(); $i++)
			{
				$gold_membershipList[] = $this->populate($Database, $i);
			}
			if ($sortBy != '')
			{
				$f = '';
				$gold_membership = new Gold_membership();
				if (isset($gold_membership->pog_attribute_type[$sortBy]) && ($gold_membership->pog_attribute_type[$sortBy][0] == "NUMERIC" || $gold_membership->pog_attribute_type[$sortBy][0] == "SET"))
				{
					$f = 'return $gold_membership1->'.$sortBy.' > $gold_membership2->'.$sortBy.';';
				}
				else if (isset($gold_membership->pog_attribute_type[$sortBy]))
				{
					$f = 'return strcmp(strtolower($gold_membership1->'.$sortBy.'), strtolower($gold_membership2->'.$sortBy.'));';
				}
				usort($gold_membershipList, create_function('$gold_membership1, $gold_membership2', $f));
				if (!$ascending)
				{
					$gold_membershipList = array_reverse($gold_membershipList);
				}
				if ($limit != '')
				{
					$limitParts = explode(',', $limit);
					if (sizeof($limitParts) > 1)
					{
						return array_slice($gold_membershipList, $limitParts[0], $limitParts[1]);
					}
					else
					{
						return array_slice($gold_membershipList, 0, $limit);
					}
				}
			}
			return $gold_membershipList;
		}
		return null;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $gold_membershipId
	*/
	function Save()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select `gold_membershipid` from `gold_membership` where `gold_membershipid`='".$this->gold_membershipId."' LIMIT 1";
		$Database->Query($this->pog_query);
		if ($Database->Rows() > 0)
		{
			$this->pog_query = "update `gold_membership` set 
			`onlineuser_onlineuserid`='".$Database->Escape($this->onlineuser_onlineuserid)."', 
			`logo`='".$Database->Escape($this->logo)."', 
			`name`='".$Database->Escape($this->name)."', 
			`description`='".$Database->Escape($this->description)."', 
			`link`='".$Database->Escape($this->link)."', 
			`tel`='".$Database->Escape($this->tel)."', 
			`dt_created`='".$Database->Escape($this->dt_created)."', 
			`gold_membership_status`='".$this->gold_membership_status."' where `gold_membershipid`='".$this->gold_membershipId."'";
		}
		else
		{
			$this->pog_query = "insert into `gold_membership` (`onlineuser_onlineuserid`, `logo`, `name`, `description`, `link`, `tel`, `dt_created`, `gold_membership_status` ) values (
			'".$Database->Escape($this->onlineuser_onlineuserid)."', 
			'".$Database->Escape($this->logo)."', 
			'".$Database->Escape($this->name)."', 
			'".$Database->Escape($this->description)."', 
			'".$Database->Escape($this->link)."', 
			'".$Database->Escape($this->tel)."', 
			'".$Database->Escape($this->dt_created)."', 
			'".$this->gold_membership_status."' )";
		}
		$Database->InsertOrUpdate($this->pog_query);
		if ($this->gold_membershipId == "")
		{
			$this->gold_membershipId = $Database->GetCurrentId();
		}
		return $this->gold_membershipId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $gold_membershipId
	*/
	function SaveNew()
	{
		$this->gold_membershipId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "delete from `gold_membership` where `gold_membershipid`='".$this->gold_membershipId."'";
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
			$pog_query = "delete from `gold_membership` where ";
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