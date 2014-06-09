<?php
require_once('app/config.php');

//verificam daca utilizatorul este logat
if(!$user->is_logged_in()){
	header('Location: login.php');//daca nu este logat il redirectionam catre login
}

$xCard = new xCard('data/xCards/'.$user->data['uid'].'.xml');
$cardf = $xCard->get_cards();

$pageTitle='Edit contact';

$edit = true;
 if(!empty($_POST)){//daca s-a dat submit la formularul de adaugare cream un nou contact
 $idUser= $_POST['idUserTextBox'];
			foreach($cardf as $card)
			{
				if($idUser == $card->getElementsByTagName('uid')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue)
				{	  
					 // print_r ($card->getElementsByTagName('n')->item(0)->getElementsByTagName('surname')->item(0)->nodeValue);die;

					$card->getElementsByTagName('fn')->item(0)->getElementsByTagName('text')->item(0)->nodeValue=$_POST['nume'].' '.$_POST['prenume'];
					$card->getElementsByTagName('n')->item(0)->getElementsByTagName('surname')->item(0)->nodeValue = $_POST['nume'];
					$card->getElementsByTagName('n')->item(0)->getElementsByTagName('given')->item(0)->nodeValue = $_POST['prenume'];
					$card->getElementsByTagName('tel')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue = $_POST['tel'];
					$card->getElementsByTagName('email')->item(0)->getElementsByTagName('text')->item(1)->nodeValue = $_POST['email'];
					$card->getElementsByTagName('adr')->item(0)->getElementsByTagName('text')->item(1)->nodeValue = $_POST['addr'];
					$xCard->save($xCard);
					header('Location: '.$BASE_URL.'#'.$uid);//redirectionam utilizatorul catre contactactul nou creat
				}
			}
 
}
require_once('app/layout.php');//incarcam template-ul
?>
