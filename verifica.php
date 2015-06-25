<?php
	session_start();
    include("Conexion/conn.php");
	function verificaremail($login){ 
		if (!ereg("^([a-zA-Z0-9._]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,4})$",$login)){ 
		  return FALSE; 
		} else { 
		   return TRUE; 
		} 
	}
	$bandera = 0;
	$login = htmlspecialchars(trim($_POST['login']));
	if (verificaremail($login)) {//$pass1 = md5(trim($_POST['pass'])); // encriptamos en MD5 para despues comprar (Modificado)
					$pass1 = md5(trim($_POST['pass']));// $query="SELECT * FROM usuarios WHERE login='$login and activo = 1"; Antes
					$link=@mysql_connect($server, $user, $pass);
				 	$query = "SELECT idUsr,email,privilegiosUsr FROM ".$db.".usuarios WHERE email ='".$login."' && pass= '".$pass1."'";
					$result=mysql_query($query)or die(mysql_error());
					  if(mysql_num_rows($result)==1){ // Si encuentra el Usuario
						 $array=mysql_fetch_array($result);
						//  if($array["password"]==crypt($pass,"semilla") ){ // Antes
						 /* Comprobamos que el password encriptado en la BD coincide con el password que nos han dado al encriptarlo. Recuerda usar semilla para encriptar los dos passwords. */
						 $_SESSION["idUsuario"] = $array["idUsr"];
						 $_SESSION["email"]=$array["email"];
						 $_SESSION["admin"]=$array["privilegiosUsr"];
						 $bandera =1;
					 }  
					   else {
							 $bandera =0;
					} 
		}else{ 
				$bandera =0;
	}
	if ($bandera == 1){
			echo"<script language='javascript'>window.location='capNoticia.php'</script>;";
			 //header('Location: capNoticia.php');
	} else{
		echo"<script language='javascript'>window.location='index.php'</script>;";
		echo "Bandera 0"; //header('Location: index.php');
	}	
?>