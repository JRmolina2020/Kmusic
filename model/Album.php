<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";

Class Album
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$descripcion,$genero,$imagen)
	{
		$sql="INSERT INTO album (nombre,descripcion,genero,imagen)
		VALUES ('$nombre','$descripcion','$genero','$imagen')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idalbum,$nombre,$descripcion,$genero,$imagen)
	{
		$sql="UPDATE album SET idalbum='$idalbum',nombre='$nombre',descripcion='$descripcion',genero='$genero',imagen='$imagen' WHERE idalbum='$idalbum'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar registros
	public function eliminar($idalbum)
	{
		$sql="DELETE FROM album  WHERE idalbum='$idalbum'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idalbum)
	{
		$sql="SELECT * FROM album WHERE idalbum='$idalbum'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM album ";
		return ejecutarConsulta($sql);		
	}


}

?>