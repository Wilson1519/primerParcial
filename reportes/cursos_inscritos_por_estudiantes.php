<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

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

include('../includes/header.php'); // Encabezado de página
?>

<div class="card">
    <h2>Reporte de Cursos Inscritos por Estudiantes</h2>
    <a href="pdf_cursos_inscritos_por_estudiante.php" class="btn btn-danger">Descargar PDF</a>

    <?php 
    $estudiante_actual = ""; // Para rastrear el cambio de bloque por estudiante
    ?>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <?php while ($registro = mysqli_fetch_assoc($resultado)): ?>
            <?php 
            // Si el estudiante actual cambia, mostramos el encabezado de un nuevo bloque
            if ($estudiante_actual !== $registro['id_estudiante']): 
                if ($estudiante_actual !== ""):
                    // Cerramos la lista de cursos del estudiante anterior
                    echo "</ul>";
                endif;
                $estudiante_actual = $registro['id_estudiante']; 
            ?>
                <h3>Estudiante: <?php echo $registro['apellidos_est'] . ', ' . $registro['nombres_est']; ?></h3>
                <ul>
            <?php endif; ?>
                    <li><?php echo $registro['nombre_curso']; ?></li>
        <?php endwhile; ?>
                </ul>
    <?php else: ?>
        <p>No hay inscripciones registradas.</p>
    <?php endif; ?>

</div>

<?php
include('../includes/footer.php'); // Incluye el pie de página
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>
