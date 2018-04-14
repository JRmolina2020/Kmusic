<?php 
require_once "../model/Productor.php";

$productor=new Productor();

$idproductor=isset($_POST["idproductor"])? limpiarCadena($_POST["idproductor"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productor/" . $imagen);
			}
		}

		if (empty($idproductor)){
			$rspta=$productor->insertar($nombre,$imagen);
			echo $rspta ? "Productor registrado" : "Productor no se pudo registrar";
		}

		else {
			$rspta=$productor->editar($idproductor,$nombre,$imagen);
			echo $rspta ? " Productor actualizado" : "Productor no se pudo actualizar";
		}
	break;

	case 'eliminar':
		$rspta=$productor->eliminar($idproductor);
 		echo $rspta ? "Productor eliminado" : "Productor no se puede eliminar";
 		break;
	break;

	case 'mostrar':
		$rspta=$productor->mostrar($idproductor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$productor->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idproductor.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="eliminar('.$reg->idproductor.')"><i class="fa fa-trash"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>"<img src='../files/productor/".$reg->imagen."' height='50px' width='50px' >"
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