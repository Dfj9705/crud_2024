<?php
    require_once '../../modelos/Encabezado.php';
    require_once '../../modelos/Detalle.php';

    $id = filter_var(base64_decode($_GET['fact_id']), FILTER_SANITIZE_NUMBER_INT);
    

    $objetoEncabezado = new Encabezado();
    $encabezado = $objetoEncabezado->buscarPorId($id);

    $objetoDetalle = new Detalle();
    $detalle = $objetoDetalle->buscarPorEncabezado($id);
    // var_dump($detalle);

?>
<?php include_once '../templates/header.php'; ?>
<h1>FACTURA NO. <?= $encabezado['fact_correlativo'] ?></h1>
<table class="table table-bordered">
    <tr>
        <th>NO. DE FACTURA:</th>
        <td><?= $encabezado['fact_correlativo'] ?></td>
        <th>FECHA:</th>
        <td><?= date( 'd/m/Y', strtotime($encabezado['fact_fecha'])) ?></td>
    </tr>
    <tr>
        <th>NOMBRE:</th>
        <td colspan="3"><?= $encabezado['cli_nombre'] . " " . $encabezado['cli_apellido'] ?></td>
    </tr>
    <tr>
        <th>TELEFONO:</th>
        <td><?= $encabezado['cli_telefono'] ?></td>
        <th>NIT:</th>
        <td><?= $encabezado['cli_nit'] ?></td>
    </tr>
</table>

<h3>Detalle de productos</h3>
<hr>

<table class="table table-bordered">
    <thead>
        <th>NO.</th>
        <th>DESCRIPCION</th>
        <th>PRECIO UNITARIO</th>
        <th>CANTIDAD</th>
        <th>SUBTOTAL</th>
    </thead>
    <tbody>
        <?php  $total = 0; ?>
        <?php foreach ($detalle as $key => $producto) : ?>
            <tr>
                <td><?= $key + 1  ?></td>
                <td><?= $producto['descripcion']  ?></td>
                <td>Q. <?= number_format($producto['precio_unitario'],2) ?></td>
                <td><?= $producto['cantidad']  ?></td>
                <td style="text-align: right;">Q. <?= number_format($producto['subtotal'],2) ?></td>
            </tr>
            <?php  $total += $producto['subtotal']; ?>
        <?php endforeach ?>
        <tr>
            <th style="text-align: right;" colspan="4">TOTAL</th>
            <th style="text-align: right;">Q. <?= number_format($total,2) ?></th>
        </tr>
    </tbody>
</table>
<div class="row mb-4 justify-content-center">
    <div class="col-lg-6">
        <a href="../../controladores/ventas/buscar.php" class="btn btn-primary w-100">Volver a ventas</a>
    </div>
</div>

<?php include_once '../templates/footer.php'; ?>