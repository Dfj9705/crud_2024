<?php 
    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);
    require '../../modelos/Cliente.php';

    $objCliente = new Cliente();
    $clientes = $objCliente->buscar();
?>

<?php include_once '../templates/header.php'; ?>

<h1 class="text-center">Buscar Ventas</h1>
<div class="row justify-content-center">
    <form action="/crud_2024/controladores/ventas/buscar.php" method="GET" class="border bg-light shadow rounded p-4 col-lg-6">
        <div class="row mb-3">
            <div class="col">
                <label for="fact_fecha">Fecha de la venta</label>
                <input type="date" name="fact_fecha" id="fact_fecha" class="form-control" >
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="fact_cliente">Cliente</label>
                <select name="fact_cliente" id="fact_cliente" class="form-control">
                    <option value="">SELECCIONE...</option>
                    <?php foreach ($clientes as $cliente) : ?>
                        <option value="<?= $cliente['cli_id'] ?>"> <?= $cliente['cli_nombre'] . " " . $cliente['cli_apellido'] . " (" . $cliente['cli_nit'] . ")"  ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>
    </form>
</div>

<?php include_once '../templates/footer.php'; ?>

