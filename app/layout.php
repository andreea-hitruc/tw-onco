<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#"  lang="ro"><!--xmlns:fb="fb: http://ogp.me/ns/fb#"-->
<head>
    <title>ONCO</title>
	<meta name="ROBOTS" content="INDEX, FOLLOW"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php print $BASE_URL;?>css/style.css" rel="stylesheet"   media="screen">
	<script> var BASE_URL = '<?php print $BASE_URL;?>';</script>
</head>
<body>
<header>
<div class="header">
<div class="center">
<h1 class="logo">ONCO</h1>
<nav>
<ul class="nav">
	<li><a href="index.php">Acasa</a></li>
	<li><a href="adauga.php">Adauga</a></li>
	<li><a href="cauta.php">Cauta</a></li>
	<li><a href="export.php">Export</a></li>
	<li><a href="logout.php">Logout</a></li>
</ul>
</nav>
<div class="div-clear"></div>
</div>
</div>
</header>
<div class="paralax"></div>
<section>
<div class="section">
<div class="center">
<?php

if(!empty($cauta) && $cauta == true){?>
<h2>Cauta</h2>
<div class="div-clear"></div>
<form method="post">
Nume: <input type="text" name="nume"/> Prenume: <input type="text" name="prenume"/> Oras: <input type="text" name="oras"/> Varsta: <input type="text" name="varsta"/> 
Interese: <input type="text" name="interese"/> 
<input class="button-style" type="submit" value="Cauta"/>
</form>
<?php
}

if (!empty($adauga) && $adauga == true){?>
<h2>Adauga contact</h2>
<div class="div-clear"></div>
<form method="post" id="formAdauga">
<div id="photo_preview">

</div>
<div id="fa_poza" style="float:right;display:none;">
<div id="snapshot_div">
<img src="" id="snapshot"/><br/>
<a href="#" id="save_snapshot" style="display:none;">Salveaza</a>
</div>

<div id="video_div">
<video autoplay id="main-video" width="300" height="220"></video><br/>
<a href="#" id="take_snapshot">Captureaza</a>
</div>

<canvas style="display:none;" width="300" height="220" id="canvas"></canvas>
</div>
<table>
<tr>
<td>
<label>Nume:</label>
</td>
<td>
<input type="text" id="nume" name="nume"/>
</td>
</tr>
<tr>
<td>
<label>Prenume:</label>
</td>
<td>
<input type="text" id="prenume" name="prenume"/>
</td>
</tr>
<tr>
<td>
<label>Telefon:</label>
</td>
<td>
<input type="text" id="tel" name="tel"/>
</td>
</tr>
<tr>
<td>
<label>Email:</label>
</td>
<td>
<input type="email" name="email" id="email"/>
</td>
</tr>
<tr>
<td>
<label>Adresa:</label>
</td>
<td>
<input type="text" name="addr"/>
</td>
</tr>
<tr>
<td>
<label>Data nasterii:</label>
</td>
<td>
<input type="date" name="bday"/>
</td>
</tr>
<tr>
<td>
<label>Interese:</label>
</td>
<td>
<input type="text" name="interese"/>
</td>
</tr>
<tr>
<td>
<label>Photo:</label>
</td>
<td>
<a href="#" id="browse_foto" title="">Cauta</a> sau <a href="#" id="capture-button" title="">Captura</a>
<input type="hidden" name="newName" id="newName" value=""/>
</td>
</tr>
</table>

<input class="button-style" type="submit" value="Adauga"/>
<div class="div-clear"></div>
</form>
<form id="formUpload" style="margin-top:-1500px">
<input type="file" id="file" name="photo" />
</form>
<div class="div-clear"></div>
<script>
document.getElementById('formAdauga').onsubmit = function(){
	var nume = document.getElementById('nume').value;
	var prenume = document.getElementById('prenume').value;
	var tel = document.getElementById('tel').value;
	var email = document.getElementById('email').value;
	
	if(!tel && !email)
		return false;
	
	if(!nume && !prenume)
		return false;
}

document.getElementById('file').onchange = function(){
	var url = BASE_URL+'upload.php';
	upload(url,function(data){
		if(data['src']){
			document.getElementById('photo_preview').innerHTML = '<img src="'+BASE_URL+'images/'+data['uid']+'/'+data['src']+'" alt=""/>';
			document.getElementById('newName').value = data['src'];
		}else{
			document.getElementById('photo_preview').innerHTML = data['error'];
		}
	});
	this.value = '';
}

function save_snapshot(){
	var url = BASE_URL+'save_snapshot.php';
	var img = document.querySelector('#snapshot').src;
	post(url,{'foto':img},function(data){
		data = eval('('+data+')');
		if(data['src']){
			document.getElementById('photo_preview').innerHTML = '<img src="'+BASE_URL+'images/'+data['uid']+'/'+data['src']+'" alt=""/>';
			document.getElementById('newName').value = data['src'];
		}else{
			document.getElementById('photo_preview').innerHTML = data['error'];
		}
	});
}

document.getElementById('browse_foto').onclick = function(){
	document.getElementById('file').click();
	return false;
}
</script>
<script>
function errorCallback(e) {
  document.querySelector('#fa_poza').style.display = 'none';
  if (e.code == 1) {
    alert('User denied access to their camera');
  } else {
    alert('getUserMedia() not supported in your browser.');
  }
}

(function() {
var video = document.querySelector('#main-video');
var button = document.querySelector('#capture-button');
var canvas = document.querySelector('#canvas');
var ctx = canvas.getContext('2d');
var localMediaStream = null;

button.addEventListener('click', function(e) {
	
  if (navigator.getUserMedia) {
    navigator.getUserMedia('video', function(stream) {
      video.src = stream;
      video.controls = false;
      localMediaStream = stream;
    }, errorCallback);
	document.querySelector('#fa_poza').style.display = 'block';
  } else if (navigator.webkitGetUserMedia) {
    navigator.webkitGetUserMedia({video: true}, function(stream) {
      video.src = window.URL.createObjectURL(stream);
      video.controls = false;
      localMediaStream = stream;
    }, errorCallback);
	document.querySelector('#fa_poza').style.display = 'block';
  } else {
    errorCallback({target: video});
  }
}, false);

	function snapshot() {
		if (localMediaStream) {
		  ctx.drawImage(video, 0, 0,300,220);
		  document.querySelector('#snapshot').src = canvas.toDataURL('image/jpeg');
		  document.querySelector('#save_snapshot').style.display = 'inline';
		}
	}
	document.querySelector('#take_snapshot').addEventListener('click',snapshot,false);
	video.addEventListener('click', snapshot, false);
	document.querySelector('#save_snapshot').addEventListener('click',save_snapshot,false);
})();
</script>
<?php }

