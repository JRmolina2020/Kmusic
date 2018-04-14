<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/conexion.php";

Class Cancion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


//Implementamos un método para insertar registros
	public function insertar($nombre,$duracion,$fichero,$idalbum,$idproductor)
	{
		$sql="INSERT INTO cancion (nombre,duracion,fichero,idalbum,idproductor)
		VALUES ('$nombre','$duracion','$fichero','$idalbum','$idproductor')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcancion,$nombre,$duracion,$fichero,$idalbum,$idproductor)
	{
		$sql="UPDATE cancion SET idcancion='$idcancion',nombre='$nombre',duracion='$duracion',fichero='$fichero',idalbum='$idalbum',
		idproductor='$idproductor' WHERE idcancion='$idcancion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar registros
	public function eliminar($idcancion)
	{
		$sql="DELETE FROM cancion  WHERE idcancion='$idcancion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcancion)
	{
		$sql="SELECT * FROM cancion WHERE idcancion='$idcancion'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT idcancion, album.nombre AS album ,album.descripcion,album.genero,productor.nombre AS producer,cancion.nombre AS tema,cancion.duracion,
       album.imagen AS portada,productor.imagen AS productor,cancion.fichero AS audio FROM album 
       INNER JOIN cancion on cancion.idalbum = album.idalbum
       INNER JOIN productor on cancion.idproductor = productor.idproductor";
		return ejecutarConsulta($sql);		
	}
}

?>