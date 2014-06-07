<?php
require_once('app/config.php');

$error = '';
//verificam daca s-a dat submit la formularul de logare
if(!empty($_POST)){
	if(!$user->login($_POST['username'], md5($_POST['password']))){
		$error = 'Username sau parola gresita.';
	}
} 

//verificam daca utilizatorul este logat
if($user->is_logged_in()){
	header('Location: '.$BASE_URL.'/index.php');
}

//incarcam html-ul de logare
require_once('app/login.layout.php');
?>
