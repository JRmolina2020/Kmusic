<?php 
require_once "../model/Cancion.php";

$cancion=new Cancion();

$idcancion=isset($_POST["idcancion"])? limpiarCadena($_POST["idcancion"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$duracion=isset($_POST["duracion"])? limpiarCadena($_POST["duracion"]):"";
$fichero=isset($_POST["fichero"])? limpiarCadena($_POST["fichero"]):"";
$idalbum=isset($_POST["idalbum"])? limpiarCadena($_POST["idalbum"]):"";
$idproductor=isset($_POST["idproductor"])? limpiarCadena($_POST["idproductor"]):"";

switch ($_GET["op"]){
case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$fichero=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$fichero = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/cancion/" . $fichero);
			}
		}
		if (empty($idcancion)){
			$rspta=$cancion->insertar($nombre,$duracion,$fichero,$idalbum,$idproductor);
			echo $rspta ? "Album registrado" : "Artículo no se pudo registrar";
		}
		else {
			$rspta=$cancion->editar($idcancion,$nombre,$duracion,$fichero,$idalbum,$idproductor);
			echo $rspta ? " Album actualizado" : "Album no se pudo actualizar";
		}
	break;

	case 'eliminar':
		$rspta=$cancion->eliminar($idcancion);
 		echo $rspta ? "cancion eliminado" : "cancion no se puede eliminar";
 		break;
	break;

	case 'mostrar':
		$rspta=$cancion->mostrar($idcancion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	
	case 'listar':
		$rspta=$cancion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idcancion.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="eliminar('.$reg->idcancion.')"><i class="fa fa-trash"></i></button>',
 				"1"=>$reg->album,
 				"2"=>$reg->descripcion,
 				"3"=>$reg->genero,
 				"4"=>$reg->producer,
 				"5"=>$reg->tema,
 				"6"=>$reg->duracion,
 				"7"=>"<img src='../files/albums/".$reg->portada."' height='50px' width='50px'>",
 				"8"=>"<img src='../files/productor/".$reg->productor."' height='50px' width='50px'>",
 				"9"=>"<img src='../files/cancion/".$reg->audio."' height='50px' width='50px'>"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectAlbum":
		require_once "../model/Album.php";
		$album = new Album();

		$rspta = $album->listar();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idalbum . '>' . $reg->nombre . '</option>';
				}
	break;

	case "selectProductor":
		require_once "../model/Productor.php";
		$productor = new Productor();

		$rspta = $productor->listar();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idproductor . '>' . $reg->nombre . '</option>';
				}
	break;



}
?>