<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `supplier_category` (
	`supplier_category_id` int(11) NOT NULL auto_increment,
	`name` VARCHAR(45) NOT NULL, PRIMARY KEY  (`supplier_category_id`));
*/

/**
* <b>Supplier_category</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 2.6.3 / PHP4
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php4&wrapper=pog&objectName=Supplier_category&attributeList=array+%28%0A++0+%3D%3E+%27name%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%2845%29%27%2C%0A%29
*/
class Supplier_category
{
	var $supplier_categoryId = '';

	/**
	 * @var VARCHAR(45)
	 */
	var $name;
	
	var $pog_attribute_type = array(
		"supplier_categoryId" => array("NUMERIC", "INT"),
		"name" => array("TEXT", "VARCHAR", "45"),
		);
	var $pog_query;
	
	function Supplier_category($name='')
	{
		$this->name = $name;
	}
	
	
	/**
	* Gets object from database
	* @param integer $supplier_categoryId 
	* @return object $Supplier_category
	*/
	function Get($supplier_categoryId)
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select * from `supplier_category` where `supplier_category_id`='".intval($supplier_categoryId)."' LIMIT 1";
		$Database->Query($this->pog_query);
		return $this->populate($Database);
	}
	
	function populate($Database, $i=0)
	{
		$thisObjectName = get_class($this);
		$newObject = new $thisObjectName();
		$newObject->supplier_categoryId = $Database->Result($i, "supplier_category_id");
		$newObject->name = $Database->Unescape($Database->Result($i, "name"));
		return $newObject;
	}		
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $supplier_categoryList
	*/
	function GetList($fcv_array, $sortBy='', $ascending=true, $limit='')
	{
		$sqlLimit = ($limit != '' && $sortBy == ''?"LIMIT $limit":'');
		if (sizeof($fcv_array) > 0)
		{
			$supplier_categoryList = Array();
			$Database = new DatabaseConnection();
			$this->pog_query = "select * from `supplier_category` where ";
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
			$this->pog_query .= " order by supplier_category_id asc $sqlLimit";
			$Database->Query($this->pog_query);

			for ($i=0; $i < $Database->Rows(); $i++)
			{
				$supplier_categoryList[] = $this->populate($Database, $i);
			}
			if ($sortBy != '')
			{
				$f = '';
				$supplier_category = new Supplier_category();
				if (isset($supplier_category->pog_attribute_type[$sortBy]) && ($supplier_category->pog_attribute_type[$sortBy][0] == "NUMERIC" || $supplier_category->pog_attribute_type[$sortBy][0] == "SET"))
				{
					$f = 'return $supplier_category1->'.$sortBy.' > $supplier_category2->'.$sortBy.';';
				}
				else if (isset($supplier_category->pog_attribute_type[$sortBy]))
				{
					$f = 'return strcmp(strtolower($supplier_category1->'.$sortBy.'), strtolower($supplier_category2->'.$sortBy.'));';
				}
				usort($supplier_categoryList, create_function('$supplier_category1, $supplier_category2', $f));
				if (!$ascending)
				{
					$supplier_categoryList = array_reverse($supplier_categoryList);
				}
				if ($limit != '')
				{
					$limitParts = explode(',', $limit);
					if (sizeof($limitParts) > 1)
					{
						return array_slice($supplier_categoryList, $limitParts[0], $limitParts[1]);
					}
					else
					{
						return array_slice($supplier_categoryList, 0, $limit);
					}
				}
			}
			return $supplier_categoryList;
		}
		return null;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $supplier_categoryId
	*/
	function Save()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select `supplier_category_id` from `supplier_category` where `supplier_category_id`='".$this->supplier_categoryId."' LIMIT 1";
		$Database->Query($this->pog_query);
		if ($Database->Rows() > 0)
		{
			$this->pog_query = "update `supplier_category` set 
			`name`='".$Database->Escape($this->name)."' where `supplier_category_id`='".$this->supplier_categoryId."'";
		}
		else
		{
			$this->pog_query = "insert into `supplier_category` (`name` ) values (
			'".$Database->Escape($this->name)."' )";
		}
		$Database->InsertOrUpdate($this->pog_query);
		if ($this->supplier_categoryId == "")
		{
			$this->supplier_categoryId = $Database->GetCurrentId();
		}
		return $this->supplier_categoryId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $supplier_categoryId
	*/
	function SaveNew()
	{
		$this->supplier_categoryId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "delete from `supplier_category` where `supplier_category_id`='".$this->supplier_categoryId."'";
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
			$pog_query = "delete from `supplier_category` where ";
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
