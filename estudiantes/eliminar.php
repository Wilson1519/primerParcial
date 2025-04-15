<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    redireccionar('listar.php');
}

$id_estudiante = intval($_GET['id']);
// Verificar si el estudiante tiene inscripciones
$query = "SELECT COUNT(*) as total FROM inscripciones WHERE id_estudiante = $id_estudiante";
$resultado_incritos = mysqli_query($conexion, $query);
$total_incritos = mysqli_fetch_assoc($resultado_incritos)['total'];
if ($total_incritos > 0) {
    // No se puede eliminar, tiene inscripciones asociadas
    redireccionar('listar.php?error=estudiante_asociado');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = "DELETE FROM estudiantes WHERE id_estudiante = $id_estudiante";
    if (mysqli_query($conexion, $query)) {
        redireccionar('listar.php?exito=eliminar');
    } else {
        redireccionar('listar.php?error=eliminar');
    }
}
include('../includes/header.php');
?>
<div class="form-container">
    <h2>Eliminar Estudiante</h2>
    <?php if ($total_incritos > 0): ?>
        <div class="alert alert-error">
            <p>No se puede eliminar el estudiante porque tiene inscripciones asociadas.</p>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <p>¿Está seguro de que desea eliminar el estudiante?</p>
            <form method="post">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a href="listar.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    <?php endif; ?>
</div>
<?php
include('../includes/footer.php');
mysqli_free_result($resultado_matriculas);
cerrar_conexion($conexion);
?>