<?php

use DebugBar\DataCollector\MessagesCollector;
use DebugBar\StandardDebugBar;

$debugbar = new StandardDebugBar();

$dsn = 'mysql:host=localhost;dbname=' . $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
$pdo = new DebugBar\DataCollector\PDO\TraceablePDO(new PDO($dsn, $user, $pass, $options));

/** Log SQL queries. */
$debugbar->addCollector(new DebugBar\DataCollector\PDO\PDOCollector($pdo));

/** Log Session */
$debugbar->addCollector(new MessagesCollector('session'));
$debugbar['session']->info($_SESSION ?? ['There is no session']);

/** Log Cookies */
$debugbar->addCollector(new MessagesCollector('cookies'));
$debugbar['cookies']->info($_COOKIE ?? ['There are no cookies']);

/** Log Server */
$debugbar->addCollector(new MessagesCollector('server'));
$debugbar['server']->info($_SERVER);

$GLOBALS['debugbarRenderer'] = $debugbar->getJavascriptRenderer();