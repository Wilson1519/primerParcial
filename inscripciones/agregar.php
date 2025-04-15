<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

// Obtener listas de estudiantes y cursos
$query_estudiantes = "SELECT id_estudiante, nombre, apellido FROM estudiantes ORDER BY apellido, nombre";
$resultado_estudiantes = mysqli_query($conexion, $query_estudiantes);

// Manejo de errores en la consulta
if (!$resultado_estudiantes) {
    die("Error en la consulta SQL: " . mysqli_error($conexion));
}

$query_cursos = "SELECT id_curso, nombre FROM cursos ORDER BY nombre";
$resultado_cursos = mysqli_query($conexion, $query_cursos);

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_estudiante = intval($_POST['id_estudiante']);
    $id_curso = intval($_POST['id_curso']);
    $fecha_inscripcion = sanitizar($_POST['fecha_inscripcion']);
    $estado = sanitizar($_POST['estado']);

    $errores = [];

    // Validar campos obligatorios
    if ($id_estudiante <= 0) $errores[] = "Debe seleccionar un estudiante.";
    if ($id_curso <= 0) $errores[] = "Debe seleccionar un curso.";
    if (empty($fecha_inscripcion)) $errores[] = "La fecha de inscripción es obligatoria.";
    if (!in_array($estado, ['activa', 'cancelada'])) $errores[] = "El estado seleccionado no es válido.";

    // Insertar los datos si no hay errores
    if (empty($errores)) {
        $query = "INSERT INTO inscripciones (id_estudiante, id_curso, fecha_inscripcion, estado) 
                  VALUES ($id_estudiante, $id_curso, '$fecha_inscripcion', '$estado')";

        if (mysqli_query($conexion, $query)) {
            header('Location: listar.php?exito=agregar');
            exit();
        } else {
            $errores[] = "Error al agregar la inscripción: " . mysqli_error($conexion);
        }
    }
}

include('../includes/header.php');
?>

<div class="form-container">
    <h2>Agregar Nueva Inscripción</h2>

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

        <!-- Campo para la fecha de inscripción -->
        <div class="form-group">
            <label for="fecha_inscripcion">Fecha de Inscripción:</label>
            <input type="date" id="fecha_inscripcion" name="fecha_inscripcion" class="form-control"
                   value="<?php echo isset($_POST['fecha_inscripcion']) ? $_POST['fecha_inscripcion'] : date('Y-m-d'); ?>" required>
        </div>

        <!-- Campo para el estado -->
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" class="form-control" required>
                <option value="activa" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'activa') ? 'selected' : ''; ?>>Activa</option>
                <option value="cancelada" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-submit">Guardar Inscripción</button>
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
