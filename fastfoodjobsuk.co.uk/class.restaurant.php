<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `restaurant` (
	`restaurantid` int(11) NOT NULL auto_increment,
	`onlineuser_onlineuserid` INT NOT NULL,
	`logo` VARCHAR(255) NOT NULL,
	`name` VARCHAR(45) NOT NULL,
	`description` TEXT NOT NULL,
	`link` VARCHAR(255) NOT NULL,
	`tel` VARCHAR(45) NOT NULL,
	`dt_created` BIGINT NOT NULL,
	`restaurant_status` ENUM('temp','active','disabled') NOT NULL, PRIMARY KEY  (`restaurantid`));
*/

/**
* <b>Restaurant</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 2.6.3 / PHP4
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php4&wrapper=pog&objectName=Restaurant&attributeList=array+%28%0A++0+%3D%3E+%27onlineuser_onlineuserid%27%2C%0A++1+%3D%3E+%27logo%27%2C%0A++2+%3D%3E+%27name%27%2C%0A++3+%3D%3E+%27description%27%2C%0A++4+%3D%3E+%27link%27%2C%0A++5+%3D%3E+%27tel%27%2C%0A++6+%3D%3E+%27dt_created%27%2C%0A++7+%3D%3E+%27restaurant_status%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27INT%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++2+%3D%3E+%27VARCHAR%2845%29%27%2C%0A++3+%3D%3E+%27TEXT%27%2C%0A++4+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++5+%3D%3E+%27VARCHAR%2845%29%27%2C%0A++6+%3D%3E+%27BIGINT%27%2C%0A++7+%3D%3E+%27ENUM%28%5C%5C%5C%27temp%5C%5C%5C%27%2C%5C%5C%5C%27active%5C%5C%5C%27%2C%5C%5C%5C%27disabled%5C%5C%5C%27%29%27%2C%0A%29
*/
class Restaurant
{
	var $restaurantId = '';

	/**
	 * @var INT
	 */
	var $onlineuser_onlineuserid;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $logo;
	
