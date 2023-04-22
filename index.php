<?php include("db.php") ?>

<?php include("includes/header.php") ?>


<div class="row d-flex justify-content-center">

<div class="col-md-6">

<?php if(isset($_SESSION['message'])) { ?>

    <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
        <?=$_SESSION['message']?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
</div>

<?php session_unset();} ?>


<div class="card card-body ">
    <form id="registro-form" action="save.php" method="POST">
        <h2 class="row d-flex justify-content-center">Registro</h2>
        <div class="form-group">
            <input type="text" name="matricula" class="form-control" placeholder="Matricula"  autofocus>            
        </div>
        <div class="form-group">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" autofocus>            
        </div>
        <div class="form-group">
            <input type="text" name="apellido" class="form-control" placeholder="Apellido" autofocus>            
        </div>
        <div class="form-group">
        <label for="carrera">Carrera</label>
            <select class="form-control" name="carrera" id="carrera">
                <option value="Software">Software</option>
                <option value="Multimedia">Multimedia</option>
                <option value="Ciberseguridad">Ciberseguridad</option>
                <option value="Inteligencia artificial">Inteligencia artificial</option>
                <option value="Energias renovables">Energías renovables</option>
                <option value="Mecatronica">Mecatrónica</option>
                <option value="Sonido">Sonido</option>
                <option value="Videojuegos">Videojuegos</option>
        </select>
    </div>

        <input type="submit" class="btn btn-success btn-block" name="save" value="Registrar">       
    </form>


</div>
</div>



<?php include("includes/footer.php") ?>

