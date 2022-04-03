<?php
if (isset($_REQUEST["r"]) || isset($_REQUEST["g"]) || isset($_REQUEST["b"])) {
    implode(", ", $_REQUEST);

    //$rValue = isset($_REQUEST["r"]) ? $_REQUEST["r"]: 0;
    $rValue = $_REQUEST["r"];
    $gValue = $_REQUEST["g"];
    $bValue = $_REQUEST["b"];

    $rgb = "$rValue, $gValue, $bValue";
    $rgbarr = explode(",", $rgb, 3);
    $hex = sprintf("#%02x%02x%02x", $rgbarr[0], $rgbarr[1], $rgbarr[2]);
    $arrJSON = ["rgb" => "$rValue,$gValue,$bValue", "hex" => $hex];

    echo json_encode($arrJSON);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Color picker</title>
    <style>
        body {
            font-family: monospace;
        }

        .selectores {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        input {
            display: block;
            margin: 10px auto;
        }

        .box {
            border-radius: 10px;
            width: 200px;
            height: 80px;
        }

        .resultado {
            margin: 15px auto;
            width: calc((200px * 3) + 40px);
            height: 100px;
            border: 1px solid gray;
            border-radius: 10px;
        }

        .hexadecimal {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid;
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <div class="selectores">
            <div>
                <input type="range" id="rvalue" value="255" name="rvalue" min="0" max="255">

                <div class="box boxRvalue"></div>
            </div>
            <div>
                <input type="range" id="gvalue" value="255" name="gvalue" min="0" max="255">
                <div class="box boxGvalue"></div>
            </div>
            <div>
                <input type="range" id="bvalue" value="255" name="bvalue" min="0" max="255">
                <div class="box boxBvalue"></div>
            </div>
        </div>
        <div class="resultado">

        </div>
        <div class=" box hexadecimal">
        </div>
    </div>
    <script>
        const rValue = document.getElementById('rvalue')
        const gValue = document.getElementById('gvalue')
        const bValue = document.getElementById('bvalue')
        const boxRvalue = document.querySelector('.boxRvalue')
        boxRvalue.style.backgroundColor = `rgb(${rValue.value},0,0)`

        const boxGvalue = document.querySelector('.boxGvalue')
        boxGvalue.style.backgroundColor = `rgb(0,${gValue.value},0)`

        const boxBvalue = document.querySelector('.boxBvalue')
        boxBvalue.style.backgroundColor = `rgb(0,0,${bValue.value})`
        document.querySelector('.hexadecimal').textContent = ConvertRGBtoHex(parseInt(rValue.value), parseInt(gValue.value), parseInt(bValue.value));


        const boxResultado = document.querySelector('.resultado')
        rValue.addEventListener('change', (e) => {
            const color = e.target.value;
            console.log("r", color, "g", gValue.value, "b", bValue.value)

            boxRvalue.style.backgroundColor = `rgb(${color},0,0)`
            sendColor()
        })
        gValue.addEventListener('change', (e) => {
            const color = e.target.value;
            console.log("r", rValue.value, "g", color, "b", bValue.value)

            boxGvalue.style.backgroundColor = `rgb(0,${color},0)`
            sendColor()
        })
        bValue.addEventListener('change', (e) => {
            const color = e.target.value;
            console.log("b", color)

            boxBvalue.style.backgroundColor = `rgb(0,0,${color})`
            sendColor()
        })

        function ColorToHex(color) {
            let hexadecimal = color.toString(16);
            return hexadecimal.length == 1 ? "0" + hexadecimal : hexadecimal;
        }

        function ConvertRGBtoHex(red, green, blue) {
            return "#" + ColorToHex(red) + ColorToHex(green) + ColorToHex(blue);
        }

        async function sendColor() {
            const r = rValue.value
            const g = gValue.value
            const b = bValue.value
            const url = `index.php?r=${r}&g=${g}&b=${b}`

            let JSONRecibido = await fetch(url).then(response => response.json());
            let dataTxt = await fetch(url)
            console.log(dataTxt)

            console.log(JSONRecibido)



            document.querySelector('.resultado').style.backgroundColor = `rgb(${JSONRecibido.rgb})`;
            document.querySelector('.hexadecimal').textContent = JSONRecibido.hex;


        }

        //const url = `index.php?r=${rValue.value}&g=${gValue.value}&b=${bValue.value}`,
    </script>
</body>

</html>