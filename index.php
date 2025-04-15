<?php
require_once('includes/conexion.php');
require_once('includes/funciones.php');


include('includes/header.php');
?>
<div class="card">
    <h2>Bienvenido al Sistema de Inscripcion de Estudiantes</h2>

    <p>Este sistema permite gestionar estudiantes, cursos y Inscripciones de los colegios.</p>
    <div class="stats-container">
        <div class="star-card">
            <h3>Estudiantes Registrados</h3>
            <?php
            $query = "SELECT COUNT(*) as total FROM estudiantes";
            $resultado = mysqli_query($conexion, $query);
            $total = mysqli_fetch_assoc($resultado)['total'];
            mysqli_free_result($resultado);
            ?>
            <p class="stat-number"><?php echo $total; ?></p>
            <a href="estudiantes/listar.php" class="btn btn-editar">Ver Estudiantes</a>
        </div>
        <div class="stat-card">
            <h3>Cursos Disponibles</h3>
            <?php
            $query = "SELECT COUNT(*) as total FROM cursos";
            $resultado = mysqli_query($conexion, $query);
            $total = mysqli_fetch_assoc($resultado)['total'];
            mysqli_free_result($resultado);
            ?>
            <p class="stat-number"><?php echo $total; ?></p>
            <a href="cursos/listar.php" class="btn btn-editar">Ver Cursos</a>
        </div>
        <div class="stat-card">
            <h3>Inscripciones Realizadas</h3>
            <?php
            $query = "SELECT COUNT(*) as total FROM inscripciones";
            $resultado = mysqli_query($conexion, $query);
            $total = mysqli_fetch_assoc($resultado)['total'];
            mysqli_free_result($resultado);
            ?>
            <p class="stat-number"><?php echo $total; ?></p>
            <a href="inscripciones/listar.php" class="btn btn-editar">Ver Inscripciones</a>
            </div>

            <div class="recent-container">
                <h3>Ultimas Inscripciones Realizadas</h3>
                <?php
                $query = "SELECT i.id_inscripcion, e.nombre, c.nombre as curso, i.fecha_inscripcion FROM inscripciones i
                JOIN estudiantes e ON i.id_estudiante = e.id_estudiante
                JOIN cursos c ON i.id_curso = c.id_curso
                ORDER BY i.fecha_inscripcion DESC LIMIT 5";
                $resultado = mysqli_query($conexion, $query);
                ?>

                <table>
                    <thead>
                        <tr>
                            <th>ID Inscripción</th>
                            <th>Estudiante</th>
                            <th>Curso</th>
                            <th>Fecha Inscripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($resultado) > 0): ?>
                            <?php while ($inscripcion = mysqli_fetch_assoc($resultado)): ?>
                                <tr>
                                    <td><?php echo $inscripcion['id_inscripcion']; ?></td>
                                    <td><?php echo $inscripcion['nombre']; ?></td>
                                    <td><?php echo $inscripcion['curso']; ?></td>
                                    <td><?php echo $inscripcion['fecha_inscripcion']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No hay inscripciones registradas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
    </div>
</div>

<?php
include('includes/footer.php');
mysqli_free_result($resultado);
cerrar_conexion($conexion);
?>
