<?php
require_once __DIR__ . '/../config/db.php';

// Comprobar si la conexión se ha establecido correctamente
if (isset($pdo)) {
    echo "<h1>¡Conexión a la base de datos exitosa!</h1>";
    echo "<p>Se ha conectado correctamente a la base de datos 'cliente_feliz_db'.</p>";
    
    // Información sobre la conexión
    echo "<h2>Detalles de la conexión:</h2>";
    echo "<ul>";
    echo "<li>Host: " . $host . "</li>";
    echo "<li>Base de datos: " . $dbname . "</li>";
    echo "<li>Usuario: " . $user . "</li>";
    echo "</ul>";
    
    // Versión de PHP y MySQL
    echo "<h2>Información del servidor:</h2>";
    echo "<ul>";
    echo "<li>Versión de PHP: " . phpversion() . "</li>";
    
    // Obtener la versión de MySQL
    try {
        $stmt = $pdo->query('SELECT VERSION() as version');
        $mysqlVersion = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<li>Versión de MySQL: " . $mysqlVersion['version'] . "</li>";
    } catch (PDOException $e) {
        echo "<li>No se pudo determinar la versión de MySQL</li>";
    }
    
    echo "</ul>";
    
    // Pruebas adicionales para verificar operaciones de base de datos
    echo "<h2>Pruebas de funcionalidad:</h2>";
    
    // 1. Comprobar si existe la tabla 'ofertas'
    try {
        $stmt = $pdo->query("SHOW TABLES LIKE 'ofertas'");
        if ($stmt->rowCount() > 0) {
            echo "<p style='color:green'>✓ La tabla 'ofertas' existe.</p>";
            
            // 2. Contar el número de registros en la tabla
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM ofertas");
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p>Número de ofertas: " . $count['total'] . "</p>";
            
            // 3. Mostrar los primeros 5 registros
            echo "<h3>Primeras 5 ofertas:</h3>";
            $stmt = $pdo->query("SELECT * FROM ofertas LIMIT 5");
            $ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($ofertas) > 0) {
                echo "<table border='1' cellpadding='5'>";
                echo "<tr>";
                foreach (array_keys($ofertas[0]) as $columna) {
                    echo "<th>" . htmlspecialchars($columna) . "</th>";
                }
                echo "</tr>";
                
                foreach ($ofertas as $oferta) {
                    echo "<tr>";
                    foreach ($oferta as $valor) {
                        echo "<td>" . htmlspecialchars($valor) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No hay ofertas para mostrar.</p>";
            }
        } else {
            echo "<p style='color:red'>✗ La tabla 'ofertas' no existe. Puede que necesites crearla.</p>";
            
            // Mostrar un ejemplo de código SQL para crear la tabla
            echo "<h3>SQL para crear la tabla:</h3>";
            echo "<pre>
CREATE TABLE ofertas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    activa TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
            </pre>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red'>✗ Error al verificar la tabla: " . $e->getMessage() . "</p>";
    }
    
} else {
    echo "<h1>Error de conexión</h1>";
    echo "<p>No se pudo establecer la conexión con la base de datos.</p>";
}
?>