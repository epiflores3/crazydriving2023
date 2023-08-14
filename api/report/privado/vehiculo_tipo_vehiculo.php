<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report2.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['tipo_vehiculo'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
  
    require_once('../../entities/dto/modelo.php');
    // Se instancian las entidades correspondientes.
    
    $veh = new Modelo;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($veh->setTipoVehiculo($_GET['tipo_vehiculo'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
      
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Vehiculos por tipo vehiculo');

            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataVehiculo = $veh->vehiculosmodelos()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
               
                $pdf->cell(62, 10, 'Id', 1, 0, 'C', 1);
                $pdf->cell(62, 10, 'Modelo', 1, 0, 'C', 1);
                $pdf->cell(62, 10, 'Placa', 1, 1, 'C', 1);

                // // Se establece la fuente para los datos de los productos.
                // $pdf->setFont('Times', '', 11);
                // $total = 0;

                

                // Se recorren los registros fila por fila.
                foreach ($dataVehiculo as $rowVehiculo) {
                  
                    // ($rowProducto['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                  
                    $pdf->cell(62, 10, $pdf->encodeString($rowVehiculo['id_vehiculo']), 1, 0);
                    $pdf->cell(62, 10, $pdf->encodeString($rowVehiculo['modelo']), 1, 0);
                    $pdf->cell(62, 10, $pdf->encodeString($rowVehiculo['placa']), 1, 1);
                    



                }
              
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay vehiculos para el modelo'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Vehiculo.pdf');
        
    } else {
        print('Vehiculo incorrecto');
    }
} else {
    print('Debe seleccionar un tipo vehiculo');
}