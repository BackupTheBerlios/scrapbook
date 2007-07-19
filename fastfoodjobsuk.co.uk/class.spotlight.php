<?php
class Spotlight
{
	var $spotlightId = '';

	/**
	 * @var INT
	 */
	var $membershipId;
	
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
	 * @var TEXT
	 */
	var $text;
	
	var $name;
	var $address;
	var $tel;
	var $fax;
	var $email;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $link;
	
	/**
	 * @var timestamp
	 */
	var $dt_created;
	
	/**
	 * @var ENUM('gold_membership','supplier')
	 */
	var $spotlight_type;
	
	var $pog_attribute_type = array(
		"spotlightId" => array("NUMERIC", "INT"),
		"membershipId" => array("NUMERIC", "INT"),
		"logo" => array("TEXT", "VARCHAR", "255"),
		"image1" => array("TEXT", "VARCHAR", "255"),
		"image2" => array("TEXT", "VARCHAR", "255"),
		"heading" => array("TEXT", "VARCHAR", "255"),
		"text" => array("TEXT", "TEXT"),
		"name" => array("TEXT", "VARCHAR","255"),
		"address" => array("TEXT", "TEXT"),
		"tel" => array("TEXT", "VARCHAR","40"),
		"fax" => array("TEXT", "VARCHAR","40"),
		"email" => array("TEXT", "VARCHAR","255"),
		"link" => array("TEXT", "VARCHAR", "255"),
		"dt_created" => array("NUMERIC", "TIMESTAMP"),
		"spotlight_type" => array("SET", "ENUM", "'gold_membership','supplier'"),
		);
	var $pog_query;
	
	function Spotlight($membershipId='', $logo='', $image1='', $image2='', $heading='', $text='', $name='', $address='', $tel='', $fax='', $email='', $link='', $dt_created='', $spotlight_type='')
	{
		$this->membershipId = $membershipId;
		$this->logo = $logo;
		$this->image1 = $image1;
		$this->image2 = $image2;
		$this->heading = $heading;
		$this->text = $text;
		$this->name=$name;
		$this->address=$address;
		$this->tel=$tel;
		$this->fax=$fax;
		$this->email=$email;
    $this->link = $link;
		$this->dt_created = $dt_created;
		$this->spotlight_type = $spotlight_type;
	}
	

	
	
