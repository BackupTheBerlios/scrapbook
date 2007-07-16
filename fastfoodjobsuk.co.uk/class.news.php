<?php
class News
{
	var $newsId = '';

	/**
	 * @var VARCHAR(255)
	 */
	var $heading;
	
	/**
	 * @var TEXT
	 */
	var $description;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $link;
	
	/**
	 * @var TINYINT
	 */
	var $live;
	
	/**
	 * @var timestamp
	 */
	var $dt_created;
	
	/**
	 * @var date
	 */
	var $dt_expire;
	
	var $pog_attribute_type = array(
		"newsId" => array("NUMERIC", "INT"),
		"heading" => array("TEXT", "VARCHAR", "255"),
		"description" => array("TEXT", "TEXT"),
		"link" => array("TEXT", "VARCHAR", "255"),
		"live" => array("NUMERIC", "TINYINT"),
		"dt_created" => array("NUMERIC", "TIMESTAMP"),
		);
	var $pog_query;
	
	function News($heading='', $description='', $link='', $live='', $dt_created='')
	{
		$this->heading = $heading;
		$this->description = $description;
		$this->link = $link;
		$this->live = $live;
		$this->dt_created = $dt_created;
	}
	
	
	/**
	* Gets object from database
	* @param integer $newsId 
	* @return object $News
	*/
	function Get($newsId)
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select * from `news` where `newsid`='".intval($newsId)."' LIMIT 1";
		$Database->Query($this->pog_query);
		return $this->populate($Database);
	}
	
	function populate($Database, $i=0)
	{
		$thisObjectName = get_class($this);
		$newObject = new $thisObjectName();
		$newObject->newsId = $Database->Result($i, "newsid");
		$newObject->heading = $Database->Unescape($Database->Result($i, "heading"));
		$newObject->description = $Database->Unescape($Database->Result($i, "description"));
		$newObject->link = $Database->Unescape($Database->Result($i, "link"));
		$newObject->live = $Database->Unescape($Database->Result($i, "live"));
		$newObject->dt_created = $Database->Unescape($Database->Result($i, "dt_created"));
		return $newObject;
	}	
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $newsList
	*/
	function GetList($fcv_array, $sortBy='', $ascending=true, $limit='')
	{
		$sqlLimit = ($limit != '' && $sortBy == ''?"LIMIT $limit":'');
		if (sizeof($fcv_array) > 0)
		{
			$newsList = Array();
			$Database = new DatabaseConnection();
			$this->pog_query = "select * from `news` where ";
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
			$this->pog_query .= " order by newsid asc $sqlLimit";
			$Database->Query($this->pog_query);

			for ($i=0; $i < $Database->Rows(); $i++)
			{
				$newsList[] = $this->populate($Database, $i);
			}
			if ($sortBy != '')
			{
				$f = '';
				$news = new News();
				if (isset($news->pog_attribute_type[$sortBy]) && ($news->pog_attribute_type[$sortBy][0] == "NUMERIC" || $news->pog_attribute_type[$sortBy][0] == "SET"))
				{
					$f = 'return $news1->'.$sortBy.' > $news2->'.$sortBy.';';
				}
				else if (isset($news->pog_attribute_type[$sortBy]))
				{
					$f = 'return strcmp(strtolower($news1->'.$sortBy.'), strtolower($news2->'.$sortBy.'));';
				}
				usort($newsList, create_function('$news1, $news2', $f));
				if (!$ascending)
				{
					$newsList = array_reverse($newsList);
				}
				if ($limit != '')
				{
					$limitParts = explode(',', $limit);
					if (sizeof($limitParts) > 1)
					{
						return array_slice($newsList, $limitParts[0], $limitParts[1]);
					}
					else
					{
						return array_slice($newsList, 0, $limit);
					}
				}
			}
			return $newsList;
		}
		return null;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $newsId
	*/
	function Save()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select `newsid` from `news` where `newsid`='".$this->newsId."' LIMIT 1";
		$Database->Query($this->pog_query);
		if ($Database->Rows() > 0)
		{
			$this->pog_query = "update `news` set 
			`heading`='".$Database->Escape($this->heading)."', 
			`description`='".$Database->Escape($this->description)."', 
			`link`='".$Database->Escape($this->link)."', 
			`live`='".$Database->Escape($this->live)."', 
			`dt_created`='".$Database->Escape($this->dt_created)."' where `newsid`='".$this->newsId."'";
		}
		else
		{
			$this->pog_query = "insert into `news` (`heading`, `description`, `link`, `live`) values (
			'".$Database->Escape($this->heading)."', 
			'".$Database->Escape($this->description)."', 
			'".$Database->Escape($this->link)."', 
			'".$Database->Escape($this->live)."' )";
		}
		$Database->InsertOrUpdate($this->pog_query);
		if ($this->newsId == "")
		{
			$this->newsId = $Database->GetCurrentId();
		}
		return $this->newsId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $newsId
	*/
	function SaveNew()
	{
		$this->newsId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "delete from `news` where `newsid`='".$this->newsId."'";
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
			$pog_query = "delete from `news` where ";
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