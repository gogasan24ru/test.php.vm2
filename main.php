<?php
require_once "config.php";
require_once "class.php";
$a=Singleton::getInstance(0,$cnf);

echo "=== running setters... \n";
$a->set('body',Array(
        'weight' => 80,
        'height' => 190
        ));


$a->set('home\main',Array(
	'address' => 'ul.push. d.kolotush',
	'pindex' => '123456'
	));

$a->set('home\dacha',Array(
        'station' => 'Kamas',
        'build_num' => 123
        ));


echo "=== running getters... \n";
echo "get('home'):\n";
var_dump($a->get('home'));
echo "get('body\weight'):\n";
var_dump($a->get('body\weight'));
echo "get('home\main\address'):\n";
var_dump($a->get('home\main\address'));



echo "=== Dump all:\n";
$a->dump_storage();
?>
