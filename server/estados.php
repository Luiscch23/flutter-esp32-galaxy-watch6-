<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

header("Content-Type: application/json");

// Verifica si la solicitud es GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
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

    // Realiza la consulta SQL para obtener los datos de la tabla
    $sql = "SELECT * FROM arranque";

    $result = $mysqli->query($sql);

    if ($result) {
        // Convierte los resultados a un arreglo asociativo
        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Cierra el resultado
        $result->close();

        // Cierra la conexión a la base de datos
        $mysqli->close();

        echo json_encode($data);
    } else {
        $respuesta = array('error' => 'Error al ejecutar la consulta SQL: ' . $mysqli->error);
        echo json_encode($respuesta);
    }
} else {
    // Si la solicitud no es GET, devuelve un mensaje de error
    $respuesta = array('error' => 'Método no permitido');
    echo json_encode($respuesta);
}
?>
