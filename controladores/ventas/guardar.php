<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require '../../modelos/Encabezado.php';
    require '../../modelos/Detalle.php';
    require '../../includes/funciones.php';
    
    
    $_POST['fact_correlativo'] = uniqid();

    $_POST['producto'] =array_filter($_POST['producto']);
    $_POST['cantidad'] =array_filter($_POST['cantidad']);

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
    // exit;
    // var_dump();

    
    // VALIDAR INFORMACION
    $_POST['fact_cliente'] = filter_var( $_POST['fact_cliente'] , FILTER_SANITIZE_NUMBER_INT);
    $regex = '/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/';

    $_POST['fact_fecha'] = filter_var($_POST['fact_fecha'], FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $regex]]);

    if($_POST['fact_cliente'] == '' || !$_POST['fact_fecha'] || estaVacio($_POST['producto']) || estaVacio($_POST['cantidad']) || count($_POST['producto']) !=  count($_POST['cantidad'])){
        $resultado = [
            'mensaje' => 'DEBE VALIDAR LOS DATOS',
            'detalle' => '',
            'codigo' => 2
        ];
    }else{
        try {

            //OBTENEMOS LA CONEXION A LA BD
            $conexion = Encabezado::connectar();

            //INDICAMOS QUE VAMOS A USAR UNA TRANSACCION
            $conexion->beginTransaction();

            //INSTANCIA AL OBJETO ENCABEZADO
            $encabezado = new Encabezado($_POST);

            //GUARDADO EN EL ENCABEZADO
            $guardar = $encabezado->guardar();
            
            //ID QUE SE INSERTO EN ENCABEZADO
            $fact_id = $guardar['id'];


            // RECORRIDO DE CADA UNO DE LOS PRODUCTOS
            for ( $i = 0; $i <  count($_POST['producto']); $i++) {
                //VALIDAR QUE EL PRODUCTO ESTE SELECCIONADO
                if($_POST['producto'][$i] != ''){
                    // INSTANCIA AL OBJETO DETALLE
                    $detalle = new Detalle([
                        // ID DEL ENCABEZADO
                        'det_factura' => $fact_id,
                        // EL PRODUCTO DEL ARRAY DE PRODUCTOS EN LA POSICON $i
                        'det_producto' => $_POST['producto'][$i],
                        // LA CANTIDAD DEL ARRAY DE CANTIDADES EN LA POSICON $i
                        'det_cantidad' => $_POST['cantidad'][$i]     
                    ]);
                    // GUARDA EL DETALLE
                    $guardarDetalle = $detalle->guardar();
                    // echo $guardarDetalle;
                }
            }
            
            $resultado = [
                'mensaje' => 'VENTA INSERTADA CORRECTAMENTE',
                'detalle' => '',
                'codigo' => 1
            ];
            // SI NO HUBIERA ERROR CONFIRMA LOS CAMBIOS EN LA BD

            $conexion->commit();

            
        } catch (PDOException $pe){
            $resultado = [
                'mensaje' => 'OCURRIO UN ERROR INSERTANDO A LA BD',
                'detalle' => $pe->getMessage(),
                'codigo' => 0
            ];
            // SI HUBIERA UN ERROR DESHACE LOS CAMBIOS EN LA BD
            $conexion->rollBack();
        } catch (Exception $e) {
            $resultado = [
                'mensaje' => 'OCURRIO UN ERROR EN LA EJECUCIÓN',
                'detalle' => $e->getMessage(),
                'codigo' => 0
            ];
            // SI HUBIERA UN ERROR DESHACE LOS CAMBIOS EN LA BD

            $conexion->rollBack();

        }

        
        
    }

    $alertas = ['danger', 'success', 'warning'];

    
    include_once '../../vistas/templates/header.php'; ?>

    <div class="row justify-content-center">
        <div class="col-lg-6 alert alert-<?=$alertas[$resultado['codigo']] ?>" role="alert">
            <?= $resultado['mensaje'] ?>
            <?= $resultado['detalle'] ?>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <a href="../../vistas/ventas/index.php" class="btn btn-primary w-100">Volver al formulario</a>
        </div>
    </div>


<?php include_once '../../vistas/templates/footer.php'; ?>  