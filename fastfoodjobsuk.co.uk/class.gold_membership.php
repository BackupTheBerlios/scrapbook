<?php
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
	var $gold_membership_status;
	
	var $pog_attribute_type = array(
		"gold_membershipId" => array("NUMERIC", "INT"),
		"onlineuser_onlineuserid" => array("NUMERIC", "INT"),
		"logo" => array("TEXT", "VARCHAR", "255"),
		"name" => array("TEXT", "VARCHAR", "255"),
		"description" => array("TEXT", "TEXT"),
		"link" => array("TEXT", "VARCHAR", "255"),
		"tel" => array("TEXT", "VARCHAR", "45"),
		"dt_created" => array("NUMERIC", "TIMESTAMP"),
		"dt_expire" => array("NUMERIC", "DATE"),
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
		$newObject->dt_expire = $Database->Unescape($Database->Result($i, "dt_expire"));			
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
			`dt_expire`='".$Database->Escape($this->dt_expire)."', 			
			`gold_membership_status`='".$this->gold_membership_status."' where `gold_membershipid`='".$this->gold_membershipId."'";
		}
		else
		{
			$this->pog_query = "insert into `gold_membership` (`onlineuser_onlineuserid`, `logo`, `name`, `description`, `link`, `tel`, `dt_expire`, `gold_membership_status` ) values (
			'".$Database->Escape($this->onlineuser_onlineuserid)."', 
			'".$Database->Escape($this->logo)."', 
			'".$Database->Escape($this->name)."', 
			'".$Database->Escape($this->description)."', 
			'".$Database->Escape($this->link)."', 
			'".$Database->Escape($this->tel)."', 
			'0000-00-00', 
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
	
  function hasSpotlight(){
    $db=new DatabaseConnection();
    $result=$db->Query("SELECT spotlightid FROM spotlight WHERE membershipid='".$this->gold_membershipId."' AND spotlight_type='gold_membership'");
    if ($db->Rows()>0){
      $id=mysql_fetch_row($result);
      return $id[0];
    }	else {
      return false;
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
