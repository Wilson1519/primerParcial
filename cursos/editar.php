<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    redireccionar('listar.php');
}

$id_curso = intval($_GET['id']);
$query = "SELECT * FROM cursos WHERE id_curso = $id_curso";
$resultado = mysqli_query($conexion, $query);
$curso = mysqli_fetch_assoc($resultado);

if (!$curso) {
    redireccionar('listar.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = sanitizar($_POST['nombre']);
    $descripcion = sanitizar($_POST['descripcion']);
    $horario = sanitizar($_POST['horario']);
    $cupo_maximo = sanitizar($_POST['cupo_maximo']);
    $estado = sanitizar($_POST['estado']);

    $errores = array();

    if (empty($nombre)) $errores[] = "El nombre del curso es obligatorio.";
    if (empty($descripcion)) $errores[] = "La descripción del curso es obligatoria.";
    if (empty($horario)) $errores[] = "El horario del curso es obligatorio.";
    if (empty($cupo_maximo)) $errores[] = "El cupo máximo del curso es obligatorio.";
    if (!is_numeric($cupo_maximo)) $errores[] = "El cupo máximo debe ser un número.";
    if ($cupo_maximo <= 0) $errores[] = "El cupo máximo debe ser mayor a cero.";
    if (empty($estado)) $errores[] = "El estado del curso es obligatorio.";

    if (empty($errores)) {
        $query = "UPDATE cursos SET nombre='$nombre', descripcion='$descripcion', horario='$horario', cupo_maximo='$cupo_maximo', estado='$estado' WHERE id_curso=$id_curso";
        if (mysqli_query($conexion, $query)) {
            redireccionar('listar.php?exito=editar');
        } else {
            $errores[] = "Error al editar el curso: " . mysqli_error($conexion);
        }
    }
}
include_once('../includes/header.php');
?>

<div class="form-container">
    <h2>Editar Curso</h2>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="nombre">Nombre del Curso:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($curso['nombre']); ?>" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required><?php echo htmlspecialchars($curso['descripcion']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="horario">Horario:</label>
            <input type="text" name="horario" id="horario" value="<?php echo htmlspecialchars($curso['horario']); ?>" required>
        </div>
        <div class="form-group">
            <label for="cupo_maximo">Cupo Máximo:</label>
            <input type="number" name="cupo_maximo" id="cupo_maximo" value="<?php echo htmlspecialchars($curso['cupo_maximo']); ?>" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="" disabled selected>Seleccione un estado</option>
                <option value="activo" <?php if ($curso['estado'] == 'activo') echo 'selected'; ?>>Activo</option>
                <option value="inactivo" <?php if ($curso['estado'] == 'inactivo') echo 'selected'; ?>>Inactivo</option>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" value="Actualizar Curso" class="btn btn-submit">
            <a href="listar.php" class="btn btn-volver">Volver al Listado</a>
        </div>
    </form>
</div>

<?php
include('../includes/footer.php');
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>