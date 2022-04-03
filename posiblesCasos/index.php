<?php
if (isset($_POST['passwd'])) {
    echo md5($_POST['passwd']);

    exit;
} else if (isset($_GET['numeroUsuario'])) {
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
} elseif (isset($_GET[''])) {
    exit;
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
            align-items: center;
            height: 100vh;
            width: 99.9%;
            flex-wrap: wrap;
            gap: 10px;
        }

        .caja {
            border: 1px solid gray;
            width: 49%;
            height: 49%;
            border-radius: 5px;

        }

        .caja.cajaget {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .caja.cajapost {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .caja.cajaXML {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .imgProducto {
            width: 40px;

        }

        .cajaProductosJSON {
            overflow: scroll;
            display: flex;
            flex-direction: column;
            align-items: center;


        }

        div#respuestaProductos {
            margin: 10px 0;
            display: flex;
            flex-direction: column;
            padding: 20px;
            gap: 10px;
        }


        .productoIndividual {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 80px;
            gap: 30px;
            padding: 10px;
            background: radial-gradient(circle at 50% 50%, rgb(255, 255, 255), rgb(213, 231, 247));
            height: 160px;

            border-radius: 15px;
        }

        .productoIndividual>span {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <div class="caja cajapost">
            <h3>Encripta la contraseña</h3>
            <label for="passwd">Contraseña</label>
            <input id="passwd" type="text" placeholder="contraseña" onkeyup="enviarPost()" name="passwd">


            <div id="resultadoPost"></div>
        </div>
        <div class="caja cajaget">
            <h3>Adivina el número entre 1 y 50</h3>
            <input type="number" min=1 name="numeroUsuario" id="numeroUsuario">
            <label for="numeroUsuario">Introduce un número</label>
            <button id='btnNumero'>Enviar número</button>
            <div id="mensajeNumero"></div><br>


        </div>
        <div class="caja cajaXML">
            <h3> Coleccion de discos desde XML</h3>

            <div id="respuestaXML"></div>
            <div>
                <input type="button" id="prev" value="<<">
                <input type="button" id="next" value=">>">
            </div>
        </div>
        <div class="caja cajaProductosJSON">
            <h3>Productos desde API JSON</h3>
            <select id="selectCategoria" name="categoria">
                <option value="none" selected disabled hidden>Selecciona una categoría</option>
            </select>
            <div id="respuestaProductos"></div>
        </div>
    </div>
    <script>
        //RECIBIR JSON
        const cajaCategoria = document.querySelector(".cajaProductosJSON")
        cajaCategoria.addEventListener("load", cargarCategorias)
        const divProductos = document.getElementById("respuestaProductos")
        const selectCategoria = document.getElementById("selectCategoria")
        selectCategoria.addEventListener("click", cargarCategorias);
        selectCategoria.addEventListener("change", cargarProductos)

        function cargarCategorias(ev) {
            const xhttp = new XMLHttpRequest()
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    let listaCategorias = JSON.parse(this.responseText)
                    listaCategorias.forEach((categ) => {
                        let option = document.createElement('option')
                        option.value = categ
                        option.innerText = categ
                        selectCategoria.appendChild(option)
                    })
                }


            }

            xhttp.open("GET", "https://fakestoreapi.com/products/categories", true);
            xhttp.send()
            ev.target.removeEventListener(ev.type, cargarCategorias)
        }

        function cargarProductos() {
            let categoriaSeleccionada = selectCategoria.value
            const xhttp = new XMLHttpRequest()
            xhttp.onreadystatechange = function() {
                if (this.readyState == 1) {
                    divProductos.innerHTML = "cargando...";
                }
                if (this.readyState == 4 && this.status == 200) {
                    let listaProductos = JSON.parse(this.responseText)

                    divProductos.innerHTML = ""

                    listaProductos.forEach((producto) => {
                        let tarjetaProducto = creaTarjetaProducto(producto.title, producto.price, producto.image)
                        divProductos.appendChild(tarjetaProducto)

                    })
                }


            }

            xhttp.open("GET", `https://fakestoreapi.com/products/category/${categoriaSeleccionada}`, true);
            xhttp.send()


        }

        function creaTarjetaProducto(nombre, precio, imagen) {
            let tarjeta = document.createElement('div')
            tarjeta.className = "productoIndividual"

            tarjeta.innerHTML = `<span>${nombre}</span><img class="imgProducto" src=${imagen} /><span>${precio} €</span>`


            return tarjeta;
        }
        //Enviar POST
        function enviarPost() {
            const passwd = document.getElementById('passwd').value
            const resultado = document.getElementById('resultadoPost')
            const xhttp = new XMLHttpRequest()
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    resultado.innerHTML = "Tu contraseña cifrada en MD5: " + this.responseText
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


        let contadorI = 0;
        let colecionXMLDiscos;
        const divRespuestaXML = document.getElementById("respuestaXML");
        divRespuestaXML.addEventListener("load", mostrarCD(contadorI))
        const btnNext = document.getElementById("next")
        const btnPrev = document.getElementById("prev")
        btnNext.addEventListener("click", nextDisco)
        btnPrev.addEventListener("click", prevDisco)

        function mostrarCD(contador) {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const xmlDoc = this.responseXML;
                    colecionXMLDiscos = xmlDoc.getElementsByTagName("CD");
                    divRespuestaXML.innerHTML =
                        `Artista: ${colecionXMLDiscos[contador].getElementsByTagName("ARTIST")[0].textContent} <br>
                 Titulo: ${colecionXMLDiscos[contador].getElementsByTagName("TITLE")[0].textContent} <br>
                 Año: ${colecionXMLDiscos[contador].getElementsByTagName("YEAR")[0].textContent}
                `
                }
            }
            xmlhttp.open("GET", "artist.xml", true);
            xmlhttp.send()
        }


        function nextDisco() {
            if (contadorI < colecionXMLDiscos.length - 1) {
                contadorI++;
                mostrarCD(contadorI)
            }
        }

        function prevDisco() {

            if (contadorI > 0) {
                contadorI--;
                mostrarCD(contadorI)
            }
        }
    </script>
</body>

</html>