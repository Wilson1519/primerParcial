<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

// Obtener listas de estudiantes y cursos
$query_estudiantes = "SELECT id_estudiante, nombre, apellido FROM estudiantes ORDER BY apellido, nombre";
$resultado_estudiantes = mysqli_query($conexion, $query_estudiantes);

$query_cursos = "SELECT id_curso, nombre FROM cursos ORDER BY nombre";
$resultado_cursos = mysqli_query($conexion, $query_cursos);

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_estudiante = intval($_POST['id_estudiante']);
    $id_curso = intval($_POST['id_curso']);
    $nota = floatval($_POST['nota']);
    $fecha_nota = sanitizar($_POST['fecha_nota']);

    $errores = [];

    // Validar campos obligatorios
    if ($id_estudiante <= 0) $errores[] = "Debe seleccionar un estudiante.";
    if ($id_curso <= 0) $errores[] = "Debe seleccionar un curso.";
    if ($nota < 0 || $nota > 100) $errores[] = "La nota debe estar entre 0 y 100.";
    if (empty($fecha_nota)) $errores[] = "La fecha de la nota es obligatoria.";

    // Insertar los datos si no hay errores
    if (empty($errores)) {
        $query = "INSERT INTO notas (id_estudiante, id_curso, nota, fecha_nota) 
                  VALUES ($id_estudiante, $id_curso, $nota, '$fecha_nota')";

        if (mysqli_query($conexion, $query)) {
            header('Location: listar.php?exito=agregar');
            exit();
        } else {
            $errores[] = "Error al agregar la nota: " . mysqli_error($conexion);
        }
    }
}

include('../includes/header.php');
?>

<div class="form-container">
    <h2>Agregar Nueva Nota</h2>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <!-- Campo para seleccionar estudiante -->
        <div class="form-group">
            <label for="id_estudiante">Estudiante:</label>
            <select id="id_estudiante" name="id_estudiante" class="form-control" required>
                <option value="">-- Seleccione un estudiante --</option>
                <?php while ($estudiante = mysqli_fetch_assoc($resultado_estudiantes)): ?>
                    <option value="<?php echo $estudiante['id_estudiante']; ?>"
                        <?php echo (isset($_POST['id_estudiante']) && $_POST['id_estudiante'] == $estudiante['id_estudiante']) ? 'selected' : ''; ?>>
                        <?php echo $estudiante['apellido'] . ', ' . $estudiante['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Campo para seleccionar curso -->
        <div class="form-group">
            <label for="id_curso">Curso:</label>
            <select id="id_curso" name="id_curso" class="form-control" required>
                <option value="">-- Seleccione un curso --</option>
                <?php while ($curso = mysqli_fetch_assoc($resultado_cursos)): ?>
                    <option value="<?php echo $curso['id_curso']; ?>"
                        <?php echo (isset($_POST['id_curso']) && $_POST['id_curso'] == $curso['id_curso']) ? 'selected' : ''; ?>>
                        <?php echo $curso['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Campo para la nota -->
        <div class="form-group">
            <label for="nota">Nota:</label>
            <input type="number" id="nota" name="nota" class="form-control"
                   value="<?php echo isset($_POST['nota']) ? $_POST['nota'] : ''; ?>" step="0.01" min="0" max="100" required>
        </div>

        <!-- Campo para la fecha de la nota -->
        <div class="form-group">
            <label for="fecha_nota">Fecha de la Nota:</label>
            <input type="date" id="fecha_nota" name="fecha_nota" class="form-control"
                   value="<?php echo isset($_POST['fecha_nota']) ? $_POST['fecha_nota'] : date('Y-m-d'); ?>" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-submit">Guardar Nota</button>
            <a href="listar.php" class="btn btn-volver">Volver al Listado</a>
        </div>
    </form>
</div>

<?php
include('../includes/footer.php');
mysqli_free_result($resultado_estudiantes);
mysqli_free_result($resultado_cursos);
cerrar_conexion($conexion);
?>
