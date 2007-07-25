<?php
/*
* @link http://www.phpobjectgenerator.com/?language=php4&wrapper=pog&objectName=stats&attributeList=array+%28%0A++0+%3D%3E+%27objectname%27%2C%0A++1+%3D%3E+%27objectid%27%2C%0A++2+%3D%3E+%27impressions%27%2C%0A++3+%3D%3E+%27clicks%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++1+%3D%3E+%27INT%27%2C%0A++2+%3D%3E+%27INT%27%2C%0A++3+%3D%3E+%27INT%27%2C%0A%29
*/
class Stats {

	var $statsId = '';

	/**
	 * @var VARCHAR(255)
	 */
	var $objectname;
	
	/**
	 * @var INT
	 */
	var $objectid;
	
	/**
	 * @var INT
	 */
	var $impressions;
	
	/**
	 * @var INT
	 */
	var $clicks;
	
	var $pog_attribute_type = array(
		"statsId" => array('db_attributes' => array("NUMERIC", "INT")),
		"objectname" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"objectid" => array('db_attributes' => array("NUMERIC", "INT")),
		"impressions" => array('db_attributes' => array("NUMERIC", "INT")),
		"clicks" => array('db_attributes' => array("NUMERIC", "INT")),
		);
	var $pog_query;
	
	
	function Stats($objectname='', $objectid='', $impressions='', $clicks='')
	{
		$this->objectname = $objectname;
		$this->objectid = $objectid;
		$this->impressions = $impressions;
		$this->clicks = $clicks;
	}
	
	
	/**
	* Gets object from database
	* @param integer $statsId 
	* @return object $stats
	*/
	function Get($statsId)
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select * from `stats` where `statsid`='".intval($statsId)."' LIMIT 1";
		$Database->Query($this->pog_query);
		return $this->populate($Database);
	}

	function populate($Database, $i=0)
	{
		$thisObjectName = get_class($this);
		$newObject = new $thisObjectName();
		$newObject->statsId = $Database->Result($i, "statsid");
		$newObject->objectname = $Database->Unescape($Database->Result($i, "objectname"));
		$newObject->objectid = $Database->Unescape($Database->Result($i, "objectid"));
		$newObject->impressions = $Database->Unescape($Database->Result($i, "impressions"));
		$newObject->clicks = $Database->Unescape($Database->Result($i, "clicks"));
		return $newObject;
	}	
	
	
	function GetList($fcv_array, $sortBy='', $ascending=true, $limit='')
	{
		$sqlLimit = ($limit != '' && $sortBy == ''?"LIMIT $limit":'');
		if (sizeof($fcv_array) > 0)
		{
			$statsList = Array();
			$Database = new DatabaseConnection();
			$this->pog_query = "select * from `stats` where ";
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
			$this->pog_query .= " order by statsid asc $sqlLimit";
			$Database->Query($this->pog_query);

			for ($i=0; $i < $Database->Rows(); $i++)
			{
				$statsList[] = $this->populate($Database, $i);
			}
			if ($sortBy != '')
			{
				$f = '';
				$stats = new Stats();
				if (isset($stats->pog_attribute_type[$sortBy]) && ($stats->pog_attribute_type[$sortBy][0] == "NUMERIC" || $stats->pog_attribute_type[$sortBy][0] == "SET"))
				{
					$f = 'return $stats1->'.$sortBy.' > $stats2->'.$sortBy.';';
				}
				else if (isset($stats->pog_attribute_type[$sortBy]))
				{
					$f = 'return strcmp(strtolower($stats1->'.$sortBy.'), strtolower($stats2->'.$sortBy.'));';
				}
				usort($statsList, create_function('$stats1, $stats2', $f));
				if (!$ascending)
				{
					$statsList = array_reverse($statsList);
				}
				if ($limit != '')
				{
					$limitParts = explode(',', $limit);
					if (sizeof($limitParts) > 1)
					{
						return array_slice($statsList, $limitParts[0], $limitParts[1]);
					}
					else
					{
						return array_slice($statsList, 0, $limit);
					}
				}
			}
			return $statsList;
		}
		return null;
	}
	
	/**
	* Saves the object to the database
	* @return integer $statsId
	*/

	function Save()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select `statsid` from `stats` where `statsid`='".$this->statsId."' LIMIT 1";
		$Database->Query($this->pog_query);
		if ($Database->Rows() > 0)
		{
			$this->pog_query = "update `stats` set 
			`objectname`='".$Database->Escape($this->objectname)."', 
			`objectid`='".$Database->Escape($this->objectid)."', 
			`impressions`='".$Database->Escape($this->impressions)."', 
			`clicks`='".$Database->Escape($this->clicks)."' where `statsid`='".$this->statsId."'";
		}
		else
		{
			$this->pog_query = "insert into `stats` (`objectname`, `objectid`, `impressions`, `clicks`) values (
			'".$Database->Escape($this->objectname)."', 
			'".$Database->Escape($this->objectid)."', 
			'".$Database->Escape($this->impressions)."', 
			'".$Database->Escape($this->clicks)."' )";
		}
		$Database->InsertOrUpdate($this->pog_query);
		if ($this->statsId == "")
		{
			$this->statsId = $Database->GetCurrentId();
		}
		return $this->statsId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $statsId
	*/
	function SaveNew()
	{
		$this->statsId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "delete from `stats` where `statsid`='".$this->statsId."'";
		return $Database->Query($this->pog_query);
	}
	
	
}
?>
