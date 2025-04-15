<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

//Consulta para obtener estudiantes
$query = "SELECT * FROM estudiantes ORDER BY apellido, nombre";
$resultado = mysqli_query($conexion, $query);
include('../includes/header.php');
?>
<div class="card">
    <h2>Listado de Estudiantes</h2>
    <a href="agregar.php" class="btn btn-agregar">Agregar Estudiante</a>
    <div class="alert alert-success">
        <?php if (isset($_GET['exito'])): ?>
            <div class="alert alert-success">
                <?php
                if ($_GET['exito'] == 'agregar') echo "Estudiante agregado correctamente.";
                elseif ($_GET['exito'] == 'editar') echo "Estudiante actualizado correctamente.";
                elseif ($_GET['exito'] == 'eliminar') echo "Estudiante eliminado correctamente.";
                ?>
            </div>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Teléfono</th>
                    <th>Direccion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($resultado) > 0): ?>
                    <?php while ($estudiante = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo $estudiante['id_estudiante']; ?></td>
                            <td><?php echo $estudiante['nombre']; ?></td>
                            <td><?php echo $estudiante['apellido']; ?></td>
                            <td><?php echo $estudiante['fecha_nacimiento']; ?></td>
                            <td><?php echo $estudiante['telefono']; ?></td>
                            <td><?php echo $estudiante['direccion']; ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $estudiante['id_estudiante']; ?>" class="btn btn-editar">Editar</a>
                                <a href="eliminar.php?id=<?php echo $estudiante['id_estudiante']; ?>" class="btn btn-eliminar">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No hay estudiantes registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
include('../includes/footer.php');
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>