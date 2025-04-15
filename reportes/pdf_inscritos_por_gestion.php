<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');
require('../fpdf/fpdf.php'); // Asegúrate de tener la librería FPDF disponible

// Consulta para obtener la cantidad de inscritos por gestión
$query = "SELECT YEAR(i.fecha_inscripcion) AS gestion, 
                 COUNT(i.id_inscripcion) AS cantidad_inscritos
          FROM inscripciones i
          GROUP BY YEAR(i.fecha_inscripcion)
          ORDER BY gestion DESC";

$resultado = mysqli_query($conexion, $query);

// Manejo de errores en la consulta SQL
if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($conexion));
}

// Crear PDF usando FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Título del PDF
$pdf->Cell(0, 10, 'Reporte: Inscritos por Gestión', 0, 1, 'C');
$pdf->Ln(10); // Espacio entre líneas

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Gestión', 1, 0, 'C');
$pdf->Cell(80, 10, 'Cantidad de Inscritos', 1, 1, 'C');

// Contenido de la tabla
$pdf->SetFont('Arial', '', 12);
if (mysqli_num_rows($resultado) > 0) {
    while ($gestion = mysqli_fetch_assoc($resultado)) {
        $pdf->Cell(80, 10, $gestion['gestion'], 1, 0, 'C');
        $pdf->Cell(80, 10, $gestion['cantidad_inscritos'], 1, 1, 'C');
    }
} else {
    // Mensaje si no hay datos disponibles
    $pdf->Cell(0, 10, 'No hay inscripciones registradas.', 1, 1, 'C');
}

// Salida del archivo PDF
$pdf->Output('I', 'Reporte_Inscritos_Por_Gestion.pdf'); // Mostrar en el navegador
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>
