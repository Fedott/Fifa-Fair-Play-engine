<?php
$I = new WebGuy($scenario);
$I->wantTo('Дать пользователю tester роль тренера');

$I->login_as_admin($I);

$I->amOnPage('/');
$I->click("Администрирование");
$I->click('Пользователи');
$I->seeInCurrentUrl('/admin/user');
$I->seeLink('tester');
$I->click('tester');
$I->see('Редактирование пользователя, tester');
$I->selectOption('roles[]', array('coach', 'login'));
$I->click('[type=submit]');
$I->seeInCurrentUrl('/admin/user');
$I->seeLink('tester');
$I->click('tester');
$I->seeOptionIsSelected('#field-roles', 'login', 'coach');
$I->click("Выйти");