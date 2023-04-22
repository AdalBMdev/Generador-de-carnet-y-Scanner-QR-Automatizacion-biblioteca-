<?php

include("db.php");

if(isset($_GET['Matricula'])){
    $Matricula = $_GET['Matricula'];
    $query = "DELETE FROM estudiantes WHERE Matricula = $Matricula";
    $result = mysqli_query($conn, $query);

    if(!$result){
        die("Error");
    }

    $_SESSION['message'] = 'Estudiante elminado';
    $_SESSION['message_type'] = 'danger';

    header("Location: index.php");
}

?>