	/**
	* Gets object from database
	* @param integer $platinum_membershipId 
	* @return object $Platinum_membership
	*/
	function Get($spotlightId)
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select * from `spotlight` where `spotlightid`='".intval($spotlightId)."' LIMIT 1";
		$Database->Query($this->pog_query);
		return $this->populate($Database);
	}
	
	function populate($Database, $i=0)
	{
		$thisObjectName = get_class($this);
		$newObject = new $thisObjectName();
		$newObject->spotlightId = $Database->Result($i, "spotlightid");
		$newObject->membershipId = $Database->Unescape($Database->Result($i, "membershipid"));
		$newObject->logo = $Database->Unescape($Database->Result($i, "logo"));
		$newObject->image1 = $Database->Unescape($Database->Result($i, "image1"));
		$newObject->image2 = $Database->Unescape($Database->Result($i, "image2"));
		$newObject->heading = $Database->Unescape($Database->Result($i, "heading"));
		$newObject->text = $Database->Unescape($Database->Result($i, "text"));
		$newObject->name = $Database->Unescape($Database->Result($i, "name"));
		$newObject->address = $Database->Unescape($Database->Result($i, "address"));
		$newObject->tel = $Database->Unescape($Database->Result($i, "tel"));
		$newObject->fax = $Database->Unescape($Database->Result($i, "fax"));
		$newObject->email = $Database->Unescape($Database->Result($i, "email"));
		$newObject->link = $Database->Unescape($Database->Result($i, "link"));
		$newObject->dt_created = $Database->Unescape($Database->Result($i, "dt_created"));
		$newObject->spotlight_type = $Database->Result($i, "spotlight_type");
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
			$spotlightList = Array();
			$Database = new DatabaseConnection();
			$this->pog_query = "select * from `spotlight` where ";
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
			$this->pog_query .= " order by spotlightid asc $sqlLimit";
			$Database->Query($this->pog_query);

			for ($i=0; $i < $Database->Rows(); $i++)
			{
				$spotlightList[] = $this->populate($Database, $i);
			}
			if ($sortBy != '')
			{
				$f = '';
				$spotlight = new Spotlight();
				if (isset($spotlight->pog_attribute_type[$sortBy]) && ($spotlight->pog_attribute_type[$sortBy][0] == "NUMERIC" || $spotlight->pog_attribute_type[$sortBy][0] == "SET"))
				{
					$f = 'return $spotlight1->'.$sortBy.' > $spotlight2->'.$sortBy.';';
				}
				else if (isset($spotlight->pog_attribute_type[$sortBy]))
				{
					$f = 'return strcmp(strtolower($spotlight1->'.$sortBy.'), strtolower($spotlight2->'.$sortBy.'));';
				}
				usort($spotlightList, create_function('$spotlight1, $spotlight2', $f));
				if (!$ascending)
				{
					$spotlightList = array_reverse($spotlightList);
				}
				if ($limit != '')
				{
					$limitParts = explode(',', $limit);
					if (sizeof($limitParts) > 1)
					{
						return array_slice($spotlightList, $limitParts[0], $limitParts[1]);
					}
					else
					{
						return array_slice($spotlightList, 0, $limit);
					}
				}
			}
			return $spotlightList;
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
		$this->pog_query = "select `spotlightid` from `spotlight` where `spotlightid`='".$this->spotlightId."' LIMIT 1";
		$Database->Query($this->pog_query);
		if ($Database->Rows() > 0)
		{
			$this->pog_query = "update `spotlight` set 
			`membershipId`='".$Database->Escape($this->membershipId)."', 
			`logo`='".$Database->Escape($this->logo)."', 
			`image1`='".$Database->Escape($this->image1)."', 
			`image2`='".$Database->Escape($this->image2)."', 
			`heading`='".$Database->Escape($this->heading)."', 
			`text`='".$Database->Escape($this->text)."', 
			`name`='".$Database->Escape($this->name)."', 
			`address`='".$Database->Escape($this->address)."', 
			`tel`='".$Database->Escape($this->tel)."', 
			`fax`='".$Database->Escape($this->fax)."', 
			`email`='".$Database->Escape($this->email)."', 
			`link`='".$Database->Escape($this->link)."', 
			`dt_created`='".$Database->Escape($this->dt_created)."', 
			`spotlight_type`='".$this->spotlight_type."' where `spotlightid`='".$this->spotlightId."'";
		}
		else
		{
			$this->pog_query = "insert into `spotlight` (`membershipid`, `logo`, `image1`, `image2`, `heading`, `text`, `name`, `address`, `tel`, `fax`, `email`, `link`, `spotlight_type` ) values (
			'".$Database->Escape($this->membershipId)."', 
			'".$Database->Escape($this->logo)."', 
			'".$Database->Escape($this->image1)."', 
			'".$Database->Escape($this->image2)."', 
			'".$Database->Escape($this->heading)."', 
			'".$Database->Escape($this->text)."', 
			'".$Database->Escape($this->name)."', 
			'".$Database->Escape($this->address)."', 
			'".$Database->Escape($this->tel)."', 
			'".$Database->Escape($this->fax)."', 
			'".$Database->Escape($this->email)."', 
			'".$Database->Escape($this->link)."', 
			'".$this->membership_type."' )";
		}
		$Database->InsertOrUpdate($this->pog_query);
		if ($this->spotlightId == "")
		{
			$this->spotlightId = $Database->GetCurrentId();
		}
		return $this->spotlightId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $platinum_membershipId
	*/
	function SaveNew()
	{
		$this->spotlightId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "delete from `spotlight` where `spotlightid`='".$this->spotlightId."'";
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
			$pog_query = "delete from `spotlight` where ";
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
