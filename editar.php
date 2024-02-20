<?php
include 'db.php';

$action = "EDITAR ARCHIVO";

$id = $_GET['id'];

$query = "SELECT * FROM imagenes WHERE id = '$id'";
$resultado = $conexion->query($query);
$row = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDITAR ARCHIVO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- dynamic header -->
    <?php include "partials/header.php" ?>

    <div class="container mt-4 mb-4">
        <div class="col-sm-12 mb-4">
            <a href="index.php" class="btn btn-link">Volver a casa</a>
        </div>
        <form action="actions/actualizar.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="rounded">
                <?php
                // verificamos el tipo MIME para decidir si usar una etiqueta de imagen o de video
                if (strpos($row['tipo'], 'image/') === 0) {
                    // si es una imagen
                    echo '<img src="data:' . $row['tipo'] . ';base64,' . base64_encode($row['imagen']) . '">';
                } else if (strpos($row['tipo'], 'video/') === 0) {
                    // si es un video
                    echo '<video controls src="data:' . $row['tipo'] . ';base64,' . base64_encode($row['imagen']) . '"></video>';
                }
                ?>
            </div>
            <div class="mt-4 mb-3">
                <h4 class="mt-0 mb-0">Fecha de subida</h4>
                <i><span class="text-muted"><?php echo $row['created_at']; ?></span></i>
            </div>
            <div class="mb-3">
                <h4 class="mt-0 mb-0">Fecha de actualización</h4>
                <i><span class="text-muted"><?php echo $row['updated_at']; ?></span></i>
            </div>
            <hr>
            <div class="col-sm-12 text-center">
                <h3 class="fw-bold">ACTUALIZAR</h3>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label fw-bold">Seleccionar archivo</label>
                <input class="form-control" type="file" name="imagen" id="formFile">
            </div>
            <div class="mb-3">
                <label for="fileTitle" class="form-label fw-bold">Renombrar</label>
                <input class="form-control" type="text" name="nombre" id="fileTitle"
                    placeholder="introducir título del archivo" value="<?php echo $row['nombre']; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="actualizar">Actualizar <i
                    class="fa-solid fa-pen-to-square"></i></button>
        </form>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
if (isset($_GET['swAlT']) && isset($_GET['swAlM'])) {
    $swAlt = $_GET['swAlT'];
    $swAlm = $_GET['swAlM'];
    ?>
<script>
let timerInterval;
Swal.fire({
    title: '<?php echo $swAlt ?>',
    html: '<?php echo $swAlm ?>',
    timer: 5000,
    timerProgressBar: true,
    didOpen: () => {
        Swal.showLoading();
    },
    willClose: () => {
        clearInterval(timerInterval);
    }
}).then((result) => {
    if (result.dismiss === Swal.DismissReason.timer) {
        window.location.href = 'index.php';
    }
});
</script>
<?php
}
?>

</html>