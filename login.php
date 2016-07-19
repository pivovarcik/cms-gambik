<?php
/*
   * login.php
   * 12.4.11 Trvale prihlaseni - stillIn dle nastaveni v COOKIES
*/
session_start();
header('Content-type: text/html; charset=utf-8');
header('Cache-Control: no-cache');
header('Pragma: nocache');
include dirname(__FILE__) . "/inc/init_spolecne.php";

if (LOGIN_STATUS == "ON") {
	@header("Location: " . URL_HOME_REL . "admin/", true, 303);
	exit;
}
$userController = new UserController();
$GAuth = G_Authentification::instance();

//print_r($_POST);
$prihlaseni = "Log In";
$prihlaseni = "Přihlášení do Administrace";

$zapomenute_heslo = "Lost your password?";
$zapomenute_heslo = "Zapomněli jste heslo?";
$trvale = "Remember Me";
$trvale = "Zapamatovat si";

if (isset($_GET["action"]) && $_GET["action"] == "lostpassword") {

}
$userController->lostPasswordAction();
$userController->changePasswordAction();
//print_r($_SESSION);
//$redirect = isset($_POST["redirect"])? $_POST["redirect"] : $_SERVER["HTTP_REFERER"];
//$redirect = !empty($redirect) ? $redirect : URL_HOME . "admin/";
//$redirect = URL_HOME2 . "admin/";


//$redirect = isset($_GET["redirect"])? $_GET["redirect"] : $_SERVER["HTTP_REFERER"];
$redirect = isset($_GET["redirect"])? $_GET["redirect"] : URL_HOME_REL;

$redirect = !empty($redirect) ? $redirect : URL_HOME_REL;

if ($GAuth->islogIn())
{
	print '<meta content="1; URL=' . $redirect . '" http-equiv="Refresh">';
	print 'Byly jste úspěšně přihlášeni. Probíhá přesměrování. Pokud nedojde k přesměrování <a href="' . $redirect . '">klikněte zde</a>';

	@header("Refresh: 1;url=" . $redirect);
	exit();
} else {
	if ($userController->logInAction())
	{
		@header("Location: " . $redirect . "", true, 303);
		/*
		print '<meta content="1; URL=' . $redirect . '" http-equiv="Refresh">';
		print 'Byly jste úspěšně přihlášeni. Probíhá přesměrování. Pokud nedojde k přesměrování <a href="' . $redirect . '">klikněte zde</a>';

		@header("Refresh: 1;url=" . $redirect);*/
		exit();
	}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="cs-CZ" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  	<meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Přihlášení do administrace</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php print URL_HOME_REL; ?>js/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php print URL_HOME_REL; ?>js/sb-admin/sb-admin-2.css" rel="stylesheet">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
<?php
if (isset($_GET["action"]) && $_GET["action"] == "changepassword") {

	$form = new Application_Form_AdminUserPasswordChange();
	?>
                    <div class="panel-heading">
                        <h3 class="panel-title">Změna hesla</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <?php print $form->getElement("pwd1")->render();?>
                                </div>
                                <div class="form-group">
                                	<?php print $form->getElement("pwd2")->render();?>

                                </div>
                                <?php print $form->getElement("changepassword")->render();?>
                                <?php print $form->getElement("key")->render();?>
                                <div class="form-group">
                                            <p class="form-control-static"><a href="?">Přihlásit se</a></p>
                                        </div>

                            </fieldset>
                        </form>
                    </div>
	<?php } ?>

<?php
if (isset($_GET["action"]) && $_GET["action"] == "lostpassword") {

	$form = new Application_Form_AdminUserLostPassword();
	?>
                    <div class="panel-heading">
                        <h3 class="panel-title">Zapomenuté heslo</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <?php print $form->getElement("email")->render();?>
                                </div>

                                <div class="form-group">
                                	<img src="/plugins/Captcha/captcha.php"/>
                                </div>

                                <div class="form-group">
                                	<?php print $form->getElement("captcha")->render();?>
                                </div>
                                <?php print $form->getElement("lostpassword")->render();?>
                                <div class="form-group">
                                            <p class="form-control-static"><a href="?">Přihlásit se</a></p>
                                        </div>

                            </fieldset>
                        </form>
                    </div>
<?php } ?>

<?php
if (!isset($_GET["action"])) {

$form = new Application_Form_AdminUserLogin();
?>
                    <div class="panel-heading">
                        <h3 class="panel-title">Přihlášení do administrace</h3>
                    </div>
                    <div class="panel-body">
                    <?php print $form->result(); ?>
                        <form role="form" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <?php print $form->getElement("nick")->render();?>
                                </div>
                                <div class="form-group">
                                	<?php print $form->getElement("pwd")->render();?>

                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Trvalé přihlášení
                                    </label>
                                </div>
                                <?php print $form->getElement("login")->render();?>
                                <?php print $form->getElement("redirect")->render();?>
                                <div class="form-group">
                                            <p class="form-control-static"><a href="?action=lostpassword">Zapomněli jste heslo?</a></p>
                                            <p class="form-control-static"><a href="<?php print URL_HOME_REL; ?>" title="Návrat na <?php print SERVER_NAME; ?>">Návrat na <?php print SERVER_NAME; ?></a></p>
                                        </div>

                            </fieldset>
                        </form>
                    </div>
	<?php } ?>



                </div>
            </div>
        </div>

                            <div class="text-center out-links"><a href="http://www.pivovarcik.cz/">&copy; 2006-<?php print date("Y"); ?> CMS Gambik</a></div>
    </div>

    <!-- jQuery -->
    <script src="<?php print URL_HOME_REL; ?>js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php print URL_HOME_REL; ?>js/bootstrap/bootstrap.min.js"></script>

    <script src="<?php print URL_HOME_REL; ?>js/sb-admin/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php print URL_HOME_REL; ?>js/sb-admin/sb-admin-2.js"></script>

</body>

</html>
