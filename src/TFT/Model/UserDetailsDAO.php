<?php

namespace TFT\Model;

use TFT\DAO;

class UserDetailsDAO extends BaseDAO
{
	public $disqus_user_id;
	public $disqus_emai;

	public abstract function queryAll()
	{
		$this->openConnection();



		$this->closeConnection();
	}
	
	public abstract function queryOneBy($column, $value)
	{
		$this->openConnection();



		$this->closeConnection();
	}

	public abstract function save($obj)
	{
		$this->openConnection();



		$this->closeConnection();
	}

	public abstract function delete($obj)
	{
		$this->openConnection();

		

		$this->closeConnection();
	}


}