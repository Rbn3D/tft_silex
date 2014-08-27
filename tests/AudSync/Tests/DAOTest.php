<?php
namespace AudSync\Tests;

use AudSync\Tests\BaseTestCase;
use Silex\WebTestCase;
use AudSync\Model;

class DAOTest extends WebTestCase
{
    use BaseTestCase;
    public function testCreateUserDetails()
    {
        $dao = $this->app['dao_manager']->getUsetDetailsDAO();
        $dao->save(new \AudSync\Model\UserDetails('2572652asfas', '2test@mail.com'));
        //$user = $this->app['daomanager']->getUsetDetailsDAO()->queryOneBy("disqus_user_id", '2572652');

        $user = new \AudSync\Model\UserDetails('2572652', 'test@mail.com');
        $this->assertSame((string) '2572652', (string) $user->getDisqusUserId());
    }

    public function testQueryAll()
    {
    	$dao = $this->app['dao_manager']->getUsetDetailsDAO();
    	$users = $dao->queryAll();

    	var_dump($users);

    	$this->assertTrue(count($users) > 0, "queryAll() didn't retrieve any users");
    }
}