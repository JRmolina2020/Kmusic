<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";

Class Productor
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$imagen)
	{
		$sql="INSERT INTO productor (nombre,imagen)
		VALUES ('$nombre','$imagen')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idproductor,$nombre,$imagen)
	{
		$sql="UPDATE productor SET idproductor='$idproductor',nombre='$nombre',imagen='$imagen' WHERE idproductor='$idproductor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar registros
	public function eliminar($idproductor)
	{
		$sql="DELETE FROM productor  WHERE idproductor='$idproductor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idproductor)
	{
		$sql="SELECT * FROM productor WHERE idproductor='$idproductor'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM productor ";
		return ejecutarConsulta($sql);		
	}
}

?>