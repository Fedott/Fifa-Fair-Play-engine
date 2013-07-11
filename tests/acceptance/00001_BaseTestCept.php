<?php
$I = new WebGuy($scenario);
$I->wantTo('Общая проверка основных возможностей');

/**
 * Регистрация
 */
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
$I->see("Редактировать");
$I->see('Origin: tester');
$I->seeLink("Выйти");
$I->click("Выйти");

/*
 * Логин
 */
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

/**
 * Добавление роли
 */
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

/**
 * Создание клубов
 */
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


/**
 * Создание турнира
 */
$I->login_as_admin($I);

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

$I->click("Зенит");
$I->click("Сменить управляющего командой");
$I->selectOption("user_id", "admin");
$I->click("[type=submit]");
$I->see("Команды учавствующие в турнире");
$I->click("Зенит");
$I->see("Управляет командой: admin");
$I->moveBack();

$I->click("CSKA");
$I->click("Сменить управляющего командой");
$I->selectOption("user_id", "tester");
$I->click("[type=submit]");
$I->see("Команды учавствующие в турнире");
$I->click("CSKA");
$I->see("Управляет командой: tester");
$I->moveBack();

$I->reloadPage();

$I->click("Редактировать");
$I->selectOption("active", "Да");
$I->selectOption("visible", "Да");
$I->click("[type=submit]");

$I->click("Выйти");

/**
 * Регистрация матча
 */
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

$I->see("Матч зарегистрирован");
$I->click("button.close");
$I->dontSee("Матч зарегистрирован");

$I->seeLink("Зенит");
$I->seeLink("CSKA");

$I->see("А. Аршавин");
$I->see("В. Малафеев");
$I->see("Автогол");
$I->see("S. Ignashevich");
$I->see("A. Dzagoev");
$I->see(" K. Nababkin");

$I->see("10 : 6");
$I->see("First Test Tournament");
$I->seeLink("Добавить видео к матчу");

$I->see("Добавить комментарий");

$I->amOnPage("");
$I->seeLink("First Test Tournament");
$I->see("Аршавин Андрей Зенит 5", "tr");
$I->see("Малафеев Вячеслав Зенит 4", "tr");
$I->see("Dzagoev Alan CSKA 3", "tr");
$I->see("Ignashevich Sergei CSKA 2", "tr");
$I->see("Nababkin Kirill CSKA 1", "tr");
$I->see("Зенит 10 - 6 CSKA", "tr");

$I->click("Выйти");


/**
 * Подтверждение матча
 */
$I->login_as_tester($I);

$I->see("Зенит 10 - 6 CSKA", "tr.error");
$I->click("10 - 6", "tr.error");

$I->see("Вы подтверждаете результат матча:");
$I->see("Зенит 10 - 6 CSKA");
$I->see("А. Аршавин - 3");
$I->see("А. Аршавин - 2");
$I->see("В. Малафеев - 4");
$I->see("Автогол - 1");

$I->see("S. Ignashevich - 2");
$I->see("A. Dzagoev - 3");
$I->see("K. Nababkin - 1");

$I->click("[type=submit]");

$I->seeLink("Зенит");
$I->seeLink("CSKA");

$I->see("А. Аршавин");
$I->see("В. Малафеев");
$I->see("Автогол");
$I->see("S. Ignashevich");
$I->see("A. Dzagoev");
$I->see(" K. Nababkin");

$I->see("10 : 6");
$I->see("First Test Tournament");
$I->seeLink("Добавить видео к матчу");

$I->see("Добавить комментарий");

