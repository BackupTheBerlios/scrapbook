<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `supplier` (
	`supplierid` int(11) NOT NULL auto_increment,
	`onlineuser_onlineuserid` INT NOT NULL,
	`supplier_category_id` INT NOT NULL,
	`name` VARCHAR(45) NOT NULL,
	`logo` VARCHAR(255) NOT NULL,
	`description` TEXT NOT NULL,
	`link` VARCHAR(255) NOT NULL,
	`tel` VARCHAR(45) NOT NULL,
	`dt_created` BIGINT NOT NULL,
	`supplier_status` ENUM('temp','active','disabled') NOT NULL, PRIMARY KEY  (`supplierid`));
*/

/**
* <b>Supplier</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 2.6.3 / PHP4
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php4&wrapper=pog&objectName=Supplier&attributeList=array+%28%0A++0+%3D%3E+%27onlineuser_onlineuserid%27%2C%0A++1+%3D%3E+%27supplier_category_id%27%2C%0A++2+%3D%3E+%27name%27%2C%0A++3+%3D%3E+%27logo%27%2C%0A++4+%3D%3E+%27description%27%2C%0A++5+%3D%3E+%27link%27%2C%0A++6+%3D%3E+%27tel%27%2C%0A++7+%3D%3E+%27dt_created%27%2C%0A++8+%3D%3E+%27supplier_status%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27INT%27%2C%0A++1+%3D%3E+%27INT%27%2C%0A++2+%3D%3E+%27VARCHAR%2845%29%27%2C%0A++3+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++4+%3D%3E+%27TEXT%27%2C%0A++5+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++6+%3D%3E+%27VARCHAR%2845%29%27%2C%0A++7+%3D%3E+%27BIGINT%27%2C%0A++8+%3D%3E+%27ENUM%28%5C%5C%5C%27temp%5C%5C%5C%27%2C%5C%5C%5C%27active%5C%5C%5C%27%2C%5C%5C%5C%27disabled%5C%5C%5C%27%29%27%2C%0A%29
*/
class Supplier
{
	var $supplierId = '';

	/**
	 * @var INT
	 */
	var $onlineuser_onlineuserid;
	
	/**
	 * @var INT
	 */
	var $supplier_category_id;
	
	/**
	 * @var VARCHAR(45)
	 */
	var $name;
	
	/**
	 * @var VARCHAR(255)
	 */
	var $logo;
	
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
	var $supplier_status;
	
	var $pog_attribute_type = array(
		"supplierId" => array("NUMERIC", "INT"),
		"onlineuser_onlineuserid" => array("NUMERIC", "INT"),
		"supplier_category_id" => array("NUMERIC", "INT"),
		"name" => array("TEXT", "VARCHAR", "45"),
		"logo" => array("TEXT", "VARCHAR", "255"),
		"description" => array("TEXT", "TEXT"),
		"link" => array("TEXT", "VARCHAR", "255"),
		"tel" => array("TEXT", "VARCHAR", "45"),
		"dt_created" => array("NUMERIC", "BIGINT"),
		"supplier_status" => array("SET", "ENUM", "'temp','active','disabled'"),
		);
	var $pog_query;
	
