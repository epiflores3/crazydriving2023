<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report2.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Inscripciones por transmisión: ' . $_GET['transmision']);

// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['transmision'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.

    require_once('../../entities/dto/paquete.php');
    // Se instancian las entidades correspondientes.

    $Paquete = new Paquete;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($Paquete->setTranmision($_GET['transmision'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.

        // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
        if ($dataPaquete = $Paquete->paquetesTransmision()) {
            // Se establece un color de relleno para los encabezados.
            $pdf->setFillColor(148,188,204);
            // Se establece la fuente para los encabezados.
            $pdf->setFont('Times', 'B', 11);
            // Se imprimen las celdas con los encabezados.
            $pdf->cell(70, 10, $pdf->encodeString( 'Descripción '), 1, 0, 'C', 1);
            $pdf->cell(36, 10, 'Valor paquete', 1, 0, 'C', 1);
            $pdf->cell(30, 10, 'Cantidad clase', 1, 0, 'C', 1);
            $pdf->cell(50, 10, 'Tipo paquete', 1, 1, 'C', 1);

            // // Se establece la fuente para los datos.
            $pdf->setFont('Times', '', 11);
            // $total = 0;

            // Se recorren los registros fila por fila.
            foreach ($dataPaquete as $rowTransmision) {
                // Se imprimen las celdas con los dato.
                $pdf->cell(70, 10, $pdf->encodeString($rowTransmision['descripcion']), 1, 0);
                $pdf->cell(36, 10,  $pdf->encodeString($rowTransmision['valor_paquete']), 1, 0);
                $pdf->cell(30, 10,  $pdf->encodeString($rowTransmision['cantidad_clase']), 1, 0);
                $pdf->cell(50, 10,  $pdf->encodeString($rowTransmision['tipo_paquete']), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('No hay inscripciones para el tipo'), 1, 1);
        }
        // Se llama implícitamente al método footer() y se envía el documento al navegador web.
        $pdf->output('I', 'Paquete por transmision.pdf');
    } else {
        print('Transmision incorrecta');
    }
} else {
    print('Debe seleccionar una transmision');
}
