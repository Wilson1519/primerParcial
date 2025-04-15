<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');
require('../fpdf/fpdf.php'); // Asegúrate de que la librería FPDF esté disponible

// Consulta para obtener los estudiantes y los cursos inscritos
$query = "SELECT e.id_estudiante, 
                 e.nombre AS nombres_est, 
                 e.apellido AS apellidos_est, 
                 c.nombre AS nombre_curso
          FROM inscripciones i
          JOIN estudiantes e ON i.id_estudiante = e.id_estudiante
          JOIN cursos c ON i.id_curso = c.id_curso
          ORDER BY e.apellido, e.nombre, c.nombre";

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
$pdf->Cell(0, 10, 'Reporte: Cursos Inscritos por Estudiante', 0, 1, 'C');
$pdf->Ln(10); // Espacio entre líneas

// Variables para rastrear cambios por estudiante
$estudiante_actual = "";
if (mysqli_num_rows($resultado) > 0) {
    while ($registro = mysqli_fetch_assoc($resultado)) {
        // Si el estudiante actual cambia, agregamos un encabezado nuevo
        if ($estudiante_actual !== $registro['id_estudiante']) {
            $estudiante_actual = $registro['id_estudiante'];
            // Encabezado para cada estudiante
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, utf8_decode('Estudiante: ' . $registro['apellidos_est'] . ', ' . $registro['nombres_est']), 0, 1);
            $pdf->Ln(5); // Espacio entre estudiante y sus cursos
            $pdf->SetFont('Arial', '', 12);
        }
        // Listado de cursos del estudiante
        $pdf->Cell(0, 10, utf8_decode('- Curso: ' . $registro['nombre_curso']), 0, 1);
    }
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'No hay inscripciones registradas.', 0, 1, 'C');
}

// Salida del archivo PDF
$pdf->Output('I', 'Reporte_Cursos_Inscritos.pdf'); // Mostrar en el navegador
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>
