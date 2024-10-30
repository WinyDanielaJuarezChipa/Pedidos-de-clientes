<?php
    require_once __DIR__ .'/includes/functions.php';
    $pedidos = obtenerPedidos();

if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
    $count = eliminarPedido($_GET['id']);
    $mensaje = $count > 0 ? "Pedido eliminado con éxito." : "No se pudo eliminar el pedido.";
}
$pedidos = obtenerPedidos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRWukjmG2hWz_dq5hbM5phaQ3YgjK0QzL0j9A&s" alt="Tu logo" class="logo">
        <h1>Gestión de Pedidos</h1>
        <?php if (isset($mensaje)): ?>
            <div class="<?php echo $count > 0 ? 'success' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <a href="agregar.php" class="button">Agregar Nueva Pedido</a>

        <h2>Lista de Pedidos</h2>
        <table>
            <tr>
                <th>Modelo</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Fecha de Entrega</th>
                <th>Entregado</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?php echo htmlspecialchars($pedido['modelo']); ?></td>
                <td><?php echo htmlspecialchars($pedido['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($pedido['precio']); ?></td>
                <td><?php echo formatDate($pedido['fechaEntrega']); ?></td>
                <td>
                    <a href="index.php?accion=toggleEntregado&id=<?php echo $pedido['_id']; ?>"
                       class="button <?php echo $pedido['entregado'] ? 'entregado' : 'no-entregado'; ?>">
                        <?php echo $pedido['entregado'] ? 'Entregado' : 'No Entregado'; ?>
                    </a>
                </td>
                <td class="actions">
                    <a href="editar.php?id=<?php echo $pedido['_id']; ?>" class="button">Editar</a>
                <a href="index.php?accion=eliminar&id=<?php echo $pedido['_id']; ?>" class="button" onclick="return confirm('¿Estás seguro de que quieres eliminar este Pedido?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
