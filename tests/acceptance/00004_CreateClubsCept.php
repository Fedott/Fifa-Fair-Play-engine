<?php
$I = new WebGuy($scenario);
$I->wantTo("Создать несколько клубов");

$I->login_as_admin($I);

$I->amOnPage("/");
$I->click("Администрирование");
$I->click("Клубы");
$I->click("Создать команду");
$I->fillField("name", "Зенит");
$I->click("[type=submit]");
$I->see("Зенит");
$I->see("Нет игроков");
$I->click("Добавить игроков");
$I->see("Добавление игроков в команду: Зенит");
$I->fillField("last_name[1]", "Малафеев");
$I->fillField("first_name[1]", "Вячеслав");
$I->click("#add_player_button");
$I->fillField("last_name[2]", "Аршавин");
$I->fillField("first_name[2]", "Андрей");
$I->click("[type=submit]");
$I->see("Успешно добавлены");
$I->see("Малафеев Вячеслав");
$I->see("Аршавин Андрей");

$I->click("Администрирование");
$I->click("Клубы");
$I->seeLink("Зенит");
$I->click("Создать команду");
$I->fillField("name", "CSKA");
$I->click("[type=submit]");
$I->see("CSKA");
$I->click("Добавить игроков из wiki");
$I->see("Добавление игроков в команду: CSKA");
$I->fillField("tables", $wiki_table);
$I->click("[type=submit]");
$I->see("Успешно добавлены");

$I->click("Выйти");
