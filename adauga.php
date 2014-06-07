<?php
require_once('app/config.php');

//verificam daca utilizatorul este logat
if(!$user->is_logged_in()){
	header('Location: login.php');//daca nu este logat il redirectionam catre login
}

$pageTitle='Adauga contact nou';

$adauga = true;

if(!empty($_POST)){//daca s-a dat submit la formularul de adaugare cream un nou contact

	$xCardXML = new DOMDocument;
	$xCardXML->load('data/xCard.xml');
	$node = $xCardXML->getElementsByTagName('vcard')->item(0);
	$uid = microtime(true);
	$node->getElementsByTagName('fn')->item(0)->getElementsByTagName('text')->item(0)->nodeValue = $_POST['nume'].' '.$_POST['prenume'];
	$node->getElementsByTagName('n')->item(0)->getElementsByTagName('surname')->item(0)->nodeValue = $_POST['nume'];
	$node->getElementsByTagName('n')->item(0)->getElementsByTagName('given')->item(0)->nodeValue = $_POST['prenume'];
	$node->getElementsByTagName('tel')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue = $_POST['tel'];
	$node->getElementsByTagName('email')->item(0)->getElementsByTagName('text')->item(1)->nodeValue = $_POST['email'];
	$node->getElementsByTagName('adr')->item(0)->getElementsByTagName('text')->item(1)->nodeValue = $_POST['addr'];
	$node->getElementsByTagName('bday')->item(0)->getElementsByTagName('date')->item(0)->nodeValue = $_POST['bday'];
	$node->getElementsByTagName('uid')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue = $uid;
	$node->getElementsByTagName('photo')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue = !empty($_POST['newName'])?'images/' .$user->data['uid'].'/'. $_POST['newName']:'';
	$node->getElementsByTagName('interese')->item(0)->nodeValue = $_POST['interese'];
	
	$xCard = new xCard('data/xCards/'.$user->data['uid'].'.xml');
	$xCard->add($node);
	header('Location: '.$BASE_URL.'#'.$uid);//redirectionam utilizatorul catre contactactul nou creat
}

require_once('app/layout.php');//incarcam template-ul
?>
