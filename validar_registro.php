<?php if(isset($_POST)){ 
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $regalo = $_POST['regalo'];
        $total = $_POST['total_pedido'];
        $fecha = date('Y-m-d H:i:s');
        $boletos = $_POST['boletos'];
        $camisas = $_POST['pedido_camisas'];
        $etiquetas = $_POST['pedido_etiquetas'];
        include_once('includes/funciones/funciones.php');
        $pedido = productos_json($boletos, $camisas, $etiquetas);
        $eventos = $_POST['registro'];
        $registro = eventos_json($eventos);
        try{
            require_once('includes/funciones/bd_conexion.php');
            $stmt = $conn->prepare("INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado) VALUES (?, ?, ?, ?, ?, ?, ?, ?); ");
            $stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            header('Location: validar_registro.php?exitoso=1');
        } catch(Exception $e){
            $error = $e->getMessage();
        }
    }
    ?>
<?php include_once 'includes/templates/header.php' ?>

<section class="seccion contenedor">
    <h2>Resumen Registro</h2>
    <?php if(isset($_GET['exitoso'])) {
        if($_GET['exitoso'] == 1){
            echo "Registro exitoso";
        }
    } 
    //prepare sirve para evitar ataques de inyeccion
    //los valores con signo de interrogacion se completan con la funcion bind_param
    // cada s significa que la variable en la posicion de la s es string, la i corresponde a regalo, que es entero
    // header sirve para redireccionar, tiene que ejecutarse antes de que se envie nada al navegador

    // & sirve para pasar por referencia, quiere decir que las variables podran ser cambiadas dentro de la funcion
    // sin &, los cambios que se hagan a la variable dentro de la funcion no seran visibles fuera

    // array combine coge los valores del primer array y los pone como claves para los valores del segundo array
    ?>
</section>

<?php include_once 'includes/templates/footer.php' ?>