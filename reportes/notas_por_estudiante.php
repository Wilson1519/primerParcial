<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

// Consulta para obtener las notas de los estudiantes en sus cursos
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

include('../includes/header.php'); // Encabezado de página
?>

<div class="card">
    <h2>Reporte de Notas por Estudiante</h2>
    <a href="pdf_notas_por_estudiante.php" class="btn btn-danger">Descargar PDF</a>
    <?php 
    $estudiante_actual = ""; // Para rastrear el cambio de bloque por estudiante
    ?>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <?php while ($registro = mysqli_fetch_assoc($resultado)): ?>
            <?php 
            // Si el estudiante actual cambia, mostramos el encabezado de un nuevo bloque
            if ($estudiante_actual !== $registro['id_estudiante']): 
                if ($estudiante_actual !== ""):
                    // Cerramos la tabla del estudiante anterior
                    echo "</tbody></table>";
                endif;
                $estudiante_actual = $registro['id_estudiante']; 
            ?>
                <h3>Estudiante: <?php echo $registro['apellidos_est'] . ', ' . $registro['nombres_est']; ?></h3>
                <table border="1" cellpadding="5" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Nota</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php endif; ?>
                        <tr>
                            <td><?php echo $registro['nombre_curso']; ?></td>
                            <td><?php echo $registro['nota']; ?></td>
                            <td><?php echo $registro['fecha_nota']; ?></td>
                        </tr>
        <?php endwhile; ?>
                    </tbody>
                </table>
    <?php else: ?>
        <p>No hay notas registradas.</p>
    <?php endif; ?>

</div>

<?php
include('../includes/footer.php'); // Incluye el pie de página
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>
