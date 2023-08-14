<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report2.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['id_tipo_paquete'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/tipo_paquete.php');
    require_once('../../entities/dto/paquete.php');
    // Se instancian las entidades correspondientes.
    $tipo_paquete = new TipoPaquete;
    $paquete = new Paquete;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($tipo_paquete->setId($_GET['id_tipo_paquete']) && $paquete->setTipoPaquete($_GET['id_tipo_paquete'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowTP = $tipo_paquete->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Paquete de tipo paquete ' . $rowTP['tipo_paquete']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataP = $paquete->tipoPaquete()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(70, 10, 'Nombre descripcion ', 1, 0, 'C', 1);
                $pdf->cell(36, 10, 'Valor paquete', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Cantidad clase', 1, 0, 'C', 1);
                $pdf->cell(50, 10, 'Transmision', 1, 1, 'C', 1);
            
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataP as $rowPaquete) {
           
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(70, 10, $pdf->encodeString($rowPaquete['descripcion']), 1, 0);
                    $pdf->cell(36, 10,  $pdf->encodeString($rowPaquete['valor_paquete']), 1, 0);
                    $pdf->cell(30, 10,  $pdf->encodeString($rowPaquete['cantidad_clase']), 1, 0);
                    $pdf->cell(50, 10,  $pdf->encodeString($rowPaquete['transmision']), 1, 1);
                    
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay paquetes por tipo paquete'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'paquete.pdf');
        } else {
            print('tipo paquete inexistente');
        }
    } else {
        print('tipo paquete incorrecta');
    }
} else {
    print('Debe seleccionar una tipo paquete');
}