	/**
	 * @var VARCHAR(45)
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
	var $restaurant_status;
	
	var $pog_attribute_type = array(
		"restaurantId" => array("NUMERIC", "INT"),
		"onlineuser_onlineuserid" => array("NUMERIC", "INT"),
		"logo" => array("TEXT", "VARCHAR", "255"),
		"name" => array("TEXT", "VARCHAR", "45"),
		"description" => array("TEXT", "TEXT"),
		"link" => array("TEXT", "VARCHAR", "255"),
		"tel" => array("TEXT", "VARCHAR", "45"),
		"dt_created" => array("NUMERIC", "BIGINT"),
		"restaurant_status" => array("SET", "ENUM", "'temp','active','disabled'"),
		);
	var $pog_query;
	
	function Restaurant($onlineuser_onlineuserid='', $logo='', $name='', $description='', $link='', $tel='', $dt_created='', $restaurant_status='')
	{
		$this->onlineuser_onlineuserid = $onlineuser_onlineuserid;
		$this->logo = $logo;
		$this->name = $name;
		$this->description = $description;
		$this->link = $link;
		$this->tel = $tel;
		$this->dt_created = $dt_created;
		$this->restaurant_status = $restaurant_status;
	}
	
	
	/**
	* Gets object from database
	* @param integer $restaurantId 
	* @return object $Restaurant
	*/
	function Get($restaurantId)
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select * from `restaurant` where `restaurantid`='".intval($restaurantId)."' LIMIT 1";
		$Database->Query($this->pog_query);
		return $this->populate($Database);
	}
	
	function populate($Database, $i=0)
	{
		$thisObjectName = get_class($this);
		$newObject = new $thisObjectName();
		$newObject->restaurantId = $Database->Result($i, "restaurantid");
		$newObject->onlineuser_onlineuserid = $Database->Unescape($Database->Result($i, "onlineuser_onlineuserid"));
		$newObject->logo = $Database->Unescape($Database->Result($i, "logo"));
		$newObject->name = $Database->Unescape($Database->Result($i, "name"));
		$newObject->description = $Database->Unescape($Database->Result($i, "description"));
		$newObject->link = $Database->Unescape($Database->Result($i, "link"));
		$newObject->tel = $Database->Unescape($Database->Result($i, "tel"));
		$newObject->dt_created = $Database->Unescape($Database->Result($i, "dt_created"));
		$newObject->restaurant_status = $Database->Result($i, "restaurant_status");
		return $newObject;
	}		
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $restaurantList
	*/
	function GetList($fcv_array, $sortBy='', $ascending=true, $limit='')
	{
		$sqlLimit = ($limit != '' && $sortBy == ''?"LIMIT $limit":'');
		if (sizeof($fcv_array) > 0)
		{
			$restaurantList = Array();
			$Database = new DatabaseConnection();
			$this->pog_query = "select * from `restaurant` where ";
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
			$this->pog_query .= " order by restaurantid asc $sqlLimit";
			$Database->Query($this->pog_query);

			for ($i=0; $i < $Database->Rows(); $i++)
			{
				$restaurantList[] = $this->populate($Database, $i);
			}
			if ($sortBy != '')
			{
				$f = '';
				$restaurant = new Restaurant();
				if (isset($restaurant->pog_attribute_type[$sortBy]) && ($restaurant->pog_attribute_type[$sortBy][0] == "NUMERIC" || $restaurant->pog_attribute_type[$sortBy][0] == "SET"))
				{
					$f = 'return $restaurant1->'.$sortBy.' > $restaurant2->'.$sortBy.';';
				}
				else if (isset($restaurant->pog_attribute_type[$sortBy]))
				{
					$f = 'return strcmp(strtolower($restaurant1->'.$sortBy.'), strtolower($restaurant2->'.$sortBy.'));';
				}
				usort($restaurantList, create_function('$restaurant1, $restaurant2', $f));
				if (!$ascending)
				{
					$restaurantList = array_reverse($restaurantList);
				}
				if ($limit != '')
				{
					$limitParts = explode(',', $limit);
					if (sizeof($limitParts) > 1)
					{
						return array_slice($restaurantList, $limitParts[0], $limitParts[1]);
					}
					else
					{
						return array_slice($restaurantList, 0, $limit);
					}
				}
			}
			return $restaurantList;
		}
		return null;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $restaurantId
	*/
	function Save()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select `restaurantid` from `restaurant` where `restaurantid`='".$this->restaurantId."' LIMIT 1";
		$Database->Query($this->pog_query);
		if ($Database->Rows() > 0)
		{
			$this->pog_query = "update `restaurant` set 
			`onlineuser_onlineuserid`='".$Database->Escape($this->onlineuser_onlineuserid)."', 
			`logo`='".$Database->Escape($this->logo)."', 
			`name`='".$Database->Escape($this->name)."', 
			`description`='".$Database->Escape($this->description)."', 
			`link`='".$Database->Escape($this->link)."', 
			`tel`='".$Database->Escape($this->tel)."', 
			`dt_created`='".$Database->Escape($this->dt_created)."', 
			`restaurant_status`='".$this->restaurant_status."' where `restaurantid`='".$this->restaurantId."'";
		}
		else
		{
			$this->pog_query = "insert into `restaurant` (`onlineuser_onlineuserid`, `logo`, `name`, `description`, `link`, `tel`, `dt_created`, `restaurant_status` ) values (
			'".$Database->Escape($this->onlineuser_onlineuserid)."', 
			'".$Database->Escape($this->logo)."', 
			'".$Database->Escape($this->name)."', 
			'".$Database->Escape($this->description)."', 
			'".$Database->Escape($this->link)."', 
			'".$Database->Escape($this->tel)."', 
			'".$Database->Escape($this->dt_created)."', 
			'".$this->restaurant_status."' )";
		}
		$Database->InsertOrUpdate($this->pog_query);
		if ($this->restaurantId == "")
		{
			$this->restaurantId = $Database->GetCurrentId();
		}
		return $this->restaurantId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $restaurantId
	*/
	function SaveNew()
	{
		$this->restaurantId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "delete from `restaurant` where `restaurantid`='".$this->restaurantId."'";
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
			$pog_query = "delete from `restaurant` where ";
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