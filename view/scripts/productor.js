var tabla;


function init(){
	mostrarform(false);
	$("#imagenactual").val("");
	listar();
	limpiar();
	guardaryeditar();	
	$("#imagenmuestra").hide();
	
}
//Función limpiar
function limpiar()
{
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#genero").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#idproductor").val("");
	
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#imagenmuestra").hide();
		$('#formulario').find('[name="nombre"]').focus();	
		$('#formulario')[0].reset();

	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
	 $('#formulario').bootstrapValidator("resetForm",true); 
}


//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		 
	           
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../controller/productor.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}



function guardaryeditar(e)
{
// VALIDATION FORMULARIO
$('#formulario') .bootstrapValidator({
	message: 'This value is not valid',
	
	excluded: [':disabled'],
	fields: {
		nombre: {
			message: 'Nombre del album invalido',
			validators: {
				notEmpty: {
					message: 'El nombre  es obligatorio y no puede estar vacio.'
				},
				stringLength: {
					min: 1,
					max: 15,
					message: 'Minimo 1 caracteres y Maximo 15 '
				},
				
			}
		},
	}
})
.on('success.form.bv', function(e) {
// ---------------------------------------
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controller/productor.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    

	    	swal({
	    		position: 'top-end',
	    		type: 'success',
	    		title: datos,
	    		showConfirmButton: false,
	    		timer: 1500
	    	});  
	    	mostrarform(false);
	          tabla.ajax.reload();
	          $('#formulario').bootstrapValidator("resetForm",true); 
	          $("#imagenactual").val("2");

	    }

	});
	});
	limpiar();

	
}



// end save
function mostrar(idproductor)
{
	$.post("../controller/productor.php?op=mostrar",{idproductor : idproductor}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/productor/"+data.imagen);
		$("#imagenactual").val(data.imagen);
 		$("#idproductor").val(data.idproductor);


 	})
}
//Función para eliminar registros
function eliminar(idproductor)
{
 swal({
  title: "Desea eliminar este productor? Recuerde una vez eliminado no se podra recuperar la informacion!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'SI, ELIMINAR!'
}).then((result) => {
  if (result.value) {
  	$.post("../controller/productor.php?op=eliminar", {idproductor : idproductor}, function(e){
        		 swal(e);
	            tabla.ajax.reload();
       });	
   
  }
})
}

init();