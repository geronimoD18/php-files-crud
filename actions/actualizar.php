<?php
include '../db.php';

$action = "ACTUALIZANDO ARCHIVO";

$id = $_POST['id'];

if (isset($_POST['nombre'])) {
   $nombre = $_POST['nombre'];
} else {
   $nombre = $_FILES['imagen']['name'];
}

if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
   $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
   $tipo = mime_content_type($_FILES['imagen']['tmp_name']); // Obtén el tipo MIME
   $query = "UPDATE imagenes SET imagen = '$imagen', nombre = '$nombre', tipo = '$tipo' WHERE id = '$id'"; // Actualiza el tipo
} else {
   $query = "UPDATE imagenes SET nombre = '$nombre' WHERE id = '$id'";
}

$resultado = $conexion->query($query);

if ($resultado) {
   $swAlt = "Datos Guardados!";
   $swAlm = "Los datos fueron almacenados satisfactoriamente";

   header('Location: ../editar.php?id='. $id .'&swAlT=' . $swAlt . '&swAlM=' . $swAlm);
} else {
   $echo = `<div class="alert alert-danger" role="alert">
      Error actualizando los datos
    </div>`;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACTUALIZANDO ARCHIVO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- dynamic header -->
    <?php include "../partials/header.php" ?>

    <div class="container mt-4">
        <?php
        if (isset($echo)) {
           echo $echo;
        } else {
           ?>
        <div class="alert alert-success" role="alert">
            Datos actualizados correctamente
        </div>
        <?php
        }
        ?>
        <a href="../index.php" class="btn btn-link">Volver a casa</a>
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
        window.location.href = '../index.php';
    }
});
</script>
<?php
}
?>

</html>