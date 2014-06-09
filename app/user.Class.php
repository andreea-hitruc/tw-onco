<?php

/*
clasa user
va tine evidenta utilizatorilor logati
*/

class user{
	public $data = null;
	private $uFile = 'data/users.xml';//pathul fisierului cu utilizatori
	
	function __construct(){
		if(session_id() == ''){
			session_start();
		}
		
		if(!empty($_SESSION['user'])){//vedem daac utilizatorul are creata o sesiune
			$this->data = &$_SESSION['user'];
		}
	}
	
	function is_logged_in(){//vedem daca un uilizator este logat sau nu
		return empty($this->data)?false:true;
	}
	
	function login($user, $pass){//incercam logarea unui utilizator
		$doc =  new DOMDocument();
		$doc->load($this->uFile);
		$xpath = new DOMXpath($doc);
		
		$result = $xpath->query('/users/user[username="'.$user.'" and password="'.$pass.'"]');
		if($result->length == 0){
			return false;
		}else{
			$uid = $result->item(0)->getAttribute('uid');
			$_SESSION['user'] = array('username' => $user, 'uid' => $uid);
			$this->data = &$_SESSION['user'];
			return true;
		}
	}
	
	function username_exists($username){//verificam daca un username exista deja
		$doc =  new DOMDocument();
		$doc->load($this->uFile);
		$xpath = new DOMXpath($doc);
		
		$result = $xpath->query('/users/user[username="'.$username.'"]');
		if($result->length == 0){
			return false;
		}else{
			return true;
		}
	}
	
	function register($username,$pass){//inregistram utilizatorul si ii cream fisierele de baza
		$doc =  new DOMDocument();
		$doc->load($this->uFile);
		
		$userNode = $doc->createElement('user');
		$usernameNode = $doc->createElement('username');
		$passNode = $doc->createElement('password');
		
		$usernameNode->nodeValue = $username;
		$passNode->nodeValue = md5($pass);
		
		$uid = microtime(true);
		
		$userNode->setAttribute('uid',$uid);
		$userNode->appendChild($usernameNode);
		$userNode->appendChild($passNode);
		
		$doc->firstChild->appendChild($userNode);
		$doc->save($this->uFile);
		
		$xCardDoc = new DOMDocument;
		$xCardDoc->loadXML('<vcards></vcards>');
		$xCardDoc->save('data/xCards/'.$uid.'.xml');
		
		@mkdir('images/'.$uid);
		
		return $uid;
	}
	
	function logout(){//resetam sesiunea
		unset($this->data);
		unset($_SESSION['user']);
	}
}	