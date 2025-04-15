<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

if(!isset($_GET['id']) || empty($_GET['id'])) {
    redireccionar('listar.php');
}
$id_estudiante = intval($_GET['id']);
$query = "SELECT * FROM estudiantes WHERE id_estudiante = $id_estudiante";
$resultado = mysqli_query($conexion, $query);
$estudiante = mysqli_fetch_assoc($resultado);
if(!$estudiante) {
    redireccionar('listar.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = sanitizar($_POST['nombre']);
    $apellido = sanitizar($_POST['apellido']);
    $fecha_nacimiento = sanitizar($_POST['fecha_nacimiento']);
    $direccion = sanitizar($_POST['direccion']);
    $telefono = sanitizar($_POST['telefono']);
    $fecha_registro = date('Y-m-d H:i:s');
    $errores = array();
    if(empty($nombre)) $errores[] = "El nombre es obligatorio.";
    if(empty($apellido)) $errores[] = "El apellido es obligatorio.";
    if(empty($fecha_nacimiento)) $errores[] = "La fecha de nacimiento es obligatoria.";
    if(empty($direccion)) $errores[] = "La dirección es obligatoria.";
    if(empty($telefono)) $errores[] = "El teléfono es obligatorio.";
    if(!preg_match('/^[0-9]{10}$/', $telefono)) $errores[] = "El teléfono debe tener 10 dígitos.";
    if(empty($errores)) {
        $query = "UPDATE estudiantes SET nombre='$nombre', apellido='$apellido', fecha_nacimiento='$fecha_nacimiento', direccion='$direccion', telefono='$telefono' WHERE id_estudiante=$id_estudiante";
        if(mysqli_query($conexion, $query)) {
            redireccionar('listar.php?exito=editar');
        } else {
            $errores[] = "Error al editar el estudiante: " . mysqli_error($conexion);
        }
    }
}
include_once('../includes/header.php');
?>
<div class="form-container">
    <h2>Editar Estudiante</h2>
    <?php if(!empty($errores)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" action="">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control"
             value="<?php echo htmlspecialchars($estudiante['nombre']); ?>" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" class="form-control"
             value="<?php echo htmlspecialchars($estudiante['apellido']); ?>" required>
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control"
             value="<?php echo htmlspecialchars($estudiante['fecha_nacimiento']); ?>" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion" class="form-control"
             value="<?php echo htmlspecialchars($estudiante['direccion']); ?>" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" class="form-control"
             value="<?php echo htmlspecialchars($estudiante['telefono']); ?>" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Actualizar Estudiante" class="btn btn-submit">
            <a href="listar.php" class="btn btn-volver">Volver al Listado</a>
        </div>
    </form>
</div>
<?php
include('../includes/footer.php');
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>