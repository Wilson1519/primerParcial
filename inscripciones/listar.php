<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

// Consulta para obtener las inscripciones con información de estudiantes, cursos y estado
$query = "SELECT i.id_inscripcion, 
                 e.nombre AS nombres_estudiante, 
                 e.apellido AS apellidos_estudiante, 
                 c.nombre AS nombre_curso, 
                 i.fecha_inscripcion, 
                 i.estado 
          FROM inscripciones i
          JOIN estudiantes e ON i.id_estudiante = e.id_estudiante
          JOIN cursos c ON i.id_curso = c.id_curso
          ORDER BY i.fecha_inscripcion";


$resultado = mysqli_query($conexion, $query);

// Manejo de errores de la consulta SQL
if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($conexion));
}

include('../includes/header.php'); // Incluye encabezado
?>

<div class="card">
    <h2>Listado de Inscripciones</h2>
    <a href="agregar.php" class="btn btn-agregar">Agregar Inscripción</a>

    <!-- Mensajes de éxito o error -->
    <?php if (isset($_GET['exito'])): ?>
        <div class="alert alert-success">
            <?php
            if ($_GET['exito'] == 'agregar') echo "Inscripción agregada correctamente.";
            elseif ($_GET['exito'] == 'editar') echo "Inscripción actualizada correctamente.";
            elseif ($_GET['exito'] == 'eliminar') echo "Inscripción eliminada correctamente.";
            ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php echo "Error: " . htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Tabla de inscripciones -->
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID Inscripción</th>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Fecha de Inscripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while ($inscripcion = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $inscripcion['id_inscripcion']; ?></td>
                        <td><?php echo $inscripcion['apellidos_estudiante'] . ', ' . $inscripcion['nombres_estudiante']; ?></td>
                        <td><?php echo $inscripcion['nombre_curso']; ?></td>
                        <td><?php echo $inscripcion['fecha_inscripcion']; ?></td>
                        <td><?php echo ucfirst($inscripcion['estado']); // Muestra "Activa" o "Cancelada" ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $inscripcion['id_inscripcion']; ?>" class="btn btn-editar">Editar</a>
                            <a href="eliminar.php?id=<?php echo $inscripcion['id_inscripcion']; ?>" class="btn btn-eliminar" onclick="return confirm('¿Está seguro de eliminar esta inscripción?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay inscripciones registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
include('../includes/footer.php'); // Incluye pie de página
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>
