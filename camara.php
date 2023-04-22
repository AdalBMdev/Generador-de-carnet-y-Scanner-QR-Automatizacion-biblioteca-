<?php include("db.php") ?>

<?php include("includes/header.php") ?>

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
      <h1 style="text-align: center; "> Scanner QR </h1>
      <div class="col-lg-9 d-flex justify-content-center">
        <video id="previsualizacion" class="p-1 border " style="width:500px "></video>
        <form action="asistencia.php" method="get">
            <label for="matricula">Matrícula:</label>
            <input type="text" id="matricula"  name="Matricula">
        <input type="submit" class="btn btn-success btn-block mt-3 " name="save" value="Registrar">       

        </form>

        
      </div>
    </div>
  </div>  

  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>


  <script type="text/javascript">
    var sonido = new Audio("pip.mp3");

    var scanner = new Instascan.Scanner({
      video: document.getElementById('previsualizacion'),
      scanPeriod: 5,
      mirror: false
    });

    Instascan.Camera.getCameras().then(function(cameras){
      if(cameras.length > 0){
        scanner.start(cameras[0]);
      } else {
        console.error("NO SIRVE");
        alert('Camaras no encontradas.');
      }
    }).catch(function(e){
      console.error(e);
      alert("ERROR:" + e);
    });

    scanner.addListener('scan', function(respuesta){
        sonido.play();
      document.getElementById("matricula").value = respuesta;
    });

  </script>


<?php include("includes/footer.php") ?>
