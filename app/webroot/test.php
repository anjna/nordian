<?php echo phpinfo();die;
require_once 'sweetcaptcha.php';
?>

<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
</head>

<? if (empty($_POST)) {?>

	<div id="captcha">
	<form method="post" action="">
	<?= $sweetcaptcha->get_html()?>
	<input type="submit" value="submit"/>
	</form>
	</div>

<? } else {

        $scValues = array('sckey' => $_POST['sckey'], 'scvalue' => $_POST['scvalue'], 'scvalue2' => $_POST['scvalue2']);
        if ($sweetcaptcha->check($scValues) == "true") {
            echo 'GOOD CAPTCHA';
        }
        else {
            echo 'BAD CAPTCHA';
        }
    
} ?>
