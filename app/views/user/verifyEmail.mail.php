<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="container">
<h3>Verify your email</h3>
<h4>hitarth.io - Stellar Lumens XLM</h4>
<p>Hi</p>
<p>You have just registered your email <strong><?=$compact['data']['email']?></strong> on hitarth.io a Stellar Lumens XLM. Please verify your email by clicking on the link below.</p>
<p><a href="/user/verifyemail/<?=$compact['data']['key']?>/<?=$compact['data']['email_code']?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Verify</a><p>
<h3>Code: <?=$compact['data']['email_code']?></h3>
<p>&nbsp;</p>
<div style="height:20px;background-color:#2F4D11;border-bottom:1px dotted white"></div>
<div style="height:10px;background-color:#A8DE72"></div>
<div class="footer container">
 <p>&copy; hitarth.io <?php echo date('Y') ?> - Stellar Lumens to INR</p>
</div>
<hr>
</body>
</html>