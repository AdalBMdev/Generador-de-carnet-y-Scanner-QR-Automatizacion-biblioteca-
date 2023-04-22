<?php include("db.php") ?>

<?php include("includes/header.php") ?>

<div class="row d-flex justify-content-center">
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

    <div class="row g-4 ">

    <div class="col-auto ">
            <label for="num_registros" class="col-form-label">Mostrar: </label>
        </div>
        <div class="col-auto">
            <select name="num_registros" id="num_registros" class="form-select">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>

        <div class="col-auto">
            <label for="num_registros" class="col-form-label">Registros: </label>
        </div>


        <div class="col-auto">
            <label for="campo" class="col-form-label">Buscar: </label>
        </div>
        <div class="col-auto">
            <input type="text" name="campo" id="campo" class="form-control">
        </div>

    </div>
</div>

<p></p>


</div>

<div class="col-md-8 ">
    <table class="table table-bordered ">
        <thead >
            <tr>
                <th>Matricula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Carrera</th>
                <th>Ingreso en</th>
            </tr>
        </thead>
        <tbody id="content">
           
        </tbody>
    </table>
    <div class="row d-flex justify-content-center" >
        <div class="col-6"> 
            <label id="lbl-total"></label>
        </div>
    </div>

    <div class="col-6 d-flex justify-content-center" id="nav-paginacion">

    </div>

    <!-- Script para cargar la tabla -->
    <script>

    let paginaActual = 1

    getData(paginaActual)

    document.getElementById("campo").addEventListener("keyup", function(){
        getData(1)
    }, false)

    document.getElementById("num_registros").addEventListener("change", function(){
        getData(paginaActual)
    }, false)


    function getData(pagina){

        
        let input = document.getElementById("campo").value
        let num_registros = document.getElementById("num_registros").value
        let content = document.getElementById("content")

        if(pagina != null){
            paginaActual = pagina
        }

        let url = "loadassist.php";
        let formData = new FormData()
        formData.append('campo', input)
        formData.append('registros', num_registros)
        formData.append('pagina', paginaActual)



        fetch(url, {
            method: "POST",
            body: formData
        }).then(response => response.json())
        .then(data =>{
            content.innerHTML = data.data
            document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro + ' de ' + data.totalRegistros + ' registros '
            document.getElementById("nav-paginacion").innerHTML = data.paginacion
        }).catch(err => console.log(err));
        
    }

    </script>

</div>

</div>
</div>

<?php include("includes/footer.php") ?>