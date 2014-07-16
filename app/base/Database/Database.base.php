<?php
/*
 * Database Class
 * db.danielgolub.com
*/

class Database extends mysqli
{
	// The details structure
	// private static $details = array();

	// Testing mode
	// TRUE = Development mode (errors will be displayed)
	// False = Production mode (errors will NOT be displayed)
	private static $testing = TRUE;

	// The query to be executed
	public static $query;

	// The connection type
	// mysqli, mysql
	private static $connection_type = "mysqli";

	public function __construct($host, $user, $password, $dbname)
	{
		// if(empty($password)) $password = 'NULL';
		// Set the details into the $details structure
		// array_push(self::$details, $host);
		// array_push(self::$details, $user);
		// array_push(self::$details, $password);
		// array_push(self::$details, $dbname);
		// if(self::$details[2] == 'NULL') self::$details[2] = '';
		// print_r(self::$details);
		// foreach (self::$details as $key)
		// {
			# code...
		// }
		if(self::$connection_type == 'mysqli')
		{
			if($this->connect($host,$user,$password,$dbname))
			{
				echo "Can't connect to the database..";
			}
		}

		else if(self::$connection_type == 'mysql')
		{
			mysql_connect($host, $user, $password);
			mysql_select_db($dbname);
		}

		// $this->connect($host,$user,$password,$dbname);
	}

	public function set_encoding($str)
	{
		if(self::$connection_type == 'mysqli')
		{
			if(!$this->set_charset($str))
				return false;
		}

		else if(self::$connection_type == 'mysql')
		{
			if(!mysql_set_charset($str))
				return false;
		}

		return true;
	}

	public function make($type, $table, $what = '*')
	{
		switch ($type)
		{
			case 'select':
				if($what != '*')
				{
					foreach ($what as $key)
					{
						$whatFinal .= '`'.$key.'`,';
					}

					$whatFinal = substr($whatFinal, 0, -1);
				}

				else
				{
					$whatFinal = $what;
				}
				self::$query = "SELECT ".$whatFinal." FROM `".$table."`";
				break;
			case 'insert':
				if(is_array($table))
				{
					$data = "INSERT INTO `".$table['table']."` ";
					$data .= '(';
					foreach ($table as $key => $value)
					{
						if($key != 'table')
							$data .= '`'.$key.'`,';
					}
					$data = substr($data, 0, -1);
					$data .= ') VALUES(';
					foreach ($table as $key => $value)
					{
						if($key != 'table')
							$data .= "'".$value."',";
					}
					$data = substr($data, 0, -1);
					$data .= ')';
					self::$query = $data;
				}

				else
				{
					die("Insert method does not contain an array");
				}
				break;
			case 'delete':
				self::$query = "DELETE FROM `".$table."`";
				break;
			case 'update':
				$data = "UPDATE `".$table['table']."` SET ";
				foreach ($table as $key => $value)
				{
					if($key != 'table')
						$data .= "`".$key."` = '".$value."',";
				}
				$data = substr($data, 0, -1);
				self::$query = $data;
				break;
			case 'duplicate':
				$data = "INSERT INTO `".$table."` ";
				$data .= '(';
				$previous = $this->query("SELECT * FROM `".$table."` ORDER BY `id` DESC");
				$previous = $previous->fetch_array();
				$tableStructure = $this->getStructure($table);
				$tableStructure = explode(" | ", $tableStructure);
				// print_r($tableStructure);
				foreach ($tableStructure as $key)
				{
					if($key != 'id')
						$data .= '`'.$key.'`,';
				}
				$data = substr($data, 0, -1);
				$data .= ') VALUES(';
				$c = 0;
				foreach ($previous as $key => $value)
				{
					$c++;
					if($c % 2 == 0 && $key != 'id')
						$data .= "'".$value."',";
				}
				$data = substr($data, 0, -1);
				$data .= ')';
				self::$query = $data;
				break;
		}
	}

	public function where($arr)
	{
		$i = 0;
		foreach ($arr as $key => $val)
		{
			$i++;
			$finalStr = "`".$key."` = '".$val."'";
			if($i == 1)
			{
				self::$query .= " WHERE ".$finalStr;
			}

			else
			{
				self::$query .= " AND ".$finalStr;
			}
		}
	}

	public function order($parameter, $list = 'ASC')
	{
		self::$query .= " ORDER BY `".$parameter."` ".$list;
	}

