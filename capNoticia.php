<?php
ob_start("ob_gzhandler"); 
//Las funciones ob_start y 
//ob_end_flush te permiten 
//escojer en qué momento 
//enviar el resultado de un 
//script al navegador. Si 
//no las utilizamos estamos 
//obligados a que nuestra  
//primera línea de código 
//sea session_start() u 
//obtendremos un error 
//Iniciamos o retomamos la 
//sesión 
session_start();
if(isset($_SESSION["email"]))
{
   $acceso=$_SESSION["email"];
   if(isset($_SESSION["admin"])) $admin = $_SESSION["admin"];else $admin=false;
}
else
{
	header("Location: index.php");
}
/**
 * Reemplaza todos los acentos por sus equivalentes sin ellos
 *
 */
 
function sanear_string($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
	$string = str_replace(
        array(" "),
		'_',  
		$string
 	);
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "<", ";", ",", ":",
             ".", " ","°"),
        '',
        $string
    );
 
    return $string;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INUMEDH</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/easySlider1.7.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
    <script type="text/javascript">
var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
   return (!evt) ? event : evt;
}

//Aqui se hace lamagia... jejeje, esta funcion crea dinamicamente los nuevos campos file
addCampo = function () { 
//Creamos un nuevo div para que contenga el nuevo campo
   nDiv = document.createElement('div');
//con esto se establece la clase de la div
   nDiv.className = 'archivo';
//este es el id de la div, aqui la utilidad de la variable numero
//nos permite darle un id unico
   nDiv.id = 'file' + (++numero);
//creamos el input para el formulario:
   nCampo = document.createElement('input');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php
   nCampo.name = 'archivos[]';
//Establecemos el tipo de campo
   nCampo.type = 'file';
//Ahora creamos un link para poder eliminar un campo que ya no deseemos
   a = document.createElement('a');
//El link debe tener el mismo nombre de la div padre, para efectos de localizarla y eliminarla
   a.name = nDiv.id;
//Este link no debe ir a ningun lado
   a.href = '#';
//Establecemos que dispare esta funcion en click
   a.onclick = elimCamp;
//Con esto ponemos el texto del link
   a.innerHTML = 'Eliminar';
//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la función appendChild para adicionar el campo file nuevo
   nDiv.appendChild(nCampo);
//Adicionamos el Link
   nDiv.appendChild(a);
//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta función obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminación:
   container = document.getElementById('adjuntos');
   container.appendChild(nDiv);
}
//con esta función eliminamos el campo cuyo link de eliminación sea presionado
elimCamp = function (evt){
   evt = evento(evt);
   nCampo = rObj(evt);
   div = document.getElementById(nCampo.name);
   div.parentNode.removeChild(div);
}
//con esta función recuperamos una instancia del objeto que disparo el evento
rObj = function (evt) { 
   return evt.srcElement ?  evt.srcElement : evt.target;
}
</script>

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es">
<!--<![endif]-->
<head>

<!-- Basic Page Needs ================================================== 
================================================== -->

<meta charset="utf-8">
<title>INUMEDH</title>
<meta name="description" content="INUMEDH Instituto Universitario de Ciencias Medicas y Humanisticas de Nayarit">
<meta name="author" content="INUMEDH">
<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

<!-- Mobile Specific Metas ================================================== 
================================================== -->

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

<!-- CSS ==================================================
================================================== -->

<link rel="stylesheet" href="css/base.css">
<link rel="stylesheet" href="css/skeleton.css">
<link rel="stylesheet" href="css/screen.css">
<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" />

<!-- Favicons ==================================================
================================================== -->

<link rel="shortcut icon" href="images/favicon.png">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

<!-- Google Fonts ==================================================
================================================== -->

<link href='http://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
</head>
<body>

