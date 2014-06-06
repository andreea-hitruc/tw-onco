<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#"  lang="ro"><!--xmlns:fb="fb: http://ogp.me/ns/fb#"-->
<head>
    <title><?php print empty($pageTitle)?'ONCO':$pageTitle;?></title>
	<meta name="ROBOTS" content="INDEX, FOLLOW"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php print $BASE_URL;?>/css/style.css" rel="stylesheet"   media="screen">
	<script> var BASE_URL = '<?php print $BASE_URL;?>';</script>
</head>
<body>
<div class="register">
<h2>Register</h2>
<?php
if(!empty($error))
	print '<p class="error">'.$error.'</p>';
?>
<form method="post">
<div class="row">User-name: <input type="text" name="username" value="<?php if(!empty($_POST['username'])) print $_POST['username'];?>"/></div>
<div class="row">Password: <input type="password" name="pass"/></div>
<div class="row">Re-password: <input type="password" name="re-pass"/></div>
<br/>
<a href="login.php">Login</a>
<br/>
<br/>
<input type="submit" value="Register" />
</form>
</div>
</body>
</html>