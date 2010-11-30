<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `user` (
	`userid` int(11) NOT NULL auto_increment,
	`phone` VARCHAR(255) NOT NULL,
	`location` VARCHAR(255) NOT NULL,
	`created_at` VARCHAR(255) NOT NULL,
	`last_search` TEXT NOT NULL,
	`last_offset` INT NOT NULL, PRIMARY KEY  (`userid`)) ENGINE=MyISAM;
*/

/**
* <b>user</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0f / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=user&attributeList=array+%28%0A++0+%3D%3E+%27phone%27%2C%0A++1+%3D%3E+%27location%27%2C%0A++2+%3D%3E+%27created_at%27%2C%0A++3+%3D%3E+%27last_search%27%2C%0A++4+%3D%3E+%27last_offset%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++2+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++3+%3D%3E+%27TEXT%27%2C%0A++4+%3D%3E+%27INT%27%2C%0A%29
*/
include_once('class.pog_base.php');
class user extends POG_Base
{
	public $userId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $phone;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $location;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $created_at;
	
	/**
	 * @var TEXT
	 */
	public $last_search;
	
	/**
	 * @var INT
	 */
	public $last_offset;
	
	public $pog_attribute_type = array(
		"userId" => array('db_attributes' => array("NUMERIC", "INT")),
		"phone" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"location" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"created_at" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"last_search" => array('db_attributes' => array("TEXT", "TEXT")),
		"last_offset" => array('db_attributes' => array("NUMERIC", "INT")),
		);
	public $pog_query;
	
	
	/**
	* Getter for some private attributes
	* @return mixed $attribute
	*/
	public function __get($attribute)
	{
		if (isset($this->{"_".$attribute}))
		{
			return $this->{"_".$attribute};
		}
		else
		{
			return false;
		}
	}
	
	function user($phone='', $location='', $created_at='', $last_search='', $last_offset='')
	{
		$this->phone = $phone;
		$this->location = $location;
		$this->created_at = $created_at;
		$this->last_search = $last_search;
		$this->last_offset = $last_offset;
	}
	
	
	/**
	* Gets object from database
	* @param integer $userId 
	* @return object $user
	*/
	function Get($userId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `user` where `userid`='".intval($userId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->userId = $row['userid'];
			$this->phone = $this->Unescape($row['phone']);
			$this->location = $this->Unescape($row['location']);
			$this->created_at = $this->Unescape($row['created_at']);
			$this->last_search = $this->Unescape($row['last_search']);
			$this->last_offset = $this->Unescape($row['last_offset']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $userList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `user` ";
		$userList = Array();
		if (sizeof($fcv_array) > 0)
		{
			$this->pog_query .= " where ";
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
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						if ($GLOBALS['configuration']['db_encoding'] == 1)
						{
							$value = POG_Base::IsColumn($fcv_array[$i][2]) ? "BASE64_DECODE(".$fcv_array[$i][2].")" : "'".$fcv_array[$i][2]."'";
							$this->pog_query .= "BASE64_DECODE(`".$fcv_array[$i][0]."`) ".$fcv_array[$i][1]." ".$value;
						}
						else
						{
							$value =  POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$this->Escape($fcv_array[$i][2])."'";
							$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
						}
					}
					else
					{
						$value = POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$fcv_array[$i][2]."'";
						$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
					}
				}
			}
		}
		if ($sortBy != '')
		{
			if (isset($this->pog_attribute_type[$sortBy]['db_attributes']) && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'SET')
			{
				if ($GLOBALS['configuration']['db_encoding'] == 1)
				{
					$sortBy = "BASE64_DECODE($sortBy) ";
				}
				else
				{
					$sortBy = "$sortBy ";
				}
			}
			else
			{
				$sortBy = "$sortBy ";
			}
		}
		else
		{
			$sortBy = "userid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$user = new $thisObjectName();
			$user->userId = $row['userid'];
			$user->phone = $this->Unescape($row['phone']);
			$user->location = $this->Unescape($row['location']);
			$user->created_at = $this->Unescape($row['created_at']);
			$user->last_search = $this->Unescape($row['last_search']);
			$user->last_offset = $this->Unescape($row['last_offset']);
			$userList[] = $user;
		}
		return $userList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $userId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `userid` from `user` where `userid`='".$this->userId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `user` set 
			`phone`='".$this->Escape($this->phone)."', 
			`location`='".$this->Escape($this->location)."', 
			`created_at`='".$this->Escape($this->created_at)."', 
			`last_search`='".$this->Escape($this->last_search)."', 
			`last_offset`='".$this->Escape($this->last_offset)."' where `userid`='".$this->userId."'";
		}
		else
		{
			$this->pog_query = "insert into `user` (`phone`, `location`, `created_at`, `last_search`, `last_offset` ) values (
			'".$this->Escape($this->phone)."', 
			'".$this->Escape($this->location)."', 
			'".$this->Escape($this->created_at)."', 
			'".$this->Escape($this->last_search)."', 
			'".$this->Escape($this->last_offset)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->userId == "")
		{
			$this->userId = $insertId;
		}
		return $this->userId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $userId
	*/
	function SaveNew()
	{
		$this->userId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `user` where `userid`='".$this->userId."'";
		return Database::NonQuery($this->pog_query, $connection);
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
			$connection = Database::Connect();
			$pog_query = "delete from `user` where ";
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
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$this->Escape($fcv_array[$i][2])."'";
					}
					else
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$fcv_array[$i][2]."'";
					}
				}
			}
			return Database::NonQuery($pog_query, $connection);
		}
	}
}
?>