<!-- Home - Content Part ==================================================
================================================== -->
<div id="header">
  <div class="container header"> 
    <!-- Header | Logo, Menu
		================================================== -->
    <header>
      <div class="logo"><a href="index.html"><img src="images/logo.png" alt="" /></a></div>
      <div class="mainmenu">
        <div id="mainmenu">
          <ul class="sf-menu">
            <li><a href="index.html"  id="visited"><span class="home"><img src="images/home.png" alt="" /></span>Inicio</a></li>
            <li><a href="nosotros.html"><span class="home"><img src="images/about.png" alt="" /></span>Nosotros</a></li>
            <li><a href="aspirantes.html"><span class="home"><img src="images/portfolio.png" alt="" /></span>Aspirantes</a>
              <ul>
                <li><a href="#.html">Opcion1 Aspirantes</a></li>
              </ul>
            </li>
            <li><a href="alumnos.html"><span class="home"><img src="images/blog.png" alt="" /></span>Alumnos</a>
              <ul>
                <li><a href="../teleeducacion">Plataforma INUMEDH</a></li>
              </ul>
              <ul>
                <li><a href="../biblioteca">Biblioteca Virtual</a></li>
              </ul>
            </li>
            <li><a href="academicos.html"><span class="home"><img src="images/features.png" alt="" /></span>Academicos</a></li>
            <li><a href="contacto.html"><span class="home"><img src="images/contact.png" alt="" /></span>Contacto</a></li>
          </ul>
        </div>
        
        <!-- Responsive Menu -->
        
        <form id="responsive-menu" action="#" method="post">
          <select>
            <option value="">Navega</option>
            <option value="index.html">Inicio</option>
            <option value="nosotros.html">Nosotros</option>
            <option value="aspirantes.html">Aspirantes</option>
            <option value="#.html">Opcion1 Aspirantes</option>
            <option value="alumnos.html">Alumnos</option>
            <option value="../teleeducacion">Plataforma INUMEDH</option>
            <option value="../biblioteca">Plataforma INUMEDH</option>
            <option value="academicos.html">Academicos</option>
            <option value="contacto.html">Contacto</option>
          </select>
        </form>
      </div>
    </header>
  </div>
