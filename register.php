<?php
require_once('app/config.php');

$error = '';
//verificam daca s-a dat submit la formularul de inregistrare
if(!empty($_POST)){
	if(!empty($_POST['username']) && !empty($_POST['pass'])){
		if(strlen($_POST['pass']) < 6){
			$error = 'Parola trebuie sa contina minim 6 caractere.';
		}else if($_POST['pass'] != $_POST['re-pass']){
			$error = 'Re-password trebuie sa fie identic cu Password.';
		}else if(strlen($_POST['username']) < 3){
			$error = 'Username trebuie sa contina minimi 3 caractere.';
		}else if($user->username_exists($_POST['username'])){
			$error = 'Acest username exista deja.';
		}else{
			$uid = $user->register($_POST['username'],$_POST['pass']);
			$user->login($_POST['username'],md5($_POST['pass']));
		}
	}else{
		$error = 'Toate campurile sunt obligatorii.';
	}
}


if($user->is_logged_in()){
	header('Location: '.$BASE_URL.'/index.php');
}

require_once('app/register.layout.php');
?>