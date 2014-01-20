<form method="post" action="">
<?php
	include('recaptcha.class.php');
	
	$captcha	=	new Recaptcha;
	$captcha->publicKey		=	"6Le2EMUSAAAAADA7a7PtrowTFR2wsmYhqEtUxVdS";
	$captcha->privateKey	=	"6Le2EMUSAAAAAJL-6puUs6YnLaV-lI-6EXyi5UJf";

	if(isset($_POST) AND !empty($_POST)){
		$captcha->checkCaptcha();
		$debug	=	$captcha->getError();	
		if(!$debug){
			echo 'All right';
		}
		else{
			echo $debug;
		}
	}
	
	echo $captcha->getCaptcha();
?>
<input type="submit" value="Check captcha" />
</form>
