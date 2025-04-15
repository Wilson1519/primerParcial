<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

// Verificar que se envió un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: listar.php?error=id_no_valido');
    exit();
}

$id_inscripcion = intval($_GET['id']);

// Obtener los datos de la inscripción
$query_inscripcion = "SELECT * FROM inscripciones WHERE id_inscripcion = $id_inscripcion";
$resultado_inscripcion = mysqli_query($conexion, $query_inscripcion);
$inscripcion = mysqli_fetch_assoc($resultado_inscripcion);

if (!$inscripcion) {
    header('Location: listar.php?error=inscripcion_no_encontrada');
    exit();
}

// Obtener listas de estudiantes y cursos
$query_estudiantes = "SELECT id_estudiante, nombre, apellido FROM estudiantes ORDER BY apellido, nombre";
$resultado_estudiantes = mysqli_query($conexion, $query_estudiantes);

$query_cursos = "SELECT id_curso, nombre FROM cursos ORDER BY nombre";
$resultado_cursos = mysqli_query($conexion, $query_cursos);

// Manejo del formulario para actualizar la inscripción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_estudiante = intval($_POST['id_estudiante']);
    $id_curso = intval($_POST['id_curso']);
    $fecha_inscripcion = sanitizar($_POST['fecha_inscripcion']);
    $estado = sanitizar($_POST['estado']);

    $errores = [];

    // Validación de los campos
    if ($id_estudiante <= 0) $errores[] = "Debe seleccionar un estudiante.";
    if ($id_curso <= 0) $errores[] = "Debe seleccionar un curso.";
    if (empty($fecha_inscripcion)) $errores[] = "La fecha de inscripción es obligatoria.";
    if (!in_array($estado, ['activa', 'cancelada'])) $errores[] = "El estado seleccionado no es válido.";

    // Actualizar inscripción si no hay errores
    if (empty($errores)) {
        $query_actualizar = "UPDATE inscripciones 
                             SET id_estudiante = '$id_estudiante', 
                                 id_curso = '$id_curso', 
                                 fecha_inscripcion = '$fecha_inscripcion', 
                                 estado = '$estado' 
                             WHERE id_inscripcion = $id_inscripcion";

        if (mysqli_query($conexion, $query_actualizar)) {
            header('Location: listar.php?exito=editar');
            exit();
        } else {
            $errores[] = "Error al actualizar la inscripción: " . mysqli_error($conexion);
        }
    }
}

include('../includes/header.php');
?>

<div class="form-container">
    <h2>Editar Inscripción</h2>

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
                        <?php echo ($inscripcion['id_estudiante'] == $estudiante['id_estudiante']) ? 'selected' : ''; ?>>
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
                        <?php echo ($inscripcion['id_curso'] == $curso['id_curso']) ? 'selected' : ''; ?>>
                        <?php echo $curso['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Campo para la fecha de inscripción -->
        <div class="form-group">
            <label for="fecha_inscripcion">Fecha de Inscripción:</label>
            <input type="date" id="fecha_inscripcion" name="fecha_inscripcion" class="form-control"
                   value="<?php echo htmlspecialchars($inscripcion['fecha_inscripcion']); ?>" required>
        </div>

        <!-- Campo para el estado -->
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" class="form-control" required>
                <option value="activa" <?php echo ($inscripcion['estado'] === 'activa') ? 'selected' : ''; ?>>Activa</option>
                <option value="cancelada" <?php echo ($inscripcion['estado'] === 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
            </select>
        </div>

        <!-- Botones para guardar o cancelar -->
        <div class="form-group">
            <button type="submit" class="btn btn-submit">Guardar Cambios</button>
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
