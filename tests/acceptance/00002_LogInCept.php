<?php
$I = new WebGuy($scenario);
$I->wantTo('Войти пользователем tester');
$I->amOnPage("/");
$I->click("Войти");
$I->fillField('username', 'tester');
$I->fillField('password', 'qwerty');
$I->click("[type=submit]");
$I->seeLink('Выйти');
$I->seeLink('tester');
$I->click('tester');
$I->see("Редактировать", 'a');
$I->see('Origin: tester');
$I->seeLink("Выйти");
$I->click("Выйти");
