<?php

namespace AudSync\DAO;

abstract class BaseDAO
{
	protected $host;
    protected $username;
    protected $password;
	protected $database;

	protected $connection = null;

	public function __construct($host, $username, $password, $database)
	{
		$this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
	}

	public function openConnection()
	{
		$this->closeConnection();
		if(!($this->connection != null && !$this->connection->connect_error))
		{
			$this->connection = new \mysqli($this->host, $this->username, $this->password, $this->database);
			//if($error = $this->connection->connect_error)
				//echo $error;
		}
	}

	public function closeConnection()
	{
		if($this->connection != null && !$this->connection->connect_error)
		{
			$this->connection->close();
			$this->connection = null;
		}
	}

	public abstract function queryAll();
	//public abstract function queryAllBy($column, $value);
	public abstract function exists($column, $value);
	public abstract function queryOneBy($column, $value);
	public abstract function save($obj);
	public abstract function delete($obj);

	protected abstract function build($values);

	public function executeQuery($sql)
	{
		$query = $this->connection->query($sql);
		return $query;
	}

	public function executeInsert($sql)
	{
		$this->connection->query($sql);
		return $this->connection->insert_id;
	}

	public function executeUpdate($sql)
	{
		$this->connection->query($sql);
		return $this->connection->affected_rows;
	}
}