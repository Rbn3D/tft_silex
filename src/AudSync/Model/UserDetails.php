<?php

namespace AudSync\Model;

class UserDetails
{
	private $disqusUserId;
	private $disqusEmail;

	public function __construct($disqusUserId, $disqusEmail)
	{
		$this->disqusUserId = $disqusUserId;
		$this->disqusEmail = $disqusEmail;
	}

    public function getDisqusUserId()
    {
        return $this->disqusUserId;
    }

    public function setDisqusUserId($disqusUserId)
    {
        $this->disqusUserId = $disqusUserId;

        return $this;
    }

    public function getDisqusEmail()
    {
        return $this->disqusEmail;
    }

    public function setDisqusEmail($disqusEmail)
    {
        $this->disqusEmail = $disqusEmail;

        return $this;
    }
}
