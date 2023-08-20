<?php
// Se manda a traer el archivo que actua como plantilla para los reportes
require_once('../../helpers/report2.php');
//Se mandan a traer las clases donde se encuentran los gets y los sets que usaremos en el reporte
require_once('../../entities/dto/tipo_paquete.php');
require_once('../../entities/dto/paquete.php');

// Se crea un objeto de la clase reporte.
$pdf = new Report;
// Se coloca un titulo al documento.
$pdf->startReport('Paquetes por tipo');
// Se crea un objeto de la clase ya que estos sera por lo que se filtrara.
$tipo_paquete = new TipoPaquete;
// Verifica si exiten registros a mostrar.
if ($datatp = $tipo_paquete->readAll()) {
    // Se pone un color al encabezado.
    $pdf->setFillColor(175);
    // Se pone una fuente.
    $pdf->setFont('Times', 'B', 11);
    // Se rellenan las celdas del encabezado.

    // Significado de los numeros de cell: 
    // Primero es el ancho de la celda
    // Segundo el alto de la celda
    // Tercero El valor que tendra la celda: TEXTO
    // Cuarto Indica si se dibujan los bordes alrededor de la celda: 0 Sin bordes, 1 Marco, o tambien L izquierda, T arriba, R derecha, B abajo
    // Quinto indica donde puede ir la posición: 0 A la derecha, 1 Al comienzo de la siguiente línea, 2 Abajo
    // Sexto indica el alineamiento del texto: L Alineación a la izquierda, C centro, R Alineación a la derecha
    // Septimo indica si se muestra el color: 0 Es que no se mostrará el color, 1 Es que si se mostrará el color del setfillcolor
    $pdf->cell(70, 10,  $pdf->encodeString('Descripción'), 1, 0, 'C', 1);
    $pdf->cell(36, 10, 'Valor paquete', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Cantidad clase', 1, 0, 'C', 1);
    $pdf->cell(50, 10, $pdf->encodeString('Transmisión'), 1, 1, 'C', 1);

    // Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])

    // Se estabelce un color para la celda que muestra por lo que se filtra.
    $pdf->setFillColor(225);
    // Se establece una fuente para las celdas que muestran resultados.
    $pdf->setFont('Times', '', 11);

    // Recorre filas una por una.
    foreach ($datatp as $rowTP) {
        // Se muestra la celda que tendra el dato por el que se filtra.
        $pdf->cell(0, 10, $pdf->encodeString('Tipo paquete: ' . $rowTP['tipo_paquete']), 1, 1, 'C', 1);
        // Se crea un objeto de la clase detalle producto ya que esto sera lo que se filtrara .
        $paquete = new Paquete;
        // Se establece por el id que tiene que capturar.
        if ($paquete->setTipoPaquete($rowTP['id_tipo_paquete'])) {
            // Verifica si exiten registros a mostrar.
            if ($dataP1 = $paquete->tipoPaquete()) {
                // Recorre filas una por una.
                foreach ($dataP1 as $rowPaquete) {
                    // Se rellenan las celdas de las tallas de acuerdo a algo en especifico.
                    $pdf->cell(70, 10, $pdf->encodeString($rowPaquete['descripcion']), 1, 0);
                    $pdf->cell(36, 10,  $pdf->encodeString($rowPaquete['valor_paquete']), 1, 0);
                    $pdf->cell(30, 10,  $pdf->encodeString($rowPaquete['cantidad_clase']), 1, 0);
                    $pdf->cell(50, 10,  $pdf->encodeString($rowPaquete['transmision']), 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay paquete con ese tipo paquete'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Paquete incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay Paquete por tipo paquete para mostrar'), 1, 1);
}

// Se pone el nombre del archivo cuando se descarga y envía el documento a un destino determinado.
// Significado de las letras:
// I: envía el archivo en línea al navegador. Se utiliza el visor de PDF si está disponible.
// D: enviar al navegador y forzar la descarga de un archivo con el nombre dado por name.
// F: guarde en un archivo local con el nombre dado por name(puede incluir una ruta).
// S: devuelve el documento como una cadena.

$pdf->output('I', 'Empleados-AFP.pdf');
