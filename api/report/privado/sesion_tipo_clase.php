<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report2.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['tipo_clase'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
  
    require_once('../../entities/dto/sesion.php');
    // Se instancian las entidades correspondientes.
    
    $ses = new Sesion;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($ses->setTipoClase($_GET['tipo_clase'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
      
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Sesiones  por tipo de clase');

            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataSesion = $ses->sesiontipoclase()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
               
                $pdf->cell(17.6, 10, 'ID', 1, 0, 'C', 1);
                $pdf->cell(37.2, 10, 'Fecha registro', 1, 0, 'C', 1);
                $pdf->cell(33.5, 10, 'Hora de inicio', 1, 0, 'C', 1);
                $pdf->cell(33.5, 10, 'Hora fin', 1, 0, 'C', 1);
                $pdf->cell(64.2, 10, 'Nombre del empleado', 1, 1, 'C', 1);
            
                // // Se establece la fuente para los datos de los productos.
                // $pdf->setFont('Times', '', 11);
                // $total = 0;

                

                // Se recorren los registros fila por fila.
                foreach ($dataSesion as $rowSesion) {
                  
                    // ($rowProducto['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                  
                    $pdf->cell(17.6, 10, $pdf->encodeString($rowSesion['id_sesion']), 1, 0);
                    $pdf->cell(37.2, 10, $pdf->encodeString($rowSesion['fecha_sesion']), 1, 0);
                    $pdf->cell(33.5, 10, $pdf->encodeString($rowSesion['hora_inicio']), 1, 0);
                    $pdf->cell(33.5, 10, $pdf->encodeString($rowSesion['hora_fin']), 1, 0);
                    $pdf->cell(64.2, 10, $pdf->encodeString($rowSesion['nombre_com_empleado']), 1, 1);


                }
              
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay sesiones para el tipo clase'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Sesiones.pdf');
        
    } else {
        print('Tipo de clase incorrecto');
    }
} else {
    print('Debe seleccionar un tipo de clase');
}
