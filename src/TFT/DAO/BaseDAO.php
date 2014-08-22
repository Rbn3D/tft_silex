<?php

namespace TFT\DAO;

abstract class BaseDAO
{
	private $host;
    private $username;
    private $password;
	private $database;

	private $connection;

	public function __construct($host, $username, $password, $database)
	{
		$this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
	}

	public function openConecction()
	{
		try
		{
			@$this->conection->close();
		}
		finally
		{
			$this->connection = new mysqli($this->host, $this->username, $this->password, $this->database)
		}
	}

	public function closeConnection()
	{
		try
		{
			@$conection->close();
		}
	}

	public abstract function queryAll();
	//public abstract function queryAllBy($column, $value);
	public abstract function queryOneBy($column, $value);
	public abstract function save($obj);
	public abstract function delete($obj);
}