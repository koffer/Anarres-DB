<?php
/**
 * mostrar_alumnos.php
 * Archivo final para mostrar los datos de la institución: Alumnos, Clases, Salones y Talleres.
 */

// 1. INCLUSIÓN DE LA CONEXIÓN
// Requerimos el archivo de conexión. (db_connect.php debe estar configurado para PostgreSQL)
require_once 'db_connect.php'; 


// ***************************************************************
// --- CONSULTA 1: DATOS DE ALUMNOS (Información general) ---
// ***************************************************************
try {
    $sql_alumnos = "
        SELECT
            a.nombre AS nombre_alumno,
            a.descripcion AS descripcion_alumno,
            d.titulo AS dormitorio,
            pn.nombre AS lugar_nacimiento,
            pt.nombre AS lugar_trabajo
        FROM alumnos a
        JOIN dormitorios d ON a.dormitorios_id = d.id
        JOIN poblacion pn ON a.nacimiento_id = pn.id
        JOIN poblacion pt ON a.trabajo_id = pt.id
        ORDER BY a.nombre ASC
    ";

    $stmt_alumnos = $pdo->query($sql_alumnos);
    $alumnos = $stmt_alumnos->fetchAll(PDO::FETCH_ASSOC);

} catch (\PDOException $e) {
    die("❌ ¡Error al ejecutar la consulta de Alumnos! " . $e->getMessage());
}


// ***************************************************************
// --- CONSULTA 2: CLASES, SALONES Y TALLERES ASOCIADOS ---
// ***************************************************************
try {
    // 2a. Consulta para Clases y Salones
    $sql_clases_salones = "
        SELECT
            c.titulo AS clase,
            s.titulo AS salon
        FROM clases c
        INNER JOIN clases_salones cs ON c.id = cs.clases_id
        INNER JOIN salones s ON cs.salones_id = s.id
        ORDER BY c.titulo, s.titulo ASC
    ";
    
    $stmt_clases_salones = $pdo->query($sql_clases_salones);
    $clases_salones = $stmt_clases_salones->fetchAll(PDO::FETCH_ASSOC);

    // 2b. Consulta para Clases y Talleres
    $sql_clases_talleres = "
        SELECT
            c.titulo AS clase,
            t.titulo AS taller
        FROM clases c
        INNER JOIN clases_talleres ct ON c.id = ct.clases_id
        INNER JOIN talleres t ON ct.talleres_id = t.id
        ORDER BY c.titulo, t.titulo ASC
    ";

    $stmt_clases_talleres = $pdo->query($sql_clases_talleres);
    $clases_talleres = $stmt_clases_talleres->fetchAll(PDO::FETCH_ASSOC);

} catch (\PDOException $e) {
    die("❌ ¡Error al ejecutar la consulta de Clases/Salones/Talleres! " . $e->getMessage());
}


// ***************************************************************
// --- NUEVA CONSULTA 3: ALUMNOS Y SUS CLASES ASIGNADAS ---
// ***************************************************************
try {
    // Consulta para listar cada alumno con las clases que cursa.
    $sql_alumnos_clases = "
        SELECT
            a.nombre AS nombre_alumno,
            c.titulo AS clase_asignada
        FROM alumnos a
        INNER JOIN alumnos_clases ac ON a.id = ac.alumnos_id  -- Unión M:M: Alumnos con Alumnos_Clases
        INNER JOIN clases c ON ac.clases_id = c.id           -- Clases con Alumnos_Clases
        ORDER BY a.nombre ASC, c.titulo ASC
    ";

    $stmt_alumnos_clases = $pdo->query($sql_alumnos_clases);
    $alumnos_clases = $stmt_alumnos_clases->fetchAll(PDO::FETCH_ASSOC);

    // Opcional: Agrupar resultados por alumno para una mejor presentación
    $alumnos_clases_agrupados = [];
    foreach ($alumnos_clases as $registro) {
        $nombre = $registro['nombre_alumno'];
        $clase = $registro['clase_asignada'];
        
        // Creamos un nuevo índice si no existe
        if (!isset($alumnos_clases_agrupados[$nombre])) {
            $alumnos_clases_agrupados[$nombre] = [];
        }
        // Añadimos la clase al array de ese alumno
        $alumnos_clases_agrupados[$nombre][] = $clase;
    }


} catch (\PDOException $e) {
    die("❌ ¡Error al ejecutar la consulta de Alumnos/Clases! " . $e->getMessage());
}


// ***************************************************************
// --- PRESENTACIÓN HTML ---
// ***************************************************************
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos de la Institución</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #333; border-bottom: 2px solid #ccc; padding-bottom: 5px; font-size: 2578/870px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 30px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; color: #555; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .vacio { text-align: center; color: #888; padding: 20px; border: 1px dashed #ccc; }
        .clases-lista { list-style: disc; margin-left: 20px; padding-left: 0; }
        .clases-lista li { margin-bottom: 5px; }
    </style>
</head>
<body>

    <h1>🏢 Reporte General de la Escuela Odonian</h1>

    <h2>1. 🧑‍🎓 Lista de Alumnos</h2>
    <?php if (count($alumnos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Dormitorio</th>
                    <th>Lugar de Nacimiento</th>
                    <th>Lugar donde posiblemente Trabajen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alumnos as $alumno): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($alumno['nombre_alumno']); ?></strong></td>
                        <td><?php echo htmlspecialchars($alumno['descripcion_alumno']); ?></td>
                        <td><?php echo htmlspecialchars($alumno['dormitorio']); ?></td>
                        <td><?php echo htmlspecialchars($alumno['lugar_nacimiento']); ?></td>
                        <td><?php echo htmlspecialchars($alumno['lugar_trabajo']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="vacio"><p>¡Vaya! No se encontraron alumnos.</p></div>
    <?php endif; ?>
    
    <hr>

    <h2>4. 📝 Clases Cursadas por Alumno</h2>
    <?php if (count($alumnos_clases_agrupados) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 30%;">Alumno</th>
                    <th>Clases Asignadas</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Iteramos sobre el array que AGRUPAMOS en la lógica de PHP
                foreach ($alumnos_clases_agrupados as $nombre => $clases): 
                ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($nombre); ?></strong></td>
                        <td>
                            <ul class="clases-lista">
                                <?php foreach ($clases as $clase): ?>
                                    <li><?php echo htmlspecialchars($clase); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="vacio">
            <p>¡Vaya! No se encontraron alumnos inscritos en clases.</p>
        </div>
    <?php endif; ?>

    <hr>

    <h2>2. 📚 Asignación de Clases a Salones</h2>
    <?php if (count($clases_salones) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Clase (Materia)</th>
                    <th>Salón Asignado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clases_salones as $item): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($item['clase']); ?></strong></td>
                        <td><?php echo htmlspecialchars($item['salon']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="vacio"><p>¡Vaya! No se encontraron clases con salones asignados.</p></div>
    <?php endif; ?>
    
    <hr>

    <h2>3. 🛠️ Asignación de Clases a Talleres</h2>
    <?php if (count($clases_talleres) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Clase (Materia)</th>
                    <th>Taller Asignado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clases_talleres as $item): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($item['clase']); ?></strong></td>
                        <td><?php echo htmlspecialchars($item['taller']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="vacio"><p>¡Vaya! No se encontraron clases con talleres asignados.</p></div>
    <?php endif; ?>

</body>
</html>