if(!empty($export) && $export == true){?>
<h2>Exporta contactele</h2>
<div class="div-clear"></div>
Alege un format: 
<select onchange="if (this.value) window.location.href=this.value">
    <option value="">Alege:</option>
    <option value="?csv=1">csv</option>
    <option value="?vcard=1">vcard</option>
	<option value="?atom=1">atom</option>
</select>
<?php
if(!empty($download)){
	print '<a href="'.$BASE_URL.$download.'" title="">download</a>';
}

}

if(!empty($cards)){
	print '<h2>Contacte</h2><div class="div-clear"></div><div class="contacte">';
	foreach($cards as $card){?>
		<?php $photo = $card->getElementsByTagName('photo')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue;?>

	<div class="contact-box" id="<?php print $card->getElementsByTagName('uid')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue;?>">
		<a href="#" title="" class="delete" onclick="deleteContact('<?php print $card->getElementsByTagName('uid')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue;?>')"></a>
		<h4><?php print $card->getElementsByTagName('fn')->item(0)->getElementsByTagName('text')->item(0)->nodeValue; ?></h4>
		<img src="<?php print !empty($photo)?$BASE_URL.$photo:$BASE_URL.'images/no_photo.jpg';?>" alt=""/>
		 <?php print $card->getElementsByTagName('tel')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue;?><br/>
		<?php print $card->getElementsByTagName('email')->item(0)->getElementsByTagName('text')->item(1)->nodeValue;?><br/>
		<?php print $card->getElementsByTagName('adr')->item(0)->getElementsByTagName('parameters')->item(0)->getElementsByTagName('label')->item(0)->getElementsByTagName('text')->item(0)->nodeValue;?>
	</div>
<?php
	}
	?>
	</div>
	<?php
}
?>
</div>
<div class="div-clear"></div>
</div>
<div class="div-clear"></div>
</section>
<footer>
<div class="footer">
<div class="center">
Copyright &copy; 2014 ONCO
</div>
</div>
</footer>
<script src="<?php print $BASE_URL;?>js/functions.js"></script>
</body>
</html>