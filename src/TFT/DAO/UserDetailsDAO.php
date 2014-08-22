<?php

namespace TFT\Model;

use TFT\DAO;

class UserDetailsDAO extends BaseDAO
{
	public $disqus_user_id;
	public $disqus_emai;

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
			$res->fetch_array();
			$user = $this->build($res);
		}
		finally
		{
			$this->closeConnection();
			return $user;
		}
	}

	public function save($obj)
	{
		$this->openConnection();

		$res = null;

		$disqus_email = $obj->getDisqusEmail();
		$disqus_user_id = $obj->getDisqusUserId();

		if(!$this->exists("disqus_user_id", $obj->getDisqusUserId()))
			$res =  $this->executeUpdate("INSERT INTO user_details (disqus_user_id, disqus_email) VALUES ('$disqus_user_id','$disqus_email')")
		else
			$res = $this->executeUpdate("UPDATE user_details SET disqus_user_id = '$disqus_user_id', disqus_email = '$disqus_email'");

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
		return new UserDetails($values['disqus_user_id'], $values['disqus_email']);
	}

}