<?php 
    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);
require '../../modelos/Encabezado.php';

    // consulta
    try {
        // var_dump($_GET);
        $_GET['fact_cliente'] = filter_var( $_GET['fact_cliente'] , FILTER_SANITIZE_NUMBER_INT);
        $regex = '/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/';
    
        $_GET['fact_fecha'] = filter_var($_GET['fact_fecha'], FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $regex]]);
        $objEncabezado = new Encabezado($_GET);
        $facturas = $objEncabezado->buscar();
        $resultado = [
            'mensaje' => 'Datos encontrados',
            'datos' => $facturas,
            'codigo' => 1
        ];
        // var_dump($facturas);
        
    } catch (Exception $e) {
        $resultado = [
            'mensaje' => 'OCURRIO UN ERROR EN LA EJECUCIÓN',
            'detalle' => $e->getMessage(),
            'codigo' => 0
        ];
    }       


    $alertas = ['danger', 'success', 'warning'];

    include_once '../../vistas/templates/header.php'; ?>

    <div class="row mb-4 justify-content-center">
        <div class="col-lg-6 alert alert-<?=$alertas[$resultado['codigo']] ?>" role="alert">
            <?= $resultado['mensaje'] ?>
            <?= $resultado['detalle'] ?>
        </div>
    </div>
    <div class="row mb-4 justify-content-center">
        <div class="col-lg-6">
            <a href="../../vistas/ventas/buscar.php" class="btn btn-primary w-100">Volver al formulario de busqueda</a>
        </div>
    </div>
    <h1 class="text-center">Listado de ventas</h1>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nombre del cliente</th>
                        <th>No. de factura</th>
                        <th>Fecha de la venta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($resultado['codigo'] == 1 && count($facturas) > 0) : ?>
                        <?php foreach ($facturas as $key => $factura) : ?>
                            <tr>
                                <td><?= $key + 1?></td>
                                <td><?= $factura['cli_nombre'] . " " . $factura['cli_apellido'] ?></td>
                                <td><?= $factura['fact_correlativo']?></td>
                                <td><?= $factura['fact_fecha']?></td>
                                <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/crud_2024/vistas/ventas/detalle.php?fact_id=<?= base64_encode($factura['fact_id'])?>"><i class="bi bi-eye me-2"></i>Ver factura</a></li>
                                    </ul>
                                </div>

                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4">No hay productos registrados</td>
                        </tr>  
                    <?php endif ?>
                </tbody>
                        
            </table>
        </div>        
    </div>        

    <script>

        // function alerta_eliminar(id){
        //     if(confirm("¿Esta segurdo que desea eliminar este registro?")){
        //         location.href = "/crud_2024/controladores/producto/eliminar.php?prod_id=" + id
        //     }
        // }

    </script>
<?php include_once '../../vistas/templates/footer.php'; ?>  