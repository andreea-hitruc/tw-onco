<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#"  lang="ro"><!--xmlns:fb="fb: http://ogp.me/ns/fb#"-->
<head>
    <title><?php print empty($pageTitle)?'ONCO':$pageTitle;?></title>
	<meta name="ROBOTS" content="INDEX, FOLLOW"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php print $BASE_URL;?>css/style.css" rel="stylesheet"   media="screen">
	<script> var BASE_URL = '<?php print $BASE_URL;?>';</script>
</head>
<body>
<div class="loginBox">
<h2>Login</h2>
<form method="post">
<label>User-name: </label>
<input type="text" name="username" placeholder="Username"/>
<label>Password: </label>
<input type="password" name="password" placeholder="Password"/>
<br/>
<a href="register.php">Register</a>
<br/><br/>
<input type="submit" value="Login"/>
<?php 
if(!empty($error)) print '<div class="error">'.$error.'</div>';
 ?>
</form>
</div>
</body>
</html>