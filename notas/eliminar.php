<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

// Verificar que se envió un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: listar.php?error=id_no_valido');
    exit();
}

$id_nota = intval($_GET['id']);

// Manejar la confirmación y eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "DELETE FROM notas WHERE id_nota = $id_nota";

    if (mysqli_query($conexion, $query)) {
        // Redirigir con mensaje de éxito
        header('Location: listar.php?exito=eliminar');
        exit();
    } else {
        // Redirigir con mensaje de error
        header('Location: listar.php?error=eliminar');
        exit();
    }
}

include('../includes/header.php');
?>

<div class="form-container">
    <h2>Eliminar Nota</h2>
    <p>¿Está seguro de que desea eliminar esta nota? Esta acción no se puede deshacer.</p>
    <form method="post" action="">
        <div class="form-group">
            <input type="submit" value="Confirmar Eliminación" class="btn btn-eliminar">
            <a href="listar.php" class="btn btn-volver">Cancelar</a>
        </div>
    </form>
</div>

<?php
include('../includes/footer.php');
cerrar_conexion($conexion);
?>
