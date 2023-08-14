<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report2.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['id_sucursal'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/empleado.php');
    require_once('../../entities/dto/sucursal.php');
    // Se instancian las entidades correspondientes.
    $Empleado = new empleado;
    $Sucursal = new sucursal;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($Sucursal->setId($_GET['id_sucursal']) && $Empleado->setSucursal($_GET['id_sucursal'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowSu = $Sucursal->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Nombre de la sucursal ' . $rowSu['nombre_sucursal']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataEmp = $Empleado->EmpPorSucuEspecifico()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(93, 10, 'Nombre Empleado ', 1, 0, 'C', 1);
                $pdf->cell(93, 10, 'Nombre Sucursal', 1, 1, 'C', 1);
            
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataEmp as $rowSucursal) {
           
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(93, 10, $pdf->encodeString($rowSucursal['nombre_com_empleado']), 1, 0);
                    $pdf->cell(93, 10,  $pdf->encodeString($rowSucursal['nombre_sucursal']), 1, 1);  
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay paquetes por tipo paquete'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'suc_empleado.pdf');
        } else {
            print('Sucursal inexistente');
        }
    } else {
        print('Sucursal incorrecta');
    }
} else {
    print('Debe seleccionar una Sucursal');
}