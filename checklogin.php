<?php
	// Als je methoden uit de LoginClass wilt gebruiken
	//  dan moet je deze class eerst toevoegen met require_once
	require_once("class/LoginClass.php");
	
	//Check of beide velden zijn ingevoerd	
	if ( !empty($_POST['email']) && !empty($_POST['password']))
	{
		//Check of de ingevulde emailadres en wachtwoord bestaan in database	
		if (LoginClass::check_if_email_password_exists($_POST['email'],
													   $_POST['password']))
		{
			//echo "De combinatie bestaat";exit();	
			//Verwijs door naar de homepage van de geregistreerde gebruiker
			//echo "Record bestaat in de database";
			$user_object = 
				LoginClass::find_user_by_email_password($_POST['email'],
														$_POST['password']);
						
			$_SESSION['id'] = $user_object->get_id();
			$_SESSION['userrole'] = $user_object->get_userrole();
			
			switch ($_SESSION['userrole'])
			{
				case 'root':
					header("location:index.php?content=root_homepage");
				break;
				case 'admin':
					header("location:index.php?content=admin_homepage");			
				break;
				case 'customer':
					header("location:index.php?content=customer_homepage");
				break;			
			}
		}
		else
		{
			//Blijkbaar is het record niet gevonden in de database
			echo "De ingevoerde combinatie van emailadres - wachtwoord is ons niet bekend. U wordt 	doorgestuurd naar de inlogpagina";
			header("refresh:4; url=index.php?content=login_form");
		}		
	}
	else
	{
		echo 'U heeft beide of een van beide velden niet ingevuld. 
			  U wordt doorgestuurd naar de inlogpagina';
		header("refresh:4;url=index.php?content=login_form");
	}

?>
