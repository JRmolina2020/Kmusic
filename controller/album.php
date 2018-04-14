<?php 
require_once "../model/Album.php";

$album=new Album();

$idalbum=isset($_POST["idalbum"])? limpiarCadena($_POST["idalbum"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$genero=isset($_POST["genero"])? limpiarCadena($_POST["genero"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/albums/" . $imagen);
			}
		}
		if (empty($idalbum)){
			$rspta=$album->insertar($nombre,$descripcion,$genero,$imagen);
			echo $rspta ? "Album registrado" : "Artículo no se pudo registrar";
		}
		else {
			$rspta=$album->editar($idalbum,$nombre,$descripcion,$genero,$imagen);
			echo $rspta ? " Album actualizado" : "Album no se pudo actualizar";
		}
	break;

	case 'eliminar':
		$rspta=$album->eliminar($idalbum);
 		echo $rspta ? "Album eliminado" : "Album no se puede eliminar";
 		break;
	break;

	case 'mostrar':
		$rspta=$album->mostrar($idalbum);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$album->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idalbum.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="eliminar('.$reg->idalbum.')"><i class="fa fa-trash"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->descripcion,
 				"3"=>$reg->genero,
 				"4"=>"<img src='../files/albums/".$reg->imagen."' height='50px' width='50px' >"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	
}
?>