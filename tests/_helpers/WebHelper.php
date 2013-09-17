<?php
namespace Codeception\Module;

// here you can define custom functions for WebGuy

class WebHelper extends \Codeception\Module
{
	static public function login_as_admin(\WebGuy $I)
	{
		self::login($I, 'admin', 'qwerty');
	}

	static public function login_as_tester(\WebGuy $I)
	{
		self::login($I, 'tester', 'qwerty');
	}

	static public function login(\WebGuy $I, $user, $password)
	{
		$I->amOnPage('/');
		$I->click('Войти');
		$I->fillField('username' , $user);
		$I->fillField('password', $password);
		$I->click('[type=submit]');
		$I->seeLink($user);
	}

	public function countElements($expected, $selector, $context = '')
	{
		/** @var \Behat\Mink\Session $session */
		$session = $this->getModule('Selenium2')->session;
		$page = $session->getPage();
		$elements = $page->findAll("css", $selector);
		$this->assertEquals($expected, count($elements));
	}
}