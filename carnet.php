<?php

include("db.php");
include("phpqrcode/qrlib.php");


if(isset($_GET['Matricula'])){

    $matricula = $_GET['Matricula'];
    $query = "SELECT * FROM estudiantes WHERE Matricula = $matricula";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_array($result);
        $matricula = $row['Matricula'];
        $nombre = $row['Nombre'];
        $apellido = $row['Apellido'];
        $carrera = $row['Carrera'];
        $QR = $row['QR'];
    
        $imagen_bytes = base64_decode($QR);
    
        $tempDir = 'temp/';
        $fileName = 'qr_' . $matricula . '.png';
        $pngAbsoluteFilePath = $tempDir . $fileName;
        file_put_contents($pngAbsoluteFilePath, $imagen_bytes);
    
        $info = "Matrícula: " . $matricula . "\n" .
                "Nombre: " . $nombre . "\n" .
                "Apellido: " . $apellido . "\n" .
                "Carrera: " . $carrera . "\n";
    
        $urlRelativa = $tempDir . $fileName;
    }
    
}

?>

<?php include ("includes/header.php")?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body">
                <p>Información del estudiante</p>
                <pre><?php echo $info; ?></pre>
                <img src="<?php echo $urlRelativa; ?>" alt="Código QR">
            </div>
        </div>
    </div>
</div>

<?php include ("includes/footer.php")?>
