<?php

include("db.php");

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

        $info = "Matrícula: " . $matricula . "\n" .
                "Nombre: " . $nombre . "\n" .
                "Apellido: " . $apellido . "\n" .
                "Carrera: " . $carrera . "\n";
                
                    $query = "INSERT INTO asistencia(Nombre,Apellido,Carrera,Matricula) VALUES ('$nombre', '$apellido', '$carrera','$matricula')";
                    $result = mysqli_query($conn, $query);
                
                    if(!$result){
                        die("Failed to insert");
                    }
                
                    $_SESSION['message'] = 'Guardado correctamente';
                    $_SESSION['message_type'] = 'success';
                
                
                
                
    } else {
        // El estudiante no fue encontrado
        $info = "No se encontró ningún estudiante con la matrícula " . $matricula . ".";
    }
} else {
    // La matrícula no ha sido ingresada aún
    $info = "Por favor ingrese una matrícula.";
}


?>

<?php include ("includes/header.php")?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body">
                <p>Información del estudiante</p>
                <pre><?php echo $info; ?></pre>

            </div>
        </div>
    </div>
</div>

<?php include ("includes/footer.php")?>

