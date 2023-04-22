<?php

include("db.php");

if(isset($_POST['save'])){

    $matricula = $_POST['matricula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $carrera = $_POST['carrera'];

    $query = "INSERT INTO estudiantes(Matricula,Nombre,Apellido,carrera) VALUES ('$matricula', '$nombre', '$apellido', '$carrera')";
    $result = mysqli_query($conn, $query);

    if(!$result){
        die("Failed to insert");
    }

    $_SESSION['message'] = 'Guardado correctamente';
    $_SESSION['message_type'] = 'success';


   header("Location: index.php");
}

// GENERAR CODIGO QR

require "phpqrcode/qrlib.php";
require "db.php"; // Archivo que contiene la conexión a la base de datos

$tamaño = 10;
$level = "Q";
$framSize = 3;

// Seleccionar los registros que tengan el campo 'qr' vacío
$query = "SELECT * FROM estudiantes WHERE qr = ''";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($result)) {
    // Generar el código QR a partir de la matrícula
    $matricula = $row['Matricula'];
    
    $ruta_qr = "temp/" . $matricula . ".png";
    QRcode::png($matricula, $ruta_qr, $level, $tamaño, $framSize);

    // Convertir la imagen a bytes y luego a base64
    $imagen_bytes = file_get_contents($ruta_qr);
    $imagen_base64 = base64_encode($imagen_bytes);

    // Actualizar el registro con el valor del QR generado
    $query = "UPDATE estudiantes SET qr = '$imagen_base64' WHERE Matricula = $matricula";
    mysqli_query($conn, $query);

    // Eliminar el archivo temporal del QR
    unlink($ruta_qr);
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
?>