<?php

$server = "localhost";
$user = "root";
$pass = "";
$database = "Vehiculos";

$conexion = new mysqli($server,$user,$pass,$database);

if ($conexion->connect_errno) {
    die("Conexion perdida Fallida" . $conexion->connect_errno);
} else {
    echo "conectado";
}

// Agregar vehículo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $vehiculo = $_POST['vehiculo'];
    $modelo = $_POST['modelo'];
    $año = $_POST['año'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO vehiculos (vehiculo, modelo, año, precio) VALUES ('$vehiculo', '$modelo', '$año', '$precio')";
    $conexion->query($sql);
}

// Eliminar vehículo
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM vehiculos WHERE id=$id";
    $conexion->query($sql);
}

// Obtener vehículos
$sql = "SELECT * FROM vehiculos";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Vehículos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Registro de Vehículos</h1>

    <form method="POST">
        <input type="text" name="vehiculo" placeholder="Vehículo" required>
        <input type="text" name="modelo" placeholder="Modelo" required>
        <input type="number" name="año" placeholder="Año" required>
        <input type="number" name="precio" placeholder="Precio" required step="0.01">
        <button type="submit" name="add">Agregar Vehículo</button>
    </form>

    <table bordel="1">
        <tr>
            <th>ID</th>
            <th>Vehículo</th>
            <th>Modelo</th>
            <th>Año</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['vehiculo']; ?></td>
                <td><?php echo $row['modelo']; ?></td>
                <td><?php echo $row['año']; ?></td>
                <td><?php echo $row['precio']; ?></td>
                <td><a href="?delete=<?php echo $row['id']; ?>">Eliminar</a></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php $conexion->close(); ?>
</body>
</html>