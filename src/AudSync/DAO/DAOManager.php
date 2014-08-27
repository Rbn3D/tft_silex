<?php

namespace AudSync\DAO;
use \Silex\Application;

class DAOManager
{
    private $host;
    private $username;
    private $password;
	private $database;

    private $connection = null;

	private $userDetailsDAO = null; 

    public function __construct($connectionSettings)
    {
        $this->readConnectionSettings($connectionSettings);
    }

    public function readConnectionSettings($settings)
    {
        $this->host = $settings['host'];
        $this->username = $settings['username'];
        $this->password = $settings['password'];
        $this->database = $settings['database'];
    }

    public function getUsetDetailsDAO()
    {
    	if(!$this->userDetailsDAO)
    		$this->userDetailsDAO = new UserDetailsDAO($this->host, $this->username, $this->password, $this->database);

    	return $this->userDetailsDAO;
    }
}