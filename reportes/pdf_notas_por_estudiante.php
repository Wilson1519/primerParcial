<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');
require('../fpdf/fpdf.php'); // Asegúrate de que la librería FPDF esté disponible

// Consulta para obtener las notas de los estudiantes
$query = "SELECT e.id_estudiante, 
                 e.nombre AS nombres_est, 
                 e.apellido AS apellidos_est, 
                 c.nombre AS nombre_curso, 
                 n.nota, 
                 n.fecha_nota
          FROM notas n
          JOIN estudiantes e ON n.id_estudiante = e.id_estudiante
          JOIN cursos c ON n.id_curso = c.id_curso
          ORDER BY e.apellido, e.nombre, c.nombre";

$resultado = mysqli_query($conexion, $query);

// Manejo de errores en la consulta SQL
if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($conexion));
}

// Crear el PDF usando FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Título del PDF
$pdf->Cell(0, 10, 'Reporte: Notas por Estudiante', 0, 1, 'C');
$pdf->Ln(10); // Espacio entre líneas

// Variables para rastrear cambios por estudiante
$estudiante_actual = "";
if (mysqli_num_rows($resultado) > 0) {
    while ($registro = mysqli_fetch_assoc($resultado)) {
        // Si el estudiante actual cambia, agregamos un encabezado nuevo
        if ($estudiante_actual !== $registro['id_estudiante']) {
            $estudiante_actual = $registro['id_estudiante'];
            // Encabezado del bloque para cada estudiante
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, utf8_decode('Estudiante: ' . $registro['apellidos_est'] . ', ' . $registro['nombres_est']), 0, 1);
            $pdf->Ln(5); // Espacio entre el estudiante y sus notas
            // Encabezados de la tabla de notas
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(80, 10, 'Curso', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Nota', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Fecha', 1, 1, 'C');
        }
        // Agregar filas para las notas del estudiante actual
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, 10, utf8_decode($registro['nombre_curso']), 1, 0, 'L');
        $pdf->Cell(40, 10, $registro['nota'], 1, 0, 'C');
        $pdf->Cell(40, 10, $registro['fecha_nota'], 1, 1, 'C');
    }
} else {
    // Mensaje si no hay datos disponibles
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'No hay notas registradas.', 0, 1, 'C');
}

// Salida del archivo PDF
$pdf->Output('I', 'Reporte_Notas_Por_Estudiante.pdf'); // Mostrar en el navegador
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>