	public function execute($return = 'query')
	{
		$file = realpath(dirname(__FILE__)).'/db.log';
		// Open the file to get existing content
		$current = file_get_contents($file);
		// Append a new person to the file
		$current .= self::$query."\n";
		// Write the contents back to the file
		file_put_contents($file, $current);

		switch ($return) {
			case 'query':
				if(self::$connection_type == 'mysqli')
				{
					if(self::$testing === TRUE)
						return $this->query(self::$query) or die($this->error);
					else
						return $this->query(self::$query);
				}

				else if(self::$connection_type == 'mysql')
				{
					if(self::$testing === TRUE)
						return mysql_query(self::$query) or die(mysql_error());
					else
						return mysql_query(self::$query);
				}
				break;
			case 'boolean':
				if(self::$connection_type == 'mysqli')
				{
					if(self::$testing === TRUE)
						$query = $this->query(self::$query) or die($this->error);
					else
						$query = $this->query(self::$query);
						if($query->num_rows >= 0) return true; else return false;
				}

				else if(self::$connection_type == 'mysql')
				{
					if(self::$testing === TRUE)
						$query = mysql_query(self::$query) or die(mysql_error());
					else
						$query = mysql_query(self::$query);
					if(mysql_num_rows($query) >= 0) return true; else return false;
				}
				break;
			case 'rows':
				if(self::$connection_type == 'mysqli')
				{
					if(self::$testing === TRUE)
						$query = $this->query(self::$query) or die($this->error);
					else
						$query = $this->query(self::$query);
					return $query->num_rows;
				}

				else if(self::$connection_type == 'mysql')
				{
					if(self::$testing === TRUE)
						$query = mysql_query(self::$query) or die(mysql_error());
					else
						$query = mysql_query(self::$query);
					return mysql_num_rows($query);
				}
				break;
			case 'fetch':
				if(self::$connection_type == 'mysqli')
				{
					if(self::$testing === TRUE)
						$query = $this->query(self::$query) or die($this->error);
					else
						$query = $this->query(self::$query);
					if($query->num_rows >= 1)
					{
						return $query->fetch_array();
					}
				}

				else if(self::$connection_type == 'mysql')
				{
					if(self::$testing === TRUE)
						$query = mysql_query(self::$query) or die(mysql_error());
					else
						$query = mysql_query(self::$query);
					if(mysql_num_rows($query) >= 1)
					{
						return mysql_fetch_array($query);
					}
				}
				break;
			case 'loop':
				if(self::$connection_type == 'mysqli')
				{
					if(self::$testing === TRUE)
						$query = $this->query(self::$query) or die($this->error);
					else
						$query = $this->query(self::$query);
					if($query->num_rows >= 1)
					{
						$result = array();
						while($fetch = $query->fetch_array())
						{
							array_push($result, $fetch);
						}
						return $result;
					}
				}

				else if(self::$connection_type == 'mysql')
				{
					if(self::$testing === TRUE)
						$query = mysql_query(self::$query) or die(mysql_error());
					else
						$query = mysql_query(self::$query);
					if(mysql_num_rows($query) >= 1)
					{
						$result = array();
						while($fetch = mysql_fetch_array($query))
						{
							array_push($result, $fetch);
						}
						return $result;
					}
				}
				break;
		}
	}

	public function getLastCommand()
	{
		$file = 'db.log';
		// Open the file to get existing content
		$current = file_get_contents($file);
		$current = explode("\n", $current);
		$current = $current[count($current) - 2];
		return $current;
	}

	public function getStructure($table)
	{
		if($query->num_rows == 0)
			$this->query("INSERT INTO `".$table."` (`id`) VALUES('1')");
		$query = $this->query("SELECT * FROM `".$table."`");
		$query = $query->fetch_array();
		$b = 0;
		$data = '';
		// echo '------------------------------------------------------------------<br />';
		foreach ($query as $key => $val)
		{
			$b++;
			if($b % 2 == 0)
				$data .= $key." | ";
		}
		$data = substr($data, 0, -3);
		if($query->num_rows == 0)
			$this->query("DELETE FROM `".$table."` WHERE `id` = 1");

		return $data;
	}

	public function total($type = 'total')
	{
		$file = 'db.log';
		// Open the file to get existing content
		$current = file_get_contents($file);
		$current = explode("\n", $current);
		if($type == 'total')
			return count($current);
		else if($type == 'categories')
		{
			$select = 0;
			$insert = 0;
			$delete = 0;
			$update = 0;
			foreach ($current as $key)
			{
				if(strpos($key, "SELECT") !== false)
				{
					$select++;
				}

				else if(strpos($key, "INSERT") !== false)
				{
					$insert++;
				}

				else if(strpos($key, "DELETE") !== false)
				{
					$delete++;
				}

				else if(strpos($key, "UPDATE") !== false)
				{
					$update++;
				}
			}
			$array = array(
				"SELECT" => $select,
				"INSERT" => $insert,
				"DELETE" => $delete,
				"UPDATE" => $update
			);
			return $array;
		}
	}
}

?>
