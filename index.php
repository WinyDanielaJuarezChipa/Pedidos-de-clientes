<?php
    require_once __DIR__ .'/../config/database.php';

    function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }
    
    function formatDate($date) {
        return $date->toDateTime()->format('Y-m-d');
    }

    function crearPedido($modelo, $descripcion, $precio, $fechaEntrega,) {
        global $tasksCollection;
        $resultado = $tasksCollection->insertOne([
            'modelo' => sanitizeInput($modelo),
            'descripcion' => sanitizeInput($descripcion),
            'precio' => sanitizeInput($precio),
            'fechaEntrega' => new MongoDB\BSON\UTCDateTime(strtotime($fechaEntrega) * 1000),
            'entregado' => false
        ]);
        return $resultado->getInsertedId();
    }
    
    function obtenerpedidos() {
        global $tasksCollection;
        return $tasksCollection->find();
    }
    
    function obtenerPedidoPorId($id) {
        global $tasksCollection;
        return $tasksCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    }
    
    function actualizarPedido($id, $modelo, $descripcion, $precio, $fechaEntrega, $entregado) {
        global $tasksCollection;
        $resultado = $tasksCollection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => [
                'modelo' => sanitizeInput($modelo),
                'descripcion' => sanitizeInput($descripcion),
                'precio' => sanitizeInput($precio),
                'fechaEntrega' => new MongoDB\BSON\UTCDateTime(strtotime($fechaEntrega) * 1000),
                'entregado' => $entregado
            ]]
        );
        return $resultado->getModifiedCount();
    }

    function eliminarPedido($id) {
        global $tasksCollection;
        $resultado = $tasksCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        return $resultado->getDeletedCount();
    }

    function togglePedidoEntregado($id) {
        global $tasksCollection;
        $pedido = $tasksCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        if ($pedido) {
            $nuevoEstado = !$pedido['entregado'];
            $resultado = $tasksCollection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)],
                ['$set' => ['entregado' => $nuevoEstado]]
            );
            return $resultado->getModifiedCount() > 0 ? $nuevoEstado : null;
        }
        return null;
    }
    
    
?>
