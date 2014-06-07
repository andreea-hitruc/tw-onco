<?php
require_once('app/config.php');

//verificam daca utilizatorul este logat
if(!$user->is_logged_in()){
	header('Location: login.php');
}

$pageTitle = 'Cauta contacte';

$cauta = true;
$ok = false;

if(!empty($_POST)){//verificam daca s-a dat submit la formularul de cautare
$xCard = new xCard('data/xCards/'.$user->data['uid'].'.xml');

$and = 0;


//cream xpath query-ul de cautare
$query = '/vcards/vcard[ ';
if(!empty($_POST['nume'])){
	$query .= 'n/surname[contains(translate(.,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz"),"'.strtolower($_POST['nume']).'")]';
	$and = 1;
	$ok = true;
}

if(!empty($_POST['prenume'])){
	if($and) 
		$query .= ' and ';
	$query .= 'n/given[contains(translate(.,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz"),"'.strtolower($_POST['prenume']).'")]';
	$and = 1;
	$ok = true;
}

if(!empty($_POST['oras'])){
	if($and) 
		$query .= ' and ';
	$query .= 'adr/parameters/label/text[contains(translate(.,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz"),"'.strtolower($_POST['oras']).'")]';
	$and = 1;
	$ok = true;
}

if(!empty($_POST['interese'])){
	if($and) 
		$query .= ' and ';
	$query .= 'interese[contains(translate(.,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz"),"'.strtolower($_POST['interese']).'")]';
	$and = 1;
	$ok = true;
}

$query .= ' ]';

if(!$ok){
	$query = '/vcards/vcard';
}

//aplicam query-ul
$cards = $xCard->query($query);

}

//incarcam template-ul
require_once('app/layout.php');
?>
