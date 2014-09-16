<?php

$lists = '../';
$name = $_GET['id'] ?  $_GET['id'] : $_POST['id'];
$file = $lists . $name;
$text = file_get_contents($file);
$renderer = $_GET['renderer'] ?  $_GET['renderer'] : $_POST['renderer'];

if ('textile' == $renderer) {
	require_once './Textile.php';
	$t = new Textile();
	$text = $t->TextileThis($text);
}

print $text;