</div>
<!-- About Content Part - Box One ==================================================
================================================== -->
<div class="blankSeparator"></div>
<div class="container">
  <div>
    <section>
      <article>
        	<div id="cuerpo">
                <div id="contenido">
                <div id="lateral">
                        <ul>
                        	<li><a href="detalle.php">Mi cuenta</a></li>
                            <li><a href="capNoticia.php">Crear Noticia</a></li>
                            <?php
							if($admin==1){
                            echo "<li><a href='catNoticias.php'>Catálogo de Noticias</a></li>";
                            echo "<li><a href='creaUsr.php'>Crear Usuario</a></li>";
                            echo "<li><a href='catUsr.php'>Catálogo de Usuario</a></li>";
							}
							?>
                            <li><a href="salir.php">Salir</a></li>
                        </ul>
            	 </div>
                
               	  <?php 
				if (isset($_POST['submit'])) { 
				   //Crearemos el Articulo
				
					$tot = count($_FILES["archivos"]["name"]);
				
				   include("Conexion/conn.php");
				   $link=@mysql_connect($server, $user, $pass);
				  
				   //mysql_connect("localhost","root","acosta"); 
				   //mysql_select_db("db"); 
				   /*Recibimos las variables por el metodo POST*/
				   $Noticia = htmlspecialchars(trim($_POST['nomNoticia']));
				   $linker = sanear_string($Noticia);
				   //$link = str_replace(" ", "_", $Noticia);
				   $extracto = htmlspecialchars(trim($_POST['extracto']));
				   $descripcion = htmlspecialchars(trim($_POST['descNoticia']));
				   $fecha = date("Y-m-d");
				   $destino='Fotos/'; 
				   $archivo= $destino.$_FILES['fichero']['name']; // Se guardarÃ­a dentro de "carpeta" con el nombre original 
				  
				  
				   
				  
				   $query  =  "INSERT INTO ".$db.".noticia ( link, extractoNoticia, nomNoticia, descNoticia, fechaNoticia,img) VALUES('".$linker."','".$extracto."','".$Noticia."','".$descripcion."','".$fecha."','".$archivo."')";  // Ahora
	           	
				
				$result=mysql_query($query) or die ("Error in query: $query. ".mysql_error());
			
				if(mysql_affected_rows())
				{
					
					
				  	
					if(is_uploaded_file($_FILES['fichero']['tmp_name'])) { // verifica haya sido cargado el archivo 
					
					 // $ruta= "carpeta/nuevo_nombre.jpg"; si tambiÃ©n se quiere renombrar 
						if(move_uploaded_file($_FILES['fichero']['tmp_name'], $archivo)) { // se coloca en su lugar final 
							
				   				$sql = "select * from ".$db.".noticia order by idNoticia desc limit 0,1";
								
				  				$result1=mysql_query($sql,$link);
				  				$reg=mysql_fetch_array($result1);
				 
						 //este for recorre el arreglo
							 
							 for ($i = 0; $i < $tot; $i++){
							  if(!empty($_FILES["archivos"]["name"][$i])){
								 $idNoticia = $reg["idNoticia"];
								 $tmp_name = "Fotos/". $_FILES["archivos"]["tmp_name"][$i];
								 $name = "Fotos/".$_FILES["archivos"]["name"][$i];
								
								 $ssql  =  "INSERT INTO ".$db.".imgnota (idNoticia,rutaImg) VALUES('".$idNoticia."','".$name."')";  // Ahora
								
								  $result2=mysql_query($ssql);
								
									if(mysql_affected_rows())
									{
										
										
										if(is_uploaded_file($_FILES["archivos"]["tmp_name"][$i])) { // verifica haya sido cargado el archivo 
										
										 // $ruta= "carpeta/nuevo_nombre.jpg"; si tambiÃ©n se quiere renombrar 
											if(move_uploaded_file($_FILES["archivos"]["tmp_name"][$i], $name)) { // se coloca en su lugar final 
														
														
											} 
										} 
										
										
								
									} //ciere de if if(mysql_affected_rows())
									else {
								
										echo "Error introduciendo el producto";
								
									}   // cierre de else 
								
							  }
							 }
							} 
						} 
					
					
			
				} //ciere de if if(mysql_affected_rows())
				else {
			
					echo "Error introduciendo el producto";
			
				}   // cierre de else 
				   
				// A continuaciÃ³n el formulario 
				} 
				   
            
           
				?> 
                
                <form id="formulario" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data"> 
                	<table width="960" border="0">
                    	<tr>
                            <td width="111" align="right">
                                Nombre Noticia:
                          </td>
                            <td width="536" align="left">
                                <input name="nomNoticia" type="text" size="50">
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="right">
                                Extracto Noticia:
                          </td>
                            <td align="left">
                                <textarea name="extracto" type="text" cols="40" rows="10"> </textarea>
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="right">
                               Descripcion:
                          </td>
                            <td align="left">
                                <textarea name="descNoticia" type="text" cols="60" rows="10" > </textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Adjunta Imagen:<br />
                                
                          </td>
                            <td align="left">
                                <input name="fichero" type="file" size="30">
                            </td>
                        </tr>
                         <tr>
                            <td align="right"><label>Imagenes del Evento:</label>
                            </td>
                            <td align="left">
                				<div id="adjuntos">
                            		<input type="file" name="archivos[]" />
                       			</div>
                             </td>
                  		</tr>
                        <tr>
                            <td>
                            </td>
                            <td>  <a href="#" onclick="addCampo()">Cargar Otra Imagen</a></td>
                       </tr>
                       
                        
                        <tr>
                            <td colspan="2" align="center">
                                 <input name="submit" type="submit" value="Crear">  
                            </td>
                        </tr> 
                         
           		  </table>
                     
                  
              </form> 
                </div>
                
        </div>
	</article>
      
    </section>
  </div>
  <!-- end one-third column ends here --> 
