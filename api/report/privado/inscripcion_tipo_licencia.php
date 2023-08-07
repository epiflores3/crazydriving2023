<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['tipo_licencia'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
  
    require_once('../../entities/dto/inscripcion.php');
    // Se instancian las entidades correspondientes.
    
    $ins = new Inscripcion;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($ins->setTlicencia($_GET['tipo_licencia'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
      
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Comprobante: ');
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataInscripcion = $ins->inscripcionLicencia()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
               
                $pdf->cell(80, 10, 'Anticipo', 1, 0, 'C', 1);
                $pdf->cell(40, 10, 'Fecha de registro', 1, 0, 'C', 1);
                $pdf->cell(40, 10, 'Fecha de inicio', 1, 0, 'C', 1);
                $pdf->cell(26, 10,  $pdf->encodeString('Evaluación'), 1, 0, 'C', 1);
                $pdf->cell(26, 10, 'Estado de cliente', 1, 1, 'C', 1);
            
                // // Se establece la fuente para los datos de los productos.
                // $pdf->setFont('Times', '', 11);
                // $total = 0;

                

                // Se recorren los registros fila por fila.
                foreach ($dataInscripcion as $rowInscripcion) {
                    ($rowInscripcion['evaluacion'])?$evaluacion='si':$evaluacion='no';
                  
                    // ($rowProducto['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                  
                    $pdf->cell(36, 10, $pdf->encodeString($rowInscripcion['anticipo_paquete']), 1, 0);
                    $pdf->cell(38, 10, $pdf->encodeString($rowInscripcion['fecha_registro']), 1, 0);
                    $pdf->cell(38, 10, $pdf->encodeString($rowInscripcion['fecha_inicio']), 1, 0);
                    $pdf->cell(38, 10, $pdf->encodeString($evaluacion), 1, 0);
                    $pdf->cell(36, 10, $pdf->encodeString($rowInscripcion['estado_cliente']), 1, 1);

                }
              
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay inscripciones para el tipo'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'inscripciones.pdf');
        
    } else {
        print('Tipo de licencia incorrecta');
    }
} else {
    print('Debe seleccionar un tipo de licencia');
}