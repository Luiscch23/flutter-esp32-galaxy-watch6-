<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

header("Content-Type: application/json");

// Verifica si se reciben datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se reciben los dos parámetros esperados
    if (isset($_POST['parametro1']) && isset($_POST['parametro2'])) {
        $parametro1 = $_POST['parametro1'];
        $parametro2 = $_POST['parametro2'];

        $dbname = "theclea1_vocho";
        $servername = "localhost";
        $username = "theclea1_Luiscch23";
        $password = "ErneyRafitasonnovios##@12";

        // Crear la conexión
        $mysqli = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($mysqli->connect_error) {
            die("Conexión fallida: " . $mysqli->connect_error);
        }

        // Escapa los datos para evitar inyección de SQL
        $parametro1 = $mysqli->real_escape_string($parametro1);
        $parametro2 = $mysqli->real_escape_string($parametro2);

        // Crea la sentencia SQL preparada
        $sql = "UPDATE arranque SET parametro1_estado = ?, parametro2_estado = ?";

        // Prepara la sentencia SQL
        $stmt = $mysqli->prepare($sql);

        // Vincula los parámetros
        $stmt->bind_param("ss", $parametro1, $parametro2);

        // Ejecuta la sentencia SQL
        if ($stmt->execute()) {
            $respuesta = array(
                'mensaje' => 'Estados de variables actualizados correctamente',
                'parametro1' => $parametro1,
                'parametro2' => $parametro2
            );
        } else {
            $respuesta = array('error' => 'Error al ejecutar la sentencia SQL: ' . $stmt->error);
        }

        // Cierra la conexión a la base de datos
        $stmt->close();
        $mysqli->close();

        echo json_encode($respuesta);
    } else {
        // Si no se reciben los parámetros esperados, devuelve un mensaje de error
        $respuesta = array('error' => 'Parámetros faltantes');
        echo json_encode($respuesta);
    }
} else {
    // Si la solicitud no es POST, devuelve un mensaje de error
    $respuesta = array('error' => 'Método no permitido');
    echo json_encode($respuesta);
}
?>

