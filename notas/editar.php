<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

// Verificar que se envió un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: listar.php?error=id_no_valido');
    exit();
}

$id_nota = intval($_GET['id']);

// Obtener los datos de la nota
$query_nota = "SELECT * FROM notas WHERE id_nota = $id_nota";
$resultado_nota = mysqli_query($conexion, $query_nota);
$nota = mysqli_fetch_assoc($resultado_nota);

if (!$nota) {
    header('Location: listar.php?error=nota_no_encontrada');
    exit();
}

// Obtener listas de estudiantes y cursos
$query_estudiantes = "SELECT id_estudiante, nombres, apellidos FROM estudiantes ORDER BY apellidos, nombres";
$resultado_estudiantes = mysqli_query($conexion, $query_estudiantes);

$query_cursos = "SELECT id_curso, nombre FROM cursos ORDER BY nombre";
$resultado_cursos = mysqli_query($conexion, $query_cursos);

// Manejo del formulario para actualizar la nota
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_estudiante = intval($_POST['id_estudiante']);
    $id_curso = intval($_POST['id_curso']);
    $nota_valor = floatval($_POST['nota']);
    $fecha_nota = sanitizar($_POST['fecha_nota']);

    $errores = [];

    // Validación de los campos
    if ($id_estudiante <= 0) $errores[] = "Debe seleccionar un estudiante.";
    if ($id_curso <= 0) $errores[] = "Debe seleccionar un curso.";
    if ($nota_valor < 0 || $nota_valor > 100) $errores[] = "La nota debe estar entre 0 y 100.";
    if (empty($fecha_nota)) $errores[] = "La fecha de la nota es obligatoria.";

    // Actualizar nota si no hay errores
    if (empty($errores)) {
        $query_actualizar = "UPDATE notas 
                             SET id_estudiante = $id_estudiante, 
                                 id_curso = $id_curso, 
                                 nota = $nota_valor, 
                                 fecha_nota = '$fecha_nota' 
                             WHERE id_nota = $id_nota";

        if (mysqli_query($conexion, $query_actualizar)) {
            header('Location: listar.php?exito=editar');
            exit();
        } else {
            $errores[] = "Error al actualizar la nota: " . mysqli_error($conexion);
        }
    }
}

include('../includes/header.php');
?>

<div class="form-container">
    <h2>Editar Nota</h2>

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
                        <?php echo ($nota['id_estudiante'] == $estudiante['id_estudiante']) ? 'selected' : ''; ?>>
                        <?php echo $estudiante['apellidos'] . ', ' . $estudiante['nombres']; ?>
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
                        <?php echo ($nota['id_curso'] == $curso['id_curso']) ? 'selected' : ''; ?>>
                        <?php echo $curso['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Campo para la nota -->
        <div class="form-group">
            <label for="nota">Nota:</label>
            <input type="number" id="nota" name="nota" class="form-control"
                   value="<?php echo htmlspecialchars($nota['nota']); ?>" step="0.01" min="0" max="100" required>
        </div>

        <!-- Campo para la fecha de la nota -->
        <div class="form-group">
            <label for="fecha_nota">Fecha de la Nota:</label>
            <input type="date" id="fecha_nota" name="fecha_nota" class="form-control"
                   value="<?php echo htmlspecialchars($nota['fecha_nota']); ?>" required>
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
