<?php

namespace TFT\DAO;

class UserDetailsDAO extends BaseDAO
{

	public function __construct($host, $username, $password, $database)
	{
		parent::__construct($host, $username, $password, $database);
		/*$this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;*/
	}

	public function queryAll()
	{
		$this->openConnection();

		$res = $this->executeQuery("SELECT * FROM user_details");

		$users = array();
		while ($row = $res->fetch_array())
		{
			$users[] = $this->build($row);
		}

		$this->closeConnection();
		return $users;
	}
	
	public function exists($column, $value)
	{
		return $this->queryOneBy($column, $value) != null;
	}

	public function queryOneBy($column, $value)
	{
		$this->openConnection();

		$res = $this->executeQuery("SELECT * FROM user_details WHERE $column = '$value'"); // TODO: Could use prepared statements, but I don't think we need more complication

		$user = null;
		try
		{
			$row = $res->fetch_array();
			$user = $this->build($row);
		}
		finally
		{
			$this->closeConnection();
		}
		return $user;
	}

	public function save($obj)
	{
		$this->openConnection();

		$res = null;

		$disqus_email = $obj->getDisqusEmail();
		$disqus_user_id = $obj->getDisqusUserId();

		if(!$this->exists("disqus_user_id", $disqus_user_id))
		{
			$res = $this->executeInsert("INSERT INTO user_details (disqus_user_id, disqus_email) VALUES ('$disqus_user_id','$disqus_email')");
			echo 'i';
		}
		else
		{
			$res = $this->executeUpdate("UPDATE user_details SET disqus_email = '$disqus_email' WHERE disqus_user_id = '$disqus_user_id'");
			echo 'u';
		}

		$this->closeConnection();
		return $res;
	}

	public function delete($obj)
	{
		$this->openConnection();

		$disqus_user_id = $obj->getDisqusUserId();
		$res = $this->executeUpdate("DELETE FROM user_details WHERE disqus_user_id = '$disqus_user_id'");

		$this->closeConnection();
	}

	public function build($values)
	{
		return new \TFT\Model\UserDetails($values['disqus_user_id'], $values['disqus_email']);
	}

}