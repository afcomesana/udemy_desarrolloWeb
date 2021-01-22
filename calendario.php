<?php include_once 'includes/templates/header.php'; ?>
  <section class="seccion contenedor">
    <h2>Calendario de eventos</h2>

    <?php  
        try{
            require_once('includes/funciones/bd_conexion.php');
            $sql = "SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado ";
            $sql .= " FROM eventos ";
            $sql .= " INNER JOIN categoria_evento ";
            $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
            $sql .= " INNER JOIN invitados ";
            $sql .= " ON eventos.id_inv = invitados.invitado_id ";
            $sql .= " ORDER BY evento_id ";     

            $resultado = $conn->query($sql);
        } catch(\Exception $e){
            echo $e->getMessage;
        }
    ?>

    <div class="calendario">
        <?php 
            $calendario = array();
            while( $eventos = $resultado->fetch_assoc() ) { 

                $fecha = $eventos['fecha_evento'];

                $evento = array(
                    'titulo' => $eventos['nombre_evento'],
                    'fecha' => $eventos['fecha_evento'],
                    'hora' => $eventos['hora_evento'],
                    'categoria' => $eventos['cat_evento'],
                    'icono' => $eventos['icono'],
                    'invitado' => $eventos['nombre_invitado'] . ' ' . $eventos['apellido_invitado']
                );
                $calendario[$fecha][] = $evento;
            } 
            ?>  
            
        <?php 
            // Imprime eventos
            foreach($calendario as $dia => $lista_eventos) { ?>
                <h3>
                    <i class="fas fa-calendar"></i>
                    <?php 
                        setlocale(LC_TIME, 'Spanish_Spain.UTF-8');

                        echo strftime("%A, %d de %B del %Y", strtotime($dia)); 
                    ?>
                </h3>

                <?php foreach($lista_eventos as $evento) { ?>
                    <div class="dia">
                        <p class="titulo"><?php echo $evento['titulo']; ?></p>
                        <p class="hora"> 
                            <i class="fas fa-clock" area-hidden="true"></i> 
                            <?php echo $evento['fecha'] . ' ' . $evento['hora']; ?>                            
                        </p>
                        <p> <i class="<?php echo $evento['icono'] ?>"></i> <?php echo $evento['categoria']; ?></p>
                        <p> <i class="fas fa-user"></i> <?php echo $evento['invitado']; ?></p>
                    </div>
                <?php } //fin foreach evento?> 

        <?php } //fin foreach dias ?>  

    </div>

    
  </section>
  <?php 
        $conn->close();
    ?>
<?php include_once 'includes/templates/footer.php' ?>