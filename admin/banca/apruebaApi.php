<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de aprobación</title>
</head>

<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function yaAprobado(){
        Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'El pago ya ha sido aprobado',
        }).then((result) => {
            if (result.isConfirmed) {
                window.close();
            }
        })
    
    }
</script>


<script>

function aprobarPago(indentificador, id) { 
    //console.log(indentificador);
    //console.log(id);
    Swal.fire({
        title: '¿Aprobar pago?',
        text: indentificador,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aprobar'
    }).then((result) => {
        if (result.isConfirmed) {


            var datosEnvio = new FormData();
            datosEnvio.append("accion", "aprobar");
            datosEnvio.append("id", id);

            fetch("api/apiPagos.php", {
                    method: 'POST',
                    body: datosEnvio
                }).then((respuesta) => respuesta.json())
                .then((data) => {
                    console.log(data);
                    Swal.fire(
                        '¡Aprobado!',
                        'El pago ha sido aprobado.',
                        'success'
                    )
                    if (data.status == "success") {
                        //cerrar ventana 
                        window.close();
                    }

                });


        } else {
            Swal.fire(
                '¡Cancelado!',
                'El pago no ha sido aprobado.',
                'error'
            ).then((result) => {
                if (result.isConfirmed) {
                    window.close();
                }
            })
        }
    })

}
</script>

    <?php
    include_once("api/adminPagos.php");
    include_once("api/encriptador.php");
    $idpago = $_GET['pago'];
    $idPago = str_replace(" ", "+", $idpago);
    $idPago = desencriptar($idPago);
    $adminPagos = new AdministradorPagos();
    $pago = $adminPagos->damePago($idPago);
    //echo var_dump($pago);
    if($pago->estatus == "Pendiente"){
        echo "<script>aprobarPago('".$pago->identificador. '  $' .number_format($pago->monto,2) .  "', ".$idPago.");</script>";

    }
    else{
        echo "<script>yaAprobado();</script>";
    }
    //echo var_dump($pago);

    ?>



 


</body>

</html>