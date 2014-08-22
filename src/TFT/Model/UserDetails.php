<?php

namespace TFT\Model;

class UserDetails
{
	private $disqusUserId;
	private $disqusEmail;

	public function __construct($disqusUserId, $disqusEmail)
	{
		$this->disqusUserId = $disqusUserId;
		$this->disqusEmail = $disqusEmail;
	}

    /**
     * Gets the value of disqusUserId.
     *
     * @return mixed
     */
    public function getDisqusUserId()
    {
        return $this->disqusUserId;
    }

    /**
     * Sets the value of disqusUserId.
     *
     * @param mixed $disqusUserId the disqus user id
     *
     * @return self
     */
    public function setDisqusUserId($disqusUserId)
    {
        $this->disqusUserId = $disqusUserId;

        return $this;
    }

    /**
     * Gets the value of disqusEmail.
     *
     * @return mixed
     */
    public function getDisqusEmail()
    {
        return $this->disqusEmail;
    }

    /**
     * Sets the value of disqusEmail.
     *
     * @param mixed $disqusEmail the disqus email
     *
     * @return self
     */
    public function setDisqusEmail($disqusEmail)
    {
        $this->disqusEmail = $disqusEmail;

        return $this;
    }
}
