<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `platinum_membership` (
	`platinum_membershipid` int(11) NOT NULL auto_increment,
	`onlineuser_onlineuserid` INT NOT NULL,
	`logo` VARCHAR(255) NOT NULL,
	`image1` VARCHAR(255) NOT NULL,
	`image2` VARCHAR(255) NOT NULL,
	`heading` VARCHAR(255) NOT NULL,
	`text` TINYINT NOT NULL,
	`link` VARCHAR(255) NOT NULL,
	`dt_created` BIGINT NOT NULL,
	`platinum_membership_status` ENUM('temp','active','disabled') NOT NULL, PRIMARY KEY  (`platinum_membershipid`));
*/

/**
* <b>Platinum_membership</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 2.6.3 / PHP4
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php4&wrapper=pog&objectName=Platinum_membership&attributeList=array+%28%0A++0+%3D%3E+%27onlineuser_onlineuserid%27%2C%0A++1+%3D%3E+%27logo%27%2C%0A++2+%3D%3E+%27image1%27%2C%0A++3+%3D%3E+%27image2%27%2C%0A++4+%3D%3E+%27heading%27%2C%0A++5+%3D%3E+%27text%27%2C%0A++6+%3D%3E+%27link%27%2C%0A++7+%3D%3E+%27dt_created%27%2C%0A++8+%3D%3E+%27platinum_membership_status%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27INT%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++2+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++3+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++4+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++5+%3D%3E+%27TINYINT%27%2C%0A++6+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++7+%3D%3E+%27BIGINT%27%2C%0A++8+%3D%3E+%27ENUM%28%5C%5C%5C%27temp%5C%5C%5C%27%2C%5C%5C%5C%27active%5C%5C%5C%27%2C%5C%5C%5C%27disabled%5C%5C%5C%27%29%27%2C%0A%29
*/
class Platinum_membership
{
	var $platinum_membershipId = '';

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
	var $image1;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $image2;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $heading;
	
	/**
	 * @var TINYINT
	 */
	var $text;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $link;
	
	/**
	 * @var BIGINT
	 */
	var $dt_created;
	
	/**
	 * @var ENUM('temp','active','disabled')
	 */
	var $platinum_membership_status;
	
	var $pog_attribute_type = array(
		"platinum_membershipId" => array("NUMERIC", "INT"),
		"onlineuser_onlineuserid" => array("NUMERIC", "INT"),
		"logo" => array("TEXT", "VARCHAR", "255"),
		"image1" => array("TEXT", "VARCHAR", "255"),
		"image2" => array("TEXT", "VARCHAR", "255"),
		"heading" => array("TEXT", "VARCHAR", "255"),
		"text" => array("NUMERIC", "TINYINT"),
		"link" => array("TEXT", "VARCHAR", "255"),
		"dt_created" => array("NUMERIC", "BIGINT"),
		"platinum_membership_status" => array("SET", "ENUM", "'temp','active','disabled'"),
		);
	var $pog_query;
	
	function Platinum_membership($onlineuser_onlineuserid='', $logo='', $image1='', $image2='', $heading='', $text='', $link='', $dt_created='', $platinum_membership_status='')
	{
		$this->onlineuser_onlineuserid = $onlineuser_onlineuserid;
		$this->logo = $logo;
		$this->image1 = $image1;
		$this->image2 = $image2;
		$this->heading = $heading;
		$this->text = $text;
		$this->link = $link;
		$this->dt_created = $dt_created;
		$this->platinum_membership_status = $platinum_membership_status;
	}
	

	
	
