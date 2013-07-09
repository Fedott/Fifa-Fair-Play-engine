<?php
$I = new WebGuy($scenario);
$I->wantTo('Создать турнир и добавить туда команды');

\Codeception\Module\WebHelper::admin_login($I);

$I->amOnPage("/");
$context = $I->click("Администрирование");
$I->click("//li//li//a[text()='Турниры']");     // Мега треш =(
$I->see("Турниры");
$I->click("Создать турнир");
$I->fillField("name", "First Test Tournament");
$I->fillField("type", "official");
$I->fillField("scheduled", "Нет");
$I->click("[type=submit]");
$I->see("First Test Tournament");
$I->see("Турнир пока пуст");

$I->click("Добавить команды");
$I->see("Зенит");
$I->see("CSKA");
$I->checkOption("Зенит");
$I->click("[type=submit]");
$I->seeLink("Зенит");
$I->see("X");

$I->click("Добавить команды");
$I->dontSee("Зенит");
$I->see("CSKA");
$I->checkOption("CSKA");
$I->click("[type=submit]");
$I->seeLink("Зенит");
$I->seeLink("CSKA");

