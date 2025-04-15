<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

// Consulta para obtener las notas con información de estudiantes y cursos
$query = "SELECT n.id_nota, 
                 e.nombre AS nombres_est, 
                 e.apellido AS apellidos_est, 
                 c.nombre AS nombre_curso, 
                 n.nota, 
                 n.fecha_nota 
          FROM notas n
          JOIN estudiantes e ON n.id_estudiante = e.id_estudiante
          JOIN cursos c ON n.id_curso = c.id_curso
          ORDER BY n.fecha_nota";


$resultado = mysqli_query($conexion, $query);

// Manejo de errores de la consulta SQL
if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($conexion));
}

include('../includes/header.php'); // Incluye el encabezado
?>

<div class="card">
    <h2>Listado de Notas</h2>
    <a href="agregar.php" class="btn btn-agregar">Agregar Nota</a>

    <!-- Mensajes de éxito o error -->
    <?php if (isset($_GET['exito'])): ?>
        <div class="alert alert-success">
            <?php
            if ($_GET['exito'] == 'agregar') echo "Nota agregada correctamente.";
            elseif ($_GET['exito'] == 'editar') echo "Nota actualizada correctamente.";
            elseif ($_GET['exito'] == 'eliminar') echo "Nota eliminada correctamente.";
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php echo "Error: " . htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Tabla de notas -->
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID Nota</th>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Nota</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while ($nota = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $nota['id_nota']; ?></td>
                        <td><?php echo $nota['apellidos_est'] . ', ' . $nota['nombres_est']; ?></td>
                        <td><?php echo $nota['nombre_curso']; ?></td>
                        <td><?php echo $nota['nota']; ?></td>
                        <td><?php echo $nota['fecha_nota']; ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $nota['id_nota']; ?>" class="btn btn-editar">Editar</a>
                            <a href="eliminar.php?id=<?php echo $nota['id_nota']; ?>" class="btn btn-eliminar" onclick="return confirm('¿Está seguro de eliminar esta nota?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay notas registradas.</td>
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