	function Supplier($onlineuser_onlineuserid='', $supplier_category_id='', $name='', $logo='', $description='', $link='', $tel='', $dt_created='', $supplier_status='')
	{
		$this->onlineuser_onlineuserid = $onlineuser_onlineuserid;
		$this->supplier_category_id = $supplier_category_id;
		$this->name = $name;
		$this->logo = $logo;
		$this->description = $description;
		$this->link = $link;
		$this->tel = $tel;
		$this->dt_created = $dt_created;
		$this->supplier_status = $supplier_status;
	}
	
	
	/**
	* Gets object from database
	* @param integer $supplierId 
	* @return object $Supplier
	*/
	function Get($supplierId)
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select * from `supplier` where `supplierid`='".intval($supplierId)."' LIMIT 1";
		$Database->Query($this->pog_query);
		return $this->populate($Database);

	}
	
	function populate($Database, $i=0)
	{
		$thisObjectName = get_class($this);
		$newObject = new $thisObjectName();
		$newObject->supplierId = $Database->Result($i, "supplierid");
		$newObject->onlineuser_onlineuserid = $Database->Unescape($Database->Result($i, "onlineuser_onlineuserid"));
		$newObject->supplier_category_id = $Database->Unescape($Database->Result($i, "supplier_category_id"));
		$newObject->name = $Database->Unescape($Database->Result($i, "name"));
		$newObject->logo = $Database->Unescape($Database->Result($i, "logo"));
		$newObject->description = $Database->Unescape($Database->Result($i, "description"));
		$newObject->link = $Database->Unescape($Database->Result($i, "link"));
		$newObject->tel = $Database->Unescape($Database->Result($i, "tel"));
		$newObject->dt_created = $Database->Unescape($Database->Result($i, "dt_created"));
		$newObject->supplier_status = $Database->Result($i, "supplier_status");
		return $newObject;
	}		
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $supplierList
	*/
	function GetList($fcv_array, $sortBy='', $ascending=true, $limit='')
	{
		$sqlLimit = ($limit != '' && $sortBy == ''?"LIMIT $limit":'');
		if (sizeof($fcv_array) > 0)
		{
			$supplierList = Array();
			$Database = new DatabaseConnection();
			$this->pog_query = "select * from `supplier` where ";
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
			$this->pog_query .= " order by supplierid asc $sqlLimit";
			$Database->Query($this->pog_query);

			for ($i=0; $i < $Database->Rows(); $i++)
			{
				$supplierList[] = $this->populate($Database, $i);
			}
			if ($sortBy != '')
			{
				$f = '';
				$supplier = new Supplier();
				if (isset($supplier->pog_attribute_type[$sortBy]) && ($supplier->pog_attribute_type[$sortBy][0] == "NUMERIC" || $supplier->pog_attribute_type[$sortBy][0] == "SET"))
				{
					$f = 'return $supplier1->'.$sortBy.' > $supplier2->'.$sortBy.';';
				}
				else if (isset($supplier->pog_attribute_type[$sortBy]))
				{
					$f = 'return strcmp(strtolower($supplier1->'.$sortBy.'), strtolower($supplier2->'.$sortBy.'));';
				}
				usort($supplierList, create_function('$supplier1, $supplier2', $f));
				if (!$ascending)
				{
					$supplierList = array_reverse($supplierList);
				}
				if ($limit != '')
				{
					$limitParts = explode(',', $limit);
					if (sizeof($limitParts) > 1)
					{
						return array_slice($supplierList, $limitParts[0], $limitParts[1]);
					}
					else
					{
						return array_slice($supplierList, 0, $limit);
					}
				}
			}
			return $supplierList;
		}
		return null;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $supplierId
	*/
	function Save()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "select `supplierid` from `supplier` where `supplierid`='".$this->supplierId."' LIMIT 1";
		$Database->Query($this->pog_query);
		if ($Database->Rows() > 0)
		{
			$this->pog_query = "update `supplier` set 
			`onlineuser_onlineuserid`='".$Database->Escape($this->onlineuser_onlineuserid)."', 
			`supplier_category_id`='".$Database->Escape($this->supplier_category_id)."', 
			`name`='".$Database->Escape($this->name)."', 
			`logo`='".$Database->Escape($this->logo)."', 
			`description`='".$Database->Escape($this->description)."', 
			`link`='".$Database->Escape($this->link)."', 
			`tel`='".$Database->Escape($this->tel)."', 
			`dt_created`='".$Database->Escape($this->dt_created)."', 
			`supplier_status`='".$this->supplier_status."' where `supplierid`='".$this->supplierId."'";
		}
		else
		{
			$this->pog_query = "insert into `supplier` (`onlineuser_onlineuserid`, `supplier_category_id`, `name`, `logo`, `description`, `link`, `tel`, `dt_created`, `supplier_status` ) values (
			'".$Database->Escape($this->onlineuser_onlineuserid)."', 
			'".$Database->Escape($this->supplier_category_id)."', 
			'".$Database->Escape($this->name)."', 
			'".$Database->Escape($this->logo)."', 
			'".$Database->Escape($this->description)."', 
			'".$Database->Escape($this->link)."', 
			'".$Database->Escape($this->tel)."', 
			'".$Database->Escape($this->dt_created)."', 
			'".$this->supplier_status."' )";
		}
		$Database->InsertOrUpdate($this->pog_query);
		if ($this->supplierId == "")
		{
			$this->supplierId = $Database->GetCurrentId();
		}
		return $this->supplierId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $supplierId
	*/
	function SaveNew()
	{
		$this->supplierId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$Database = new DatabaseConnection();
		$this->pog_query = "delete from `supplier` where `supplierid`='".$this->supplierId."'";
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
			$pog_query = "delete from `supplier` where ";
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