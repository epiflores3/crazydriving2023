<?php
// Se manda a traer el archivo que actua como plantilla para los reportes
require_once('../../helpers/report.php');
//Se mandan a traer las clases donde se encuentran los gets y los sets que usaremos en el reporte
require_once('../../entities/dto/inscripcion.php');
require_once('../../entities/dto/cliente.php');


// Se crea un objeto de la clase reporte.
$pdf = new Report;
// Se coloca un titulo al documento.
$pdf->startReport('Inscripción por estado del cliente');
// Se crea un objeto de la clase ya que estos sera por lo que se filtrara.
$estado = new Cliente;
// Verifica si exiten registros a mostrar.
if ($dataCliente = $estado->readAll()) {
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

    $pdf->cell(73, 10, 'Nombre del cliente', 1, 0, 'C', 1);
    $pdf->cell(20, 10, 'Anticipo', 1, 0, 'C', 1);
    // $pdf->cell(30, 10, 'Fecha de registro', 1, 0, 'C', 1);
    $pdf->cell(28, 10, 'Fecha de inicio', 1, 0, 'C', 1);
    $pdf->cell(20, 10,  $pdf->encodeString('Evaluación'), 1, 0, 'C', 1);
    // $pdf->cell(25, 10, 'Descripción', 1, 0, 'C', 1);
    $pdf->cell(73, 10, 'Nombre del empleado', 1, 0, 'C', 1);
    $pdf->cell(18, 10, 'Inicio', 1, 0, 'C', 1);
    $pdf->cell(18, 10, 'Fin', 1, 1, 'C', 1);

    // Se estabelce un color para la celda que muestra por lo que se filtra.
    $pdf->setFillColor(225);
    // Se establece una fuente para las celdas que muestran resultados.
    $pdf->setFont('Times', '', 11);

    // Recorre filas una por una.
    foreach ($dataCliente as $rowEstado) {
        // Se muestra la celda que tendra el dato por el que se filtra.
        $pdf->cell(0, 10, $pdf->encodeString('Estado: ' . $rowEstado['estado_cliente']), 1, 1, 'C', 1);
        // Se crea un objeto de la clase ya que esto sera lo que se filtrara .
        $inscripcion = new Inscripcion;
        // Se establece por el id que tiene que capturar.
        if ($inscripcion->setEstado($rowEstado['estado_cliente'])) {
            // Verifica si exiten registros a mostrar.
            if ($dataCliente = $inscripcion->inscripcionEstadoCliente()) {
                // Recorre filas una por una.
                
                foreach ($dataCliente as $rowEstado2) {
                    ($rowEstado2['evaluacion']) ? $evaluacion = 'Evaluado' : $evaluacion = 'No evaluado';
                    
                    // Se rellenan las celdas de acuerdo a algo en especifico.
                    $pdf->cell(72, 10, $pdf->encodeString($rowEstado2['nombre_com_cliente']), 1, 0);
                    $pdf->cell(20, 10, $pdf->encodeString($rowEstado2['anticipo_paquete']), 1, 0);
                    // $pdf->cell(30, 10, $pdf->encodeString($rowEstado2['fecha_registro']), 1, 0);
                    $pdf->cell(28, 10, $pdf->encodeString($rowEstado2['fecha_inicio']), 1, 0);
                    $pdf->cell(22, 10, $pdf->encodeString($evaluacion), 1, 0);
                    // $pdf->cell(25, 10, $pdf->encodeString($rowEstado2['descripcion']), 1, 0);
                    $pdf->cell(72, 10, $pdf->encodeString($rowEstado2['nombre_com_empleado']), 1, 0);
                    $pdf->cell(18, 10, $pdf->encodeString($rowEstado2['inicio']), 1, 0);
                    $pdf->cell(18, 10, $pdf->encodeString($rowEstado2['fin']), 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay inscripciones por estado'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Estado incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay inscripciones por estado para mostrar'), 1, 1);
}

// Se pone el nombre del archivo cuando se descarga y envía el documento a un destino determinado.
// Significado de las letras:
// I: envía el archivo en línea al navegador. Se utiliza el visor de PDF si está disponible.
// D: enviar al navegador y forzar la descarga de un archivo con el nombre dado por name.
// F: guarde en un archivo local con el nombre dado por name(puede incluir una ruta).
// S: devuelve el documento como una cadena.

$pdf->output('I', 'Inscripciones-Estado.pdf');
