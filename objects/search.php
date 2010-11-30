<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `search` (
	`searchid` int(11) NOT NULL auto_increment,
	`search_string` VARCHAR(255) NOT NULL,
	`time` VARCHAR(255) NOT NULL,
	`response` TEXT NOT NULL,
	`sms_id` VARCHAR(255) NOT NULL,
	`user_id` INT NOT NULL, PRIMARY KEY  (`searchid`)) ENGINE=MyISAM;
*/

/**
* <b>search</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0f / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=search&attributeList=array+%28%0A++0+%3D%3E+%27search_string%27%2C%0A++1+%3D%3E+%27time%27%2C%0A++2+%3D%3E+%27response%27%2C%0A++3+%3D%3E+%27sms_id%27%2C%0A++4+%3D%3E+%27user_id%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++2+%3D%3E+%27TEXT%27%2C%0A++3+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++4+%3D%3E+%27INT%27%2C%0A%29
*/
include_once('class.pog_base.php');
class search extends POG_Base
{
	public $searchId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $search_string;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $time;
	
	/**
	 * @var TEXT
	 */
	public $response;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $sms_id;
	
	/**
	 * @var INT
	 */
	public $user_id;
	
	public $pog_attribute_type = array(
		"searchId" => array('db_attributes' => array("NUMERIC", "INT")),
		"search_string" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"time" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"response" => array('db_attributes' => array("TEXT", "TEXT")),
		"sms_id" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"user_id" => array('db_attributes' => array("NUMERIC", "INT")),
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
	
	function search($search_string='', $time='', $response='', $sms_id='', $user_id='')
	{
		$this->search_string = $search_string;
		$this->time = $time;
		$this->response = $response;
		$this->sms_id = $sms_id;
		$this->user_id = $user_id;
	}
	
	
	/**
	* Gets object from database
	* @param integer $searchId 
	* @return object $search
	*/
	function Get($searchId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `search` where `searchid`='".intval($searchId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->searchId = $row['searchid'];
			$this->search_string = $this->Unescape($row['search_string']);
			$this->time = $this->Unescape($row['time']);
			$this->response = $this->Unescape($row['response']);
			$this->sms_id = $this->Unescape($row['sms_id']);
			$this->user_id = $this->Unescape($row['user_id']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $searchList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `search` ";
		$searchList = Array();
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
			$sortBy = "searchid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$search = new $thisObjectName();
			$search->searchId = $row['searchid'];
			$search->search_string = $this->Unescape($row['search_string']);
			$search->time = $this->Unescape($row['time']);
			$search->response = $this->Unescape($row['response']);
			$search->sms_id = $this->Unescape($row['sms_id']);
			$search->user_id = $this->Unescape($row['user_id']);
			$searchList[] = $search;
		}
		return $searchList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $searchId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `searchid` from `search` where `searchid`='".$this->searchId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `search` set 
			`search_string`='".$this->Escape($this->search_string)."', 
			`time`='".$this->Escape($this->time)."', 
			`response`='".$this->Escape($this->response)."', 
			`sms_id`='".$this->Escape($this->sms_id)."', 
			`user_id`='".$this->Escape($this->user_id)."' where `searchid`='".$this->searchId."'";
		}
		else
		{
			$this->pog_query = "insert into `search` (`search_string`, `time`, `response`, `sms_id`, `user_id` ) values (
			'".$this->Escape($this->search_string)."', 
			'".$this->Escape($this->time)."', 
			'".$this->Escape($this->response)."', 
			'".$this->Escape($this->sms_id)."', 
			'".$this->Escape($this->user_id)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->searchId == "")
		{
			$this->searchId = $insertId;
		}
		return $this->searchId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $searchId
	*/
	function SaveNew()
	{
		$this->searchId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `search` where `searchid`='".$this->searchId."'";
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
			$pog_query = "delete from `search` where ";
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