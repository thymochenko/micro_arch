<?php
class authUsers {

    static $loginFormAction;
	static $user_type;

	public function __construct()
	{
		if (!isset ($_SESSION)) {
			@session_start();
		}
	}

	public function authStart()
	{
		//login form action igual a variável de server php self
		self::$loginFormAction = $_SERVER['PHP_SELF'];
		//se existir a a var get accesscheck
		if (isset ($_GET['accesscheck']))
		{
			//a variáve session [''prev url] será igual acesschek
			$_SESSION['PrevUrl'] = $_GET['accesscheck'];
		}

		if (isset ($_POST['login'])) {
			$loginUsername=$_POST['login'];
			$password=$_POST['senha'];
			$password=addslashes(htmlspecialchars(strip_tags($password)));
			$MM_fldUserAuthorization="";
			$MM_redirectLoginSuccess = ConfigPath::loginAdminRedirectDefault();
			$MM_redirectLoginFailed="admin.php?erro=true";
			$MM_redirecttoReferrer=false;
           
			Transaction::open();		
			$conn = Transaction::get();
            
			/*prepara a consulta e seleção do tipo de usuário.*/
			$sth=$conn->prepare("SELECT user_type FROM usuarios WHERE username= :loginUsername");
			//máximo 12 caracteres
			$sth->bindParam(':loginUsername', $loginUsername, PDO::PARAM_STR, 12);
            $sth->execute();
			//percorre como array os resultados de $str(responsável por selecionar o tipo de usuário)
            $res = $sth->fetchAll();
			//atribui o tipo de usuário a variável estática $user_type 
            self::$user_type = $res[0][0];
			/*end.*/
	
            /* verifica se a senha do nome de usuário  bate com a senha crypt do banco*/
			$result = $conn->prepare("SELECT * FROM usuarios WHERE username= :loginUsername");
			$result->bindParam(':loginUsername', $loginUsername, PDO::PARAM_STR, 12);
			$result->execute();
			
			$row = $result->fetchAll();
			//atribui a senha crypt que está no BD a var bdBass;
			$bdpass = $row[0][2];
			 /* end*/
			//compara a variável enviada (post) com a senha crypt(se retornar TRUE, loga usuário.
			if(crypt($password,$bdpass) == $bdpass AND $row[0][1] == $loginUsername) {
				$loginStrGroup = "";

				//declare two session variables and assign them
				$_SESSION['MM_Username'] = $loginUsername;
				$_SESSION['MM_UserGroup'] = $loginStrGroup;
				//armazena o tipo de usuário na sessão
				$_SESSION['user_type'] = self::$user_type;

				if (isset ($_SESSION['PrevUrl']) && false) {
					$MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
				}
				header("Location: " . $MM_redirectLoginSuccess);
			} else {
			    //se password for diferente do encryptado que esta no BD
				header("Location: " . $MM_redirectLoginFailed);
			}
		}
	}

	public function startSessionVerify() {
		ob_start();
		if (!isset ($_SESSION)) {
			@ session_start();
		}
		$MM_authorizedUsers = "";
		$MM_donotCheckaccess = "true";

		// *** Restrict Access To Page: Grant or deny access to this page
		function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
			// For security, start by assuming the visitor is NOT authorized.
			$isValid = False;

			// When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
			// Therefore, we know that a user is NOT logged in if that Session variable is blank.
			if (!empty ($UserName)) {
				// Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
				// Parse the strings into arrays.
				$arrUsers = Explode(",", $strUsers);
				$arrGroups = Explode(",", $strGroups);
				if (in_array($UserName, $arrUsers)) {
					$isValid = true;
				}
				// Or, you may restrict access to only certain users based on their username.
				if (in_array($UserGroup, $arrGroups)) {
					$isValid = true;
				}
				if (($strUsers == "") && true) {
					$isValid = true;
				}
			}
			return $isValid;
		}

		$MM_restrictGoTo = ConfigPath::httpPathAppBase();
		if (!((isset ($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
			$MM_qsChar = "?";
			$MM_referrer = $_SERVER['PHP_SELF'];
			if (strpos($MM_restrictGoTo, "?"))
				$MM_qsChar = "&";
			if (isset ($QUERY_STRING) && strlen($QUERY_STRING) > 0)
				$MM_referrer .= "?" . $QUERY_STRING;
			$MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
			@ header("Location: " . $MM_restrictGoTo);
			exit;
		}
	}

	public function sessionClose(){
		if (!isset ($_SESSION))
		{
			@ session_start();
		}
		// ** Logout the current user. **
		
		$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
		if ((isset ($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != ""))
		{
			$logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
		}

		if ((isset ($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
		    
			//to fully log out a visitor we need to clear the session varialbles
			$_SESSION['MM_Username'] = NULL;
			$_SESSION['MM_UserGroup'] = NULL;
			$_SESSION['PrevUrl'] = NULL;
			unset ($_SESSION['MM_Username']);
			unset ($_SESSION['MM_UserGroup']);
			unset ($_SESSION['PrevUrl']);
			$_SESSION['start']=NULL;
            unset($_SESSION);
			$_SESSION=NULL;
			$logoutGoTo = ConfigPath::httpPathAppBase();
			if ($logoutGoTo)
			{
				@header("Location: $logoutGoTo");
				exit;
			}
		}
	}
    
	/*usertypeVerify()
	*@void
	*verifica se um tipo de usuário é autor, se for da exit;
	*/
	public static function usertypeVerify()
	{	    
        if( !authUsers::$user_type =='autor' AND $_SESSION['user_type'] == 'autor'){
            echo "<h1>Você não tem permissão para deletar posts!</h1>";
	        exit();
        }
        else
		{
            TRUE;
        }
	}	
}
?>