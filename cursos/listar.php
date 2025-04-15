<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

//Consulta pra obtener cursos
$query = "SELECT * FROM cursos ORDER BY nombre";
$resultado = mysqli_query($conexion, $query);

include('../includes/header.php');
?>

<div class="card">
    <h2>Listado de Cursos</h2>
    <a href="agregar.php" class="btn btn-agregar">Agregar Curso</a>
    <div class="alert alert-success">
    <?php if (isset($_GET['exito'])): ?>
        <div class="alert alert-success">
            <?php
            if ($_GET['exito'] == 'agregar') echo "Curso agregado correctamente.";
            elseif ($_GET['exito'] == 'editar') echo "Curso actualizado correctamente.";
            elseif ($_GET['exito'] == 'eliminar') echo "Curso eliminado correctamente.";
            ?>
        </div>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Horario</th>
                <th>Cupo Máximo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while ($curso = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?php echo $curso['id_curso']; ?></td>
                    <td><?php echo $curso['nombre']; ?></td>
                    <td><?php echo $curso['descripcion']; ?></td>
                    <td><?php echo $curso['horario']; ?></td>
                    <td><?php echo $curso['cupo_maximo']; ?></td>
                    <td><?php echo $curso['estado'] == 'activo' ? 'Activo' : 'Inactivo'; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $curso['id_curso']; ?>" class="btn btn-editar">Editar</a>
                        <a href="eliminar.php?id=<?php echo $curso['id_curso']; ?>" class="btn btn-eliminar">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No hay cursos registrados.</td>
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