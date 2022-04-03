<?php
if (isset($_POST['passwd'])) {
    echo md5($_POST['passwd']);

    exit;
}
if (isset($_GET['numeroUsuario'])) {
    $numeroGanador = 7;
    $numeroRecibido = intval($_GET['numeroUsuario']);
    $mensaje;
    if ($numeroRecibido < $numeroGanador) {
        $mensaje = "El numero es mayor a $numeroRecibido";
    } elseif ($numeroRecibido > $numeroGanador) {
        $mensaje = "El numero es menor a $numeroRecibido";
    } else {
        $mensaje =  'Enhorabuena has acertado';
    }
    echo $mensaje;

    exit;
}
if (isset($_GET[''])) {
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Casos posibles con AJAX</title>
    <style>
        body {
            margin: 0;
            box-sizing: border-box;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .contenedor {
            display: flex;
            justify-content: center;
            height: 100vh;
            width: 100%;
            flex-wrap: wrap;
        }

        .caja {
            border: 1px solid gray;
            width: 49%;
            height: 49%;

        }
    </style>
</head>

<body>
    <div class="contenedor">
        <div class="caja cajapost">
            <form method="post" class="post">

                <label for="passwd">Contraseña</label>
                <input id="passwd" type="text" placeholder="SAS" onkeyup="enviarPost()" name="passwd">
                <input type="submit" value="Encriptar Contraseña">

            </form>
            <div id="resultadoPost"></div>
        </div>
        <div class="caja cajaget">
            <h3>Adivina el número entre 1 y 50</h3>
            <input type="number" name="numeroUsuario" id="numeroUsuario">
            <label for="numeroUsuario">Introduce un número</label>
            <button id='btnNumero'>Enviar número</button>
            <div id="mensajeNumero"></div>
        </div>
        <div class="caja"></div>
        <div class="caja"></div>
    </div>
    <script>
        function enviarPost() {
            const passwd = document.getElementById('passwd').value
            const resultado = document.getElementById('resultadoPost')
            const xhttp = new XMLHttpRequest()
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    resultado.innerHTML = "Tu contraseña cifrada en MD5: " + this.responseText
                    console.log(this)
                }


            }
            xhttp.open("POST", "index.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(`passwd=${passwd}`);

        }


        const btn = document.getElementById("btnNumero");
        btn.addEventListener('click', enviarNumeroGet);

        function enviarNumeroGet() {
            const numeroEnviado = document.getElementById("numeroUsuario").value
            const divResultado = document.getElementById('mensajeNumero');
            const xhttp = new XMLHttpRequest()
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    divResultado.innerText = this.responseText;
                    console.log(this)
                }


            }
            xhttp.open("GET", "index.php?" + "numeroUsuario=" + numeroEnviado, true);
            xhttp.send()

        }
    </script>
</body>

</html>