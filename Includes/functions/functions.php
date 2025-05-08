<?php
    /*
		Función Title que emite el título de la página en caso de que la página tenga la variable $pageTitle y emite el título por defecto para otras páginas
	*/
	function getTitle()
	{
		global $pageTitle;
		if(isset($pageTitle))
			echo $pageTitle." | Barbershop Website";
		else
			echo "Barbershop Website";
	}

	/*
		Esta función devuelve el número de elementos de una tabla dada
	*/

    function countItems($item,$table)
	{
		global $con;
		$stat_ = $con->prepare("SELECT COUNT($item) FROM $table");
		$stat_->execute();
		
		return $stat_->fetchColumn();
	}

    /*
	
	** Comprobar elementos Función
	** Función para comprobar el elemento en la base de datos [Función con parámetros]
	** $select = el elemento a seleccionar [Ejemplo : usuario, elemento, categoría]
	** $from = la tabla para seleccionar [Ejemplo: usuarios, artículos, categorías]
	** $valor = El valor de select [Ejemplo: Carlos, Corte tradicional, Corte]

	*/
	function checkItem($select, $from, $value)
	{
		global $con;
		$statment = $con->prepare("SELECT $select FROM $from WHERE $select = ? ");
		$statment->execute(array($value));
		$count = $statment->rowCount();
		
		return $count;
	}


  	/*
    	==============================================
    	FUNCIÓN DE ENTRADA DE PRUEBA, SE UTILIZA PARA SANEAR LAS ENTRADAS DEL USUARIO
      Y ELIMINAR CARACTERES SOSPECHOSOS Y ELIMINAR ESPACIOS DE MÁS
    	==============================================
	
	*/

  	function test_input($data) 
  	{
      	$data = trim($data);
      	$data = stripslashes($data);
      	$data = htmlspecialchars($data);
      	return $data;
  	}

?>

