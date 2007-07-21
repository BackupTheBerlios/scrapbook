<?php
class Franchise
{
	var $franchiseId = '';

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
	var $town;
	
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
	 * @var VARCHAR(255)
	 */
	var $tel;
	
	/**
	 * @var timestamp
	 */
	var $dt_created;
	
	/**
	 * @var date
	 */
	var $dt_expire;
	
	/**
	 * @var ENUM('temp','active','disabled')
	 */
	var $franchise_status;
	
	var $pog_attribute_type = array(
		"franchiseId" => array("NUMERIC", "INT"),
		"onlineuser_onlineuserid" => array("NUMERIC", "INT"),
		"logo" => array("TEXT", "VARCHAR", "255"),
		"town" => array("TEXT", "VARCHAR", "255"),
		"name" => array("TEXT", "VARCHAR", "255"),
		"description" => array("TEXT", "TEXT"),
		"link" => array("TEXT", "VARCHAR", "255"),
		"tel" => array("TEXT", "VARCHAR", "255"),
		"dt_created" => array("NUMERIC", "TIMESTAMP"),
		"dt_expire" => array("NUMERIC", "DATE"),
		"franchise_status" => array("SET", "ENUM", "'temp','active','disabled'"),
		);
	var $pog_query;
	
	function Franchise($onlineuser_onlineuserid='', $logo='', $town='', $name='', $description='', $link='', $tel='', $dt_created='', $franchise_status='')
	{
		$this->onlineuser_onlineuserid = $onlineuser_onlineuserid;
		$this->logo = $logo;
		$this->town = $town;
		$this->name = $name;
		$this->description = $description;
		$this->link = $link;
		$this->tel = $tel;
		$this->dt_created = $dt_created;
		$this->franchise_status = $franchise_status;
	}
	
	
	/**
	* Gets object from database
	* @param integer $franchiseId 
	* @return object $Franchise
	*/
	function Get($franchiseId)
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select * from `franchise` where `franchiseid`='".intval($franchiseId)."' LIMIT 1";
		$Database->Query($this->pog_query);
		return $this->populate($Database);
	}
	
	function populate($Database, $i=0)
	{
		$thisObjectName = get_class($this);
		$newObject = new $thisObjectName();
		$newObject->franchiseId = $Database->Result($i, "franchiseid");
		$newObject->onlineuser_onlineuserid = $Database->Unescape($Database->Result($i, "onlineuser_onlineuserid"));
		$newObject->logo = $Database->Unescape($Database->Result($i, "logo"));
		$newObject->town = $Database->Unescape($Database->Result($i, "town"));
		$newObject->name = $Database->Unescape($Database->Result($i, "name"));
		$newObject->description = $Database->Unescape($Database->Result($i, "description"));
		$newObject->link = $Database->Unescape($Database->Result($i, "link"));
		$newObject->tel = $Database->Unescape($Database->Result($i, "tel"));
		$newObject->dt_created = $Database->Unescape($Database->Result($i, "dt_created"));
		$newObject->dt_expire = $Database->Unescape($Database->Result($i, "dt_expire"));			
		$newObject->franchise_status = $Database->Result($i, "franchise_status");
		return $newObject;

	}
	

	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $franchiseList
	*/
	function GetList($fcv_array, $sortBy='', $ascending=true, $limit='')
	{
		$sqlLimit = ($limit != '' && $sortBy == ''?"LIMIT $limit":'');
		if (sizeof($fcv_array) > 0)
		{
			$franchiseList = Array();
			$Database = new DatabaseConnection();
			$this->pog_query = "select * from `franchise` where ";
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
			$this->pog_query .= " order by franchiseid asc $sqlLimit";
			$Database->Query($this->pog_query);
	
			for ($i=0; $i < $Database->Rows(); $i++)
			{
				$franchiseList[] = $this->populate($Database, $i);
			}
			if ($sortBy != '')
			{
				$f = '';
				$franchise = new Franchise();
				if (isset($franchise->pog_attribute_type[$sortBy]) && ($franchise->pog_attribute_type[$sortBy][0] == "NUMERIC" || $franchise->pog_attribute_type[$sortBy][0] == "SET"))
				{
					$f = 'return $franchise1->'.$sortBy.' > $franchise2->'.$sortBy.';';
				}
				else if (isset($franchise->pog_attribute_type[$sortBy]))
				{
					$f = 'return strcmp(strtolower($franchise1->'.$sortBy.'), strtolower($franchise2->'.$sortBy.'));';
				}
				usort($franchiseList, create_function('$franchise1, $franchise2', $f));
				if (!$ascending)
				{
					$franchiseList = array_reverse($franchiseList);
				}
				if ($limit != '')
				{
					$limitParts = explode(',', $limit);
					if (sizeof($limitParts) > 1)
					{
						return array_slice($franchiseList, $limitParts[0], $limitParts[1]);
					}
					else
					{
						return array_slice($franchiseList, 0, $limit);
					}
				}
			}
			return $franchiseList;
		}
		return null;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $franchiseId
	*/
	function Save()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select `franchiseid` from `franchise` where `franchiseid`='".$this->franchiseId."' LIMIT 1";
		$Database->Query($this->pog_query);
		if ($Database->Rows() > 0)
		{
			$this->pog_query = "update `franchise` set 
			`onlineuser_onlineuserid`='".$Database->Escape($this->onlineuser_onlineuserid)."', 
			`logo`='".$Database->Escape($this->logo)."', 
			`town`='".$Database->Escape($this->town)."', 
			`name`='".$Database->Escape($this->name)."', 
			`description`='".$Database->Escape($this->description)."', 
			`link`='".$Database->Escape($this->link)."', 
			`tel`='".$Database->Escape($this->tel)."', 
			`dt_created`='".$Database->Escape($this->dt_created)."',
			`dt_expire`='".$Database->Escape($this->dt_expire)."', 			 
			`franchise_status`='".$this->franchise_status."' where `franchiseid`='".$this->franchiseId."'";
		}
		else
		{
			$this->pog_query = "insert into `franchise` (`onlineuser_onlineuserid`, `logo`, `town`, `name`, `description`, `link`, `tel`, `dt_expire`, `franchise_status` ) values (
			'".$Database->Escape($this->onlineuser_onlineuserid)."', 
			'".$Database->Escape($this->logo)."', 
			'".$Database->Escape($this->town)."', 
			'".$Database->Escape($this->name)."', 
			'".$Database->Escape($this->description)."', 
			'".$Database->Escape($this->link)."', 
			'".$Database->Escape($this->tel)."', 
			'0000-00-00', 
			'".$this->franchise_status."' )";
		}
		$Database->InsertOrUpdate($this->pog_query);
		if ($this->franchiseId == "")
		{
			$this->franchiseId = $Database->GetCurrentId();
		}
		return $this->franchiseId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $franchiseId
	*/
	function SaveNew()
	{
		$this->franchiseId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "delete from `franchise` where `franchiseid`='".$this->franchiseId."'";
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
			$pog_query = "delete from `franchise` where ";
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
	function updateExpiry($numberDays=''){
    $db=new DatabaseConnection();
    $className=strtolower(get_class($this));
    $classId=$className."Id";
    
    $expiry=( $numberDays=="" ? expiryDate() : expiryDate($numberDays) );
    
    $query="UPDATE $className SET dt_expire='$expiry' WHERE ".$className."id='".$this->$classId."'";
    $result=$db->Query($query);
    return $result;
	}
}
?>
