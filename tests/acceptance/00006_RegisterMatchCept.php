<?php
$I = new WebGuy($scenario);
$I->wantTo('Зарегистрировать матч и подтвердить его');

$I->login_as_admin($I);

$I->amOnPage("/");
$I->see("First Test Tournament");
$I->seeLink("Зарегистрировать матч");
$I->click("Зарегистрировать матч");
$I->selectOption("away", "CSKA");

$I->selectOption("goals_h[0][0]", "Аршавин А.");
$I->fillField("goals_h[0][1]", "3");
$I->click(".add_goal_select_home");
$I->selectOption("goals_h[1][0]", "Аршавин А.");
$I->fillField("goals_h[1][1]", "2");
$I->click(".add_goal_select_home");
$I->selectOption("goals_h[2][0]", "Малафеев В.");
$I->fillField("goals_h[2][1]", "4");
$I->click(".add_goal_select_home");
$I->selectOption("goals_h[3][0]", "Автогол");
$I->fillField("goals_h[3][1]", "1");

$I->selectOption("goals_a[0][0]", "Ignashevich S.");
$I->fillField("goals_a[0][1]", "2");
$I->click(".add_goal_select_away");
$I->selectOption("goals_a[1][0]", "Dzagoev A.");
$I->fillField("goals_a[1][1]", "3");
$I->click(".add_goal_select_away");
$I->selectOption("goals_a[2][0]", "Nababkin K.");
$I->fillField("goals_a[2][1]", "1");

$I->click("[type=submit]");
