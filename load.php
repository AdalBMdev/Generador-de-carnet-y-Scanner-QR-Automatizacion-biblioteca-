<?php

require 'db.php';

$colums = ['Matricula', 	'Nombre', 	'Apellido', 	'Carrera', 	'FechaCreado'];
$table = "estudiantes";

$id = 'Matricula';

$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null; // valida si hay algo dentro del campo

$where = '';

if($campo != null){
    $where = "WHERE (";

    $cont = count($colums);
    for ($i = 0; $i < $cont; $i++){
        $where .= $colums[$i] . " LIKE '%". $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

$limit = isset($_POST['registros']) ? $conn->real_escape_string($_POST['registros']) : 10; 
$pagina = isset($_POST['pagina']) ? $conn->real_escape_string($_POST['pagina']) : 10; 

if(!$pagina){
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}

$sLimit = "LIMIT $inicio, $limit";

$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $colums) . " 
FROM $table
$where 
$sLimit ";

$resultado = $conn->query($sql);
$num_rows = $resultado->num_rows;

//Saber los registros totales
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$row_filtro = $resFiltro->fetch_array();
$totalFiltro= $row_filtro[0];

//Saber los registros totales
$sqlTotal = " SELECT count($id) FROM $table ";
$resTotal = $conn->query($sqlTotal);
$row_total = $resTotal->fetch_array();
$totalRegistros = $row_total[0];


$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';

if ($num_rows > 0) {
    while($row = $resultado->fetch_assoc()) {
        $output['data'] .= '<tr>';
        $output['data'] .= '<td>'.$row['Matricula'].'</td>';
        $output['data'] .= '<td>'.$row['Nombre'].'</td>';
        $output['data'] .= '<td>'.$row['Apellido'].'</td>';
        $output['data'] .= '<td>'.$row['Carrera'].'</td>';
        $output['data'] .= '<td>'.$row['FechaCreado'].'</td>';
        $output['data'] .= '<td>
        <a class="btn btn-secondary" href="edit.php?Matricula='.$row['Matricula']. '"><i class="fas fa-marker"></i></a>
        <a class="btn btn-danger" href="delete.php?Matricula='.$row['Matricula']. '"><i class="fas fa-trash"></i></a>
        <a class="btn btn-info" href="carnet.php?Matricula='.$row['Matricula']. '"><i class="fas fa-id-badge"></i></a>
        </td>';
        $output['data'] .= '</tr>';
        } 
    }

    else {
        $output['data'] .= '<tr>';
        $output['data'] .= '<td colspan = "7">Sin resultados</td>';
        $output['data'] .= '</tr>';
    }

    if($output['totalRegistros'] > 0) {
        $totalPaginas = ceil($output['totalRegistros'] / $limit); 

        $output['paginacion'] .= '<nav>';
        $output['paginacion'] .= '<ul class="pagination">';

        $numeroInicio = 1;

        if(($pagina - 4) > 1){
            $numeroInicio = $pagina - 4;
        }

        $numeroFin = $numeroInicio + 9;

        if($numeroFin > $totalPaginas){
            $numeroFin = $totalPaginas;
        }

        for($i = $numeroInicio; $i <= $totalPaginas; $i++) {
            if($pagina == $i){

                $output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';

            }else {

                $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="getData(' . $i . ')">'.$i.'</a></li>';

            }
        }

        $output['paginacion'] .= '</ul>';
        $output['paginacion'] .= '</nav">';

    }

    echo json_encode($output, JSON_UNESCAPED_UNICODE); //Convertir JSON para trabajar con AJAX

    /* <tr>
    <td><?php echo $row['Matricula']?></td>
    <td><?php echo $row['Nombre']?></td>
    <td><?php echo $row['Apellido']?></td>
    <td><?php echo $row['Carrera']?></td>
    <td><?php echo $row['FechaCreado']?></td>

    <td>
        <a href="edit.php?Matricula=<?php echo $row['Matricula']?>" class="btn btn-secondary">
        <i class="fas fa-marker"></i>
        </a>
        <a href="delete.php?Matricula=<?php echo $row['Matricula']?>" class="btn btn-danger">
        <i class="far fa-trash-alt"></i>
        </a>
    </td>
</tr>*/