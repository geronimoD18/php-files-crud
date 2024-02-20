<?php
include 'db.php';

$action = "SUBIR ARCHIVOS";

if (isset($_POST['eliminar'])) {
    $sql = "DELETE FROM imagenes WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $_POST['id']);
    $stmt->execute();

    if ($stmt->execute()) {
        $swAlt = "Registro Eliminado!";
        $swAlm = "Los datos fueron eliminados satisfactoriamente";

        header('Location: ?swAlT=' . $swAlt . '&swAlM=' . $swAlm);
    } else {
        $swAlt = "Error!";
        $swAlm = "Error eliminando los datos: " . $stmt->error;

        header('Location: ?swAlT=' . $swAlt . '&swAlM=' . $swAlm);
    }
}

$query = "SELECT * FROM imagenes";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUBIR ARCHIVOS</title>
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

    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    ?>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <div class="roundedd">
                            <?php
                                // verificamos el tipo MIME para decidir si usar una etiqueta de imagen o de video
                                if (strpos($row['tipo'], 'image/') === 0) {
                                    // si es una imagen
                                    echo '<img src="data:' . $row['tipo'] . ';base64,' . base64_encode($row['imagen']) . '" class="card-img-top">';
                                } else if (strpos($row['tipo'], 'video/') === 0) {
                                    // si es un video
                                    echo '<video controls src="data:' . $row['tipo'] . ';base64,' . base64_encode($row['imagen']) . '" class="card-img-top"></video>';
                                }
                                ?>
                        </div>
                        <hr>
                        <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                        <div class="col-sm-12 clearfix">
                            <a href="editar.php?id=<?php echo $row['id']; ?>"
                                class="card-link btn btn-link float-start">Editar</a>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="card-link btn btn-link link-danger float-end"
                                    name="eliminar">Borrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                ?>
            <div class="col-sm-12 text-center ntf">
                <h3 class="mt-0 mb-0 fw-bold">No has subido archivos aún</h3>
            </div>
            <?php
            }
            ?>
        </div>
        <hr class="mb-0">
        <h1 class="mt-5 fw-bold">Almacenar Imágenes/Videos</h1>
        <form action="actions/subir.php" method="post" class="form-control mt-4" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFile" class="form-label fw-bold">Seleccionar imagen</label>
                <input class="form-control" type="file" name="imagen" id="formFile">
            </div>
            <div class="mb-3">
                <label for="fileTitle" class="form-label fw-bold">Renombrar</label>
                <input class="form-control" type="text" name="nombre" id="fileTitle"
                    placeholder="introducir título del archivo">
            </div>
            <button type="submit" class="btn btn-primary" name="subir">Subir <i class="fa-solid fa-upload"></i></button>
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