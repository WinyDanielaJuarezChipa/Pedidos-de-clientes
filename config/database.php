<?php
    require_once __DIR__.'/../vendor/autoload.php';
    $mongoClient = new MongoDB\Client("mongodb+srv://miproyecto:j0pnI6D1RHwySe8X@cluster0.fzvdr.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");
    $database = $mongoClient->selectDataBase('pedido');
    $tasksCollection = $database->pedidos;
?>