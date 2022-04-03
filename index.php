<?php
if (isset($_REQUEST['q'])) {
    // Primero comprobamos que existe un parámetro q
    //do your stuff
    $usuarios[] = ["nombre" => "Anna", "image" => "https://images.pexels.com/photos/10772378/pexels-photo-10772378.jpeg"];
    $usuarios[] = ["nombre" => "Amalia", "image" => "https://images.pexels.com/photos/10772378/pexels-photo-10772378.jpeg"];
    $usuarios[] = ["nombre" => "Alicia", "image" => "https://images.pexels.com/photos/10772378/pexels-photo-10772378.jpeg"];
    $usuarios[] = ["nombre" => "Alba", "image" => "https://images.pexels.com/photos/10772378/pexels-photo-10772378.jpeg"];

    $a[] = "Anna";
    $a[] = "Brittany";
    $a[] = "Cinderella";
    $a[] = "Diana";
    $a[] = "Eva";
    $a[] = "Fiona";
    $a[] = "Gunda";
    $a[] = "Hege";
    $a[] = "Inga";
    $a[] = "Johanna";
    $a[] = "Kitty";
    $a[] = "Linda";
    $a[] = "Nina";
    $a[] = "Ophelia";
    $a[] = "Petunia";
    $a[] = "Amanda";
    $a[] = "Raquel";
    $a[] = "Cindy";
    $a[] = "Doris";
    $a[] = "Eve";
    $a[] = "Evita";
    $a[] = "Sunniva";
    $a[] = "Tove";
    $a[] = "Unni";
    $a[] = "Violet";
    $a[] = "Liza";
    $a[] = "Elizabeth";
    $a[] = "Ellen";
    $a[] = "Wenche";
    $a[] = "Vicky";

    // get the q parameter from URL


    $q = $_REQUEST["q"];

    $hint = "";

    // lookup all hints from array if $q is different from ""
    if ($q !== "") {
        $q = strtolower($q);
        $len = strlen($q);

        foreach ($usuarios as $name) {

            if (stristr($q, substr($name["nombre"], 0, $len))) {
                if ($hint === "") {
                    $hint = $name["image"];
                } else {
                    $hint .= ", " . $name["image"];
                }
            }
        }
    }
    // Output "no suggestion" if no hint was found or output correct values

    echo $hint === "" ? "no suggestion" : $hint;

    sleep(1);

    exit;
}
?>
<!DOCTYPE html>
<html>

<body>
    <p><b>Start typing a name in the input field below:</b></p>
    <form action="">
        <label for="fname">First name:</label>
        <input type="text" id="fname" name="fname" onkeyup="showHint(this.value)" />
    </form>
    <p>Suggestions: <span id="txtHint"></span></p>
    <script>
        function showHint(str) {
            if (str.length == 0) {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                let xmlhttp = new XMLHttpRequest();
                console.log(xmlhttp);

                xmlhttp.onreadystatechange = function() {
                    console.log(this.readyState);
                    if (this.readyState == 1) {
                        document.getElementById("txtHint").innerHTML = "cargando...";
                    }
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };

                xmlhttp.open(
                    "GET",
                    "index.php?q=" + str,
                    true
                );
                xmlhttp.send();
            }
        }
    </script>
</body>

</html>