</div>
<!-- econtainer ends here --> 
<!-- About Content Part - Box Two ==================================================
================================================== -->
<div class="blankSeparator1"></div>

<!--Footer ==================================================
================================================== -->
<div id="footer">
  <div class="container footer">
    <div class="one_fourth">
      <h3>Ultimas Noticias</h3>
      <div id="tweets"></div>
    </div>
    <div class="one_fourth">
      <h3>Mapa del Sitio</h3>
      <ul>
        <li class="lines"><a href="#" title="">Seccion</a></li>
        <li class="lines"><a href="#" class="">Seccion</a></li>
        <li class="lines"><a href="#" class="">Seccion</a></li>
        <li class="lines"><a href="#" class="">Seccion</a></li>
        <li class="lines"><a href="#" class="">Seccion</a></li>
      </ul>
    </div>
    <div class="one_fourth">
      <h3>Accesos</h3>
      <ul>
        <li class="lines"><a href="#" class=""> Seccion</a></li>
        <li class="lines"><a href="#" class="">Seccion</a></li>
        <li class="lines"><a href="#" class="">Seccion</a></li>
        <li class="lines"><a href="#" class=""> Seccion</a></li>
        <li class="lines"><a href="#" class="">Seccion</a></li>
      </ul>
    </div>
    <div class="one_fourth lastcolumn">
      <h3>DIRECION Y TELEFONO</h3>
      <p>Blvd. Tepic - Xalisco No. 97 Sur </p>
      <p>Fracc. Jardines de la Cruz</p>
      <p>Tels: (311) 212 45 45 y 133 20 83</p>
     
    </div>
  </div>
  <!-- container ends here --> 
</div>
<!-- footer ends here --> 
<!-- Copyright ==================================================
================================================== -->
<div id="copyright">
  <div class="container">
    <div class="eleven columns alpha">
      <p class="copyright">&copy; Copyright 2012. &quot;INUMEDH&quot; by <a href="http://www.acostaweb.com.mx/">AcostaWeb</a>. Todos lo derechos reservados.</p>
    </div>
    <div class="five columns omega">
      <section class="socials">
        <ul class="socials fr">
          <li><a href="#"><img src="images/socials/twitter.png" class="poshytip" title="Twitter"  alt="" /></a></li>
          <li><a href="#"><img src="images/socials/facebook.png" class="poshytip" title="Facebook" alt="" /></a></li>
          <li><a href="#"><img src="images/socials/google.png" class="poshytip" title="Google" alt="" /></a></li>
          <li><a href="#"><img src="images/socials/dribbble.png" class="poshytip" title="Dribbble" alt="" /></a></li>
        </ul>
      </section>
    </div>
  </div>
  <!-- container ends here --> 
</div>
<!-- copyright ends here --> 
<!-- End Document
================================================== --> 
<!-- Scripts ==================================================
================================================== --> 
<script src="js/jquery-1.8.0.min.js" type="text/javascript"></script> 
<!-- Main js files --> 
<script src="js/screen.js" type="text/javascript"></script> 
<!-- Tooltip --> 
<script src="js/poshytip-1.0/src/jquery.poshytip.min.js" type="text/javascript"></script> 
<!-- Tabs --> 
<script src="js/tabs.js" type="text/javascript"></script> 
<!-- Tweets --> 
<script src="js/jquery.tweetable.js" type="text/javascript"></script> 
<!-- Include prettyPhoto --> 
<script src="js/jquery.prettyPhoto.js" type="text/javascript"></script> 
<!-- Include Superfish --> 
<script src="js/superfish.js" type="text/javascript"></script> 
<script src="js/hoverIntent.js" type="text/javascript"></script> 
<!-- Flexslider --> 
<script src="js/jquery.flexslider-min.js" type="text/javascript"></script> 
<script type="text/javascript" src="js/modernizr.custom.29473.js"></script>
</body>
</html>