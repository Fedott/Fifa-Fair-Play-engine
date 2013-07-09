<?php
$I = new WebGuy($scenario);
$I->wantTo('Зарегистритоваться пользователем tester');
$I->amOnPage("/");
$I->click("Зарегистрироваться");
$I->see("Регистрация");
$I->fillField('username', 'tester');
$I->fillField('password', 'qwerty');
$I->fillField('password_confirm', 'qwerty');
$I->fillField('email', 'test@tester.ru');
$I->fillField('skype', 'tester');
$I->fillField('origin', 'tester');
$I->click('input[type="submit"]');
$I->seeLink("tester", '/profile');
$I->click("tester");
$I->see("Редактировать", 'a');
$I->see('Origin: tester');
$I->seeLink("Выйти");
$I->click("Выйти");
