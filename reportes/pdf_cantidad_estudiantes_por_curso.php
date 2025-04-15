<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');
require('../fpdf/fpdf.php'); // Asegúrate de que la librería FPDF esté disponible

// Consulta para obtener la cantidad de estudiantes por curso
$query = "SELECT c.nombre AS nombre_curso, 
                 COUNT(i.id_estudiante) AS cantidad_estudiantes
          FROM inscripciones i
          JOIN cursos c ON i.id_curso = c.id_curso
          GROUP BY c.id_curso, c.nombre
          ORDER BY cantidad_estudiantes DESC";

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
$pdf->Cell(0, 10, 'Reporte: Cantidad de Estudiantes por Curso', 0, 1, 'C');
$pdf->Ln(10); // Espacio entre líneas

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, 'Nombre del Curso', 1, 0, 'C');
$pdf->Cell(40, 10, 'Cantidad', 1, 1, 'C');

// Contenido de la tabla
$pdf->SetFont('Arial', '', 12);
if (mysqli_num_rows($resultado) > 0) {
    while ($curso = mysqli_fetch_assoc($resultado)) {
        $pdf->Cell(100, 10, utf8_decode($curso['nombre_curso']), 1, 0, 'L');
        $pdf->Cell(40, 10, $curso['cantidad_estudiantes'], 1, 1, 'C');
    }
} else {
    $pdf->Cell(0, 10, 'No hay estudiantes inscritos.', 1, 1, 'C');
}

// Salida del archivo PDF
$pdf->Output('I', 'Reporte_Cantidad_Estudiantes.pdf'); // Mostrar en el navegador
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>