	/**
	* Gets object from database
	* @param integer $platinum_membershipId 
	* @return object $Platinum_membership
	*/
	function Get($platinum_membershipId)
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select * from `platinum_membership` where `platinum_membershipid`='".intval($platinum_membershipId)."' LIMIT 1";
		$Database->Query($this->pog_query);
		return $this->populate($Database);
	}
	
	function populate($Database, $i=0)
	{
		$thisObjectName = get_class($this);
		$newObject = new $thisObjectName();
		$newObject->platinum_membershipId = $Database->Result($i, "platinum_membershipid");
		$newObject->onlineuser_onlineuserid = $Database->Unescape($Database->Result($i, "onlineuser_onlineuserid"));
		$newObject->logo = $Database->Unescape($Database->Result($i, "logo"));
		$newObject->image1 = $Database->Unescape($Database->Result($i, "image1"));
		$newObject->image2 = $Database->Unescape($Database->Result($i, "image2"));
		$newObject->heading = $Database->Unescape($Database->Result($i, "heading"));
		$newObject->text = $Database->Unescape($Database->Result($i, "text"));
		$newObject->link = $Database->Unescape($Database->Result($i, "link"));
		$newObject->dt_created = $Database->Unescape($Database->Result($i, "dt_created"));
		$newObject->platinum_membership_status = $Database->Result($i, "platinum_membership_status");
		return $newObject;
	}		
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $platinum_membershipList
	*/
	function GetList($fcv_array, $sortBy='', $ascending=true, $limit='')
	{
		$sqlLimit = ($limit != '' && $sortBy == ''?"LIMIT $limit":'');
		if (sizeof($fcv_array) > 0)
		{
			$platinum_membershipList = Array();
			$Database = new DatabaseConnection();
			$this->pog_query = "select * from `platinum_membership` where ";
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
			$this->pog_query .= " order by platinum_membershipid asc $sqlLimit";
			$Database->Query($this->pog_query);

			for ($i=0; $i < $Database->Rows(); $i++)
			{
				$platinum_membershipList[] = $this->populate($Database, $i);
			}
			if ($sortBy != '')
			{
				$f = '';
				$platinum_membership = new Platinum_membership();
				if (isset($platinum_membership->pog_attribute_type[$sortBy]) && ($platinum_membership->pog_attribute_type[$sortBy][0] == "NUMERIC" || $platinum_membership->pog_attribute_type[$sortBy][0] == "SET"))
				{
					$f = 'return $platinum_membership1->'.$sortBy.' > $platinum_membership2->'.$sortBy.';';
				}
				else if (isset($platinum_membership->pog_attribute_type[$sortBy]))
				{
					$f = 'return strcmp(strtolower($platinum_membership1->'.$sortBy.'), strtolower($platinum_membership2->'.$sortBy.'));';
				}
				usort($platinum_membershipList, create_function('$platinum_membership1, $platinum_membership2', $f));
				if (!$ascending)
				{
					$platinum_membershipList = array_reverse($platinum_membershipList);
				}
				if ($limit != '')
				{
					$limitParts = explode(',', $limit);
					if (sizeof($limitParts) > 1)
					{
						return array_slice($platinum_membershipList, $limitParts[0], $limitParts[1]);
					}
					else
					{
						return array_slice($platinum_membershipList, 0, $limit);
					}
				}
			}
			return $platinum_membershipList;
		}
		return null;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $platinum_membershipId
	*/
	function Save()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select `platinum_membershipid` from `platinum_membership` where `platinum_membershipid`='".$this->platinum_membershipId."' LIMIT 1";
		$Database->Query($this->pog_query);
		if ($Database->Rows() > 0)
		{
			$this->pog_query = "update `platinum_membership` set 
			`onlineuser_onlineuserid`='".$Database->Escape($this->onlineuser_onlineuserid)."', 
			`logo`='".$Database->Escape($this->logo)."', 
			`image1`='".$Database->Escape($this->image1)."', 
			`image2`='".$Database->Escape($this->image2)."', 
			`heading`='".$Database->Escape($this->heading)."', 
			`text`='".$Database->Escape($this->text)."', 
			`link`='".$Database->Escape($this->link)."', 
			`dt_created`='".$Database->Escape($this->dt_created)."', 
			`platinum_membership_status`='".$this->platinum_membership_status."' where `platinum_membershipid`='".$this->platinum_membershipId."'";
		}
		else
		{
			$this->pog_query = "insert into `platinum_membership` (`onlineuser_onlineuserid`, `logo`, `image1`, `image2`, `heading`, `text`, `link`, `dt_created`, `platinum_membership_status` ) values (
			'".$Database->Escape($this->onlineuser_onlineuserid)."', 
			'".$Database->Escape($this->logo)."', 
			'".$Database->Escape($this->image1)."', 
			'".$Database->Escape($this->image2)."', 
			'".$Database->Escape($this->heading)."', 
			'".$Database->Escape($this->text)."', 
			'".$Database->Escape($this->link)."', 
			'".$Database->Escape($this->dt_created)."', 
			'".$this->platinum_membership_status."' )";
		}
		$Database->InsertOrUpdate($this->pog_query);
		if ($this->platinum_membershipId == "")
		{
			$this->platinum_membershipId = $Database->GetCurrentId();
		}
		return $this->platinum_membershipId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $platinum_membershipId
	*/
	function SaveNew()
	{
		$this->platinum_membershipId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "delete from `platinum_membership` where `platinum_membershipid`='".$this->platinum_membershipId."'";
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
			$pog_query = "delete from `platinum_membership` where ";
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