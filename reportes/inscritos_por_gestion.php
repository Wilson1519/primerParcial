<?php
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');

// Consulta para obtener la cantidad de inscritos por gestión (año)
$query = "SELECT YEAR(i.fecha_inscripcion) AS gestion, 
                 COUNT(i.id_inscripcion) AS cantidad_inscritos
          FROM inscripciones i
          GROUP BY YEAR(i.fecha_inscripcion)
          ORDER BY gestion DESC";

$resultado = mysqli_query($conexion, $query);

// Manejo de errores en la consulta SQL
if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($conexion));
}

include('../includes/header.php'); // Encabezado de página
?>

<div class="card">
    <h2>Reporte de Inscritos por Gestión</h2>
    <a href="pdf_inscritos_por_gestion.php" class="btn btn-danger">Descargar PDF</a>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Gestión</th>
                <th>Cantidad de Inscritos</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while ($gestion = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $gestion['gestion']; ?></td>
                        <td><?php echo $gestion['cantidad_inscritos']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No hay inscripciones registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
include('../includes/footer.php'); // Incluye el pie de página
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>
