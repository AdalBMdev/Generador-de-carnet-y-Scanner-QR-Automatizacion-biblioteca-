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
    }
}



if (isset($_POST['update'])) {

    $matricula = $_GET['Matricula'];
    $matricula1 = $_POST['matricula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $carrera = $_POST['carrera'];

  
    $query = "UPDATE estudiantes set Matricula = '$matricula1', Nombre = '$nombre', Apellido = '$apellido', Carrera = '$carrera' WHERE Matricula=$matricula";
    mysqli_query($conn, $query);
    $_SESSION['message'] = 'Task Updated Successfully';
    $_SESSION['message_type'] = 'warning';
    header('Location: index.php');
  }
?>

<?php include ("includes/header.php")?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx auto">
            <div class="card card-body">
                <form action="edit.php?Matricula=<?php echo $_GET['Matricula']; ?>" method="POST">
                    <div class="form-group">
                        <input type="text" name="matricula" value="<?php echo $matricula; ?>" class="form-control" placeholder="Actualizar matricula">
                    </div>
                    <div class="form-group">
                        <input type="text" name="nombre" value="<?php echo $nombre; ?>" class="form-control" placeholder="Actualizar nombre">
                    </div>
                    <div class="form-group">
                        <input type="text" name="apellido" value="<?php echo $apellido; ?>" class="form-control" placeholder="Actualizar apellidos">
                    </div>
                    <div class="form-group">
                        <input type="text" name="carrera" value="<?php echo $carrera; ?>" class="form-control" placeholder="Actualizar carrera">
                    </div>
                    <button class=" btn btn-success" name="update">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include ("includes/footer.php")?>

