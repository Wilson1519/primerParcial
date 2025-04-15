<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

// Consulta para obtener la cantidad de estudiantes por curso
$query = "SELECT c.id_curso, 
                 c.nombre AS nombre_curso, 
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

include('../includes/header.php'); // Encabezado de página
?>

<div class="card">
    <h2>Reporte de Cantidad de Estudiantes por Curso</h2>
    <a href="pdf_cantidad_estudiantes_por_curso.php" class="btn btn-danger">Descargar PDF</a>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID Curso</th>
                <th>Nombre del Curso</th>
                <th>Cantidad de Estudiantes</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while ($curso = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $curso['id_curso']; ?></td>
                        <td><?php echo $curso['nombre_curso']; ?></td>
                        <td><?php echo $curso['cantidad_estudiantes']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay estudiantes inscritos en los cursos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
include('../includes/footer.php'); // Incluye el pie de página
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>
