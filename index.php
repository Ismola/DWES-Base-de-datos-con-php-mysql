<!DOCTYPE html>
<html lang="es">
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
	<!-- iconos font awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">
	<!-- animaciones  -->
	<link rel="stylesheet" href="css/animate.css">
	<script src="js/wow.min.js"></script>
	<script>new WOW().init();</script>
</head>
<body>
<!--
----------AYUDAS

COMO USAR ANIMACIONES

	https://wowjs.uk/docs.html


TODAS LAS ANIMACIONES

	https://daneden.github.io/animate.css/


ICONOS

	https://fontawesome.com/icons?d=gallery&m=free

TIPOGRAFIAS

	https://fonts.google.com/

	https://fonts.adobe.com/fonts


COLORES

	https://colorhunt.co/

	https://flatuicolors.com/

	https://color.adobe.com/es/create


Imagenes de Stock


	https://www.pexels.com/

	https://pixabay.com/es/

	https://stocksnap.io/

 -->

<?php
session_start();

$server = "192.168.62.131";
$user = "Ismael";
$pwd = "Ismola2002";
$db = "escuela";
$_SESSION["seccion"] = 0;
$conexion = mysqli_connect($server, $user, $pwd, $db);
//Ventanas:
//0 > la de iniciar sesión
//1 > Registrarse
//2 > Bienvenido
//3 > Agregar
//4 > Modificar
//5 > Eliminar
//6 > Visualizar

$_SESSION["seccion"] = 0;
$respuesta = 0;

if (isset($_POST["salir"])) {
    $_SESSION["seccion"] = 0;

}
if (isset($_POST["logearse"])) {
    if (registro($conexion)==1){
        $respuesta = 1;
    }
}
if (isset($_POST["registrarse"])) {
    $_SESSION["seccion"] = 1;
}
if (isset($_POST["login"])) {
    if (login($conexion) == 1){
        $respuesta = 1;
    }elseif (login($conexion) == 2){
        $respuesta = 2;
    }elseif (login($conexion) == 0){
        $_SESSION["usuario"] =  $_POST["usuario"];
    }
}
if (isset($_POST["agregar"])) {
    $_SESSION["seccion"] = 3;
}
if (isset($_POST["modificar"])) {
    $_SESSION["seccion"] = 4;
}
if (isset($_POST["eliminar"])) {
    $_SESSION["seccion"] = 5;
}
if (isset($_POST["visualizar"])) {
    $_SESSION["seccion"] = 6;
}

if (isset($_POST["añadirDatosAlumno"])) {
    añadirAlumno($conexion);
    $_SESSION["seccion"] = 3;
}
if (isset($_POST["buscarModificados"])) {
    mostrarTablaEditable($conexion, crearBusqueda());
    $_SESSION["seccion"] = 4;
}
if (isset($_POST["actualizarAlumnos"])) {
    guardarCambios($conexion);
    $_SESSION["seccion"] = 4;
}
if (isset($_POST["buscarEliminados"])) {
    mostrarTablaEliminar($conexion, crearBusqueda());
    $_SESSION["seccion"] = 5;
}
if (isset($_POST["eliminarAlumnos"])) {
    eliminarAlumno($conexion);
    $_SESSION["seccion"] = 5;
}

if (isset($_POST["buscarVisto"])) {
    mostrarTablaVisto($conexion, crearBusqueda());
    $_SESSION["seccion"] = 6;
}

switch ($_SESSION["seccion"]) {
    case 0:
        echo "<div class='container w-75 bg-primary mt-5 rounded shadow'>";
            echo "<div class='row align-items-strech'>";
                echo "<div class='col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded-start'>";

                echo "</div>";
                echo "<div class='col bg-white p5 rounded-end p-5'>";
                    echo "<div class='text-end'>";
                        echo "<img src='Imagenes/logo.png' width='180' alt=''>";
                    echo "</div>";
                    echo "<h2 class='fw-bold text-center pt-5 mb-5'>Iniciar Sesión</h2>";
                    if ($respuesta == 1){
                        echo "<div class='alert alert-danger role='alert'>Has puesto la contraseña mal</div>";
                    }
                    if ($respuesta == 2){
                        echo "<div class='alert alert-danger role='alert'>Has puesto el usuario mal</div>";
                    }
                    echo "<form method='post' action=''>";
                        echo "<div class='mb-4'>";
                            echo "<label for='usuario' class='form-label'>Usuario</label>";
                            echo "<input type='text' class='form-control' name='usuario' placeholder='Introduce el usuario' required>";
                        echo "</div>";
                        echo "<div class='mb-4'>";
                              echo "<label for='contra' class='form-label'>Contraseña</label>";
                              echo "<input type='password' class='form-control' name='contraseña' placeholder='Introduce la contraseña' required>";
                        echo "</div>";
                        echo "<div class='mb-4 form-check'>";
                            echo "<input type='checkbox' class='form-check-input' required>";
                            echo "<label for='c' class='form-check-label'>Me vas a poner un 10</label>";
                            echo "</div>";
                        echo "<div class='d-grid'>";
                            echo "<input type='submit' class='btn btn-primary' value='Iniciar sesión' name='login'>";
                        echo "</div>";
                    echo "</form>";
                    echo "<form method='post' action=''>";
                        echo "<div class='d-grid mt-3 '>";
                                echo "<input type='submit' class='btn btn-secondary' value='Registrarse' name='registrarse'>";
                        echo "</div>";
                    echo "</form>";
                    echo "</form>";
                echo "</div>";
            echo "</div>";
        echo "</div>";


        break;
    case 1:
        echo "<div class='container w-75 bg-primary mt-5 rounded shadow'>";
            echo "<div class='row align-items-strech'>";
                echo "<div class='col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded'>";
                echo "</div>";
                echo "<div class='col bg-white p5 rounded-end p-5'>";
                    echo "<div class='text-end'>";
                        echo "<img src='Imagenes/logo.png' width='180' alt=''>";
                    echo "</div>";
                    echo "<h2 class='fw-bold text-center pt-5 mb-5'>Crar cuenta</h2>";
                    if ($respuesta == 1){
                        echo "<div class='alert alert-danger role='alert'>El usuario ya existe</div>";
                    }
                    echo "<form method='post' action=''>";
                        echo "<div class='mb-4'>";
                            echo "<label for='usuario' class='form-label'>Usuario</label>";
                            echo "<input type='text' class='form-control' name='usuario' placeholder='Introduce el usuario' required>";
                        echo "</div>";
                        echo "<div class='mb-4'>";
                            echo "<label for='contra' class='form-label'>Contraseña</label>";
                            echo "<input type='password' class='form-control' name='contraseña' placeholder='Introduce la contraseña' required>";
                        echo "</div>";
                        echo "<div class='d-grid'>";
                            echo "<input type='submit' class='btn btn-primary' value='Crear cuenta' name='logearse'>";
                        echo "</div>";
                    echo "</form>";
                    echo "<form method='post' action=''>";
                        echo "<div class='d-grid mt-3 '>";
                            echo "<input type='submit' class='btn btn-secondary' value='Iniciar Sesión' name='salir'>";
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
        break;
    case 2:
        echo "<div class='container w-100'>";
            echo "<div class='row'>";
                echo "<nav class='navbar navbar-light bg-light d-flex justify-content-around rounded mt-3 shadow'>";
                            echo "<div class='col d-flex justify-content-center'>";
                                echo  $_SESSION["usuario"];
                            echo "</div>";
                            echo "<div class='col d-flex justify-content-center'>";
                                echo "<form method='post' action=''>";
                                    echo "<input class='btn btn-outline-primary' type='submit' value='Agregar alumno' name='agregar'>";
                                echo "</form>";
                            echo "</div>";
                            echo "<div class='col d-flex justify-content-center'>";
                                echo "<form method='post' action=''>";
                                    echo "<input class='btn btn-outline-primary' type='submit' value='Modificar Alumno' name='modificar'>";
                                echo "</form>";
                            echo "</div>";
                            echo "<div class='col d-flex justify-content-center'>";
                                echo "<form method='post' action=''>";
                                    echo "<input class='btn btn-outline-primary' type='submit' value='Eliminar Alumno' name='eliminar'>";
                                echo "</form>";
                            echo "</div>";
                            echo "<div class='col d-flex justify-content-center'>";
                                echo "<form method='post' action=''>";
                                    echo "<input class='btn btn-outline-primary' type='submit' value='Ver Alumnos' name='visualizar'>";
                                echo "</form>";
                            echo "</div>";
                            echo "<div class='col d-flex justify-content-center'>";
                                echo "<form method='post' action=''>";
                                    echo "<input class='btn btn-danger' type= 'submit' value= 'Cerrar sesión' name='salir'>";
                                    echo "</form>";
                            echo "</div>";
                echo "</nav>";
            echo "</div>";
        echo "</div>";


//        echo "<h1>Bienvenido</h1>";
//        echo "<form method='post' action=''>";
//        echo "<input type='submit' value='Agregar alumno' name='agregar'>";
//        echo "<input type='submit' value='Modificar Alumno' name='modificar'>";
//        echo "<input type='submit' value='Eliminar Alumno' name='eliminar'>";
//        echo "<input type='submit' value='Ver Alumnos' name='visualizar'>";
//        echo "<input type= 'submit' value= 'Cerrar sesión' name='salir'>";
//        echo "</form>";
        break;
    case 3:
        echo "<div class='container w-100'>";
            echo "<div class='row'>";
                echo "<nav class='navbar navbar-light bg-light d-flex justify-content-around rounded mt-3 shadow'>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo  $_SESSION["usuario"];
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-primary' type='submit' value='Agregar alumno' name='agregar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Modificar Alumno' name='modificar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Eliminar Alumno' name='eliminar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Ver Alumnos' name='visualizar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-danger' type= 'submit' value= 'Cerrar sesión' name='salir'>";
                        echo "</form>";
                    echo "</div>";
                echo "</nav>";
            echo "</div>";
            echo "<div class='row mt-5 bg-white p-5 rounded shadow'>";
                echo "<form method='post'>";
                    echo "<div class='col'>";
                        echo "<div class='input-group mb-3'>";
                            echo "<input name='nombreAlumno' class='form-control' type='text' placeholder='Nombre del Alumno' required>";
                            echo "<input name='apellidosAlumno'  class='form-control' type='text' placeholder='Apellidos del Alumno' required>";
                        echo "</div>";
                        echo "<div class='input-group mb-3'>";
                            echo "<input name='dniAlumno' class='form-control' type='text' placeholder='DNI' required>";
                            echo "<input name='fecha_nacAlumno' class='form-control' type='date' placeholder='Fecha de nacimiento' required>";
                        echo "</div>";
                        echo "<div class='input-group mb-3'>";
                            echo "<select class='form-control' name='tipoviaAlumno' id='' required>";
                                echo "<option value='' disabled selected>Selecciona una opcion</option>";
                                echo "<option value='mansion'>Mansión</option>";
                                echo "<option value='puente'>Debajo de un puente</option>";
                                echo "<option value='basurero'>Basurero</option>";
                            echo "</select>";
                            echo "<input class='form-control' name='calleAlumno' type='text' placeholder='Nombre de la calle' required>";
                            echo "<input class='form-control' name='numeroAlumno' type='number' placeholder='Numero de la calle' required><br>";
                        echo "</div>";
                        echo "<div class='input-group mb-3'>";
                            echo "<input class='form-control' name='localidadAlumno' type='text' placeholder='Localidad' required><br>";
                            echo "<input class='form-control' name='telefonoAlumno' type='number' placeholder='Telefono' required><br>";
                        echo "</div>";
                        echo "<button class='btn btn-danger' name='añadirDatosAlumno' type='submit'>Añadir datos datos</button>";
                    echo "</div>";
                echo "  </form>";
            echo "</div>";
        echo "</div>";
        break;
    case 4:
        echo "<div class='container w-100'>";
            echo "<div class='row'>";
                echo "<nav class='navbar navbar-light bg-light d-flex justify-content-around rounded mt-3 shadow'>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo  $_SESSION["usuario"];
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Agregar alumno' name='agregar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-primary' type='submit' value='Modificar Alumno' name='modificar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Eliminar Alumno' name='eliminar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Ver Alumnos' name='visualizar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-danger' type= 'submit' value= 'Cerrar sesión' name='salir'>";
                        echo "</form>";
                    echo "</div>";
                echo "</nav>";
            echo "</div>";
        echo "</div>";

        echo "<form method='post' action=''>";
        echo "<input name='nombreAlumno' type='text' placeholder='Nombre del Alumno'>";
        echo "<input name='apellidosAlumno' type='text' placeholder='Apellidos del Alumno' >";
        echo "<input name='dniAlumno' type='text' placeholder='DNI' >";
        echo "<input name='fecha_nacAlumno' type='date' placeholder='Fecha de nacimiento'>";
        echo "<select name='tipoviaAlumno' id='' >";
        echo "<option value='' disabled selected>Selecciona una opcion</option>";
        echo "<option value='mansion'>Mansión</option>";
        echo "<option value='puente'>Debajo de un puente</option>";
        echo "<option value='basurero'>Basurero</option>";
        echo "</select>";
        echo "<input name='calleAlumno' type='text' placeholder='Nombre de la calle'>";
        echo "<input name='numeroAlumno' type='number' placeholder='Numero de la calle'>";
        echo "<input name='localidadAlumno' type='text' placeholder='Localidad'>";
        echo "<input name='telefonoAlumno' type='number' placeholder='Telefono'>";
        echo "<input type='submit' value='Buscar Alumnos' name='buscarModificados'>";
        echo "</form>";
        break;
    case 5:
        echo "<div class='container w-100'>";
            echo "<div class='row'>";
                echo "<nav class='navbar navbar-light bg-light d-flex justify-content-around rounded mt-3 shadow'>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo  $_SESSION["usuario"];
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Agregar alumno' name='agregar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Modificar Alumno' name='modificar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-primary' type='submit' value='Eliminar Alumno' name='eliminar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Ver Alumnos' name='visualizar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-danger' type= 'submit' value= 'Cerrar sesión' name='salir'>";
                        echo "</form>";
                    echo "</div>";
                echo "</nav>";
            echo "</div>";
        echo "</div>";

        echo "<form method='post' action=''>";
        echo "<input name='nombreAlumno' type='text' placeholder='Nombre del Alumno'>";
        echo "<input name='apellidosAlumno' type='text' placeholder='Apellidos del Alumno' >";
        echo "<input name='dniAlumno' type='text' placeholder='DNI' >";
        echo "<input name='fecha_nacAlumno' type='date' placeholder='Fecha de nacimiento'>";
        echo "<select name='tipoviaAlumno' id='' >";
        echo "<option value='' disabled selected>Selecciona una opcion</option>";
        echo "<option value='mansion'>Mansión</option>";
        echo "<option value='puente'>Debajo de un puente</option>";
        echo "<option value='basurero'>Basurero</option>";
        echo "</select>";
        echo "<input name='calleAlumno' type='text' placeholder='Nombre de la calle'>";
        echo "<input name='numeroAlumno' type='number' placeholder='Numero de la calle'>";
        echo "<input name='localidadAlumno' type='text' placeholder='Localidad'>";
        echo "<input name='telefonoAlumno' type='number' placeholder='Telefono'>";
        echo "<input type='submit' value='Buscar Alumnos' name='buscarEliminados'>";

        echo "</form>";
        break;
    case 6:
        echo "<div class='container w-100'>";
            echo "<div class='row'>";
                echo "<nav class='navbar navbar-light bg-light d-flex justify-content-around rounded mt-3 shadow'>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo  $_SESSION["usuario"];
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Agregar alumno' name='agregar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='c' type='submit' value='Modificar Alumno' name='modificar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Eliminar Alumno' name='eliminar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-outline-primary' type='submit' value='Ver Alumnos' name='visualizar'>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='col d-flex justify-content-center'>";
                        echo "<form method='post' action=''>";
                            echo "<input class='btn btn-danger' type= 'submit' value= 'Cerrar sesión' name='salir'>";
                        echo "</form>";
                    echo "</div>";
                echo "</nav>";
            echo "</div>";
        echo "</div>";

        echo "<form method='post' action=''>";
        echo "<input name='nombreAlumno' type='text' placeholder='Nombre del Alumno'>";
        echo "<input name='apellidosAlumno' type='text' placeholder='Apellidos del Alumno' >";
        echo "<input name='dniAlumno' type='text' placeholder='DNI' >";
        echo "<input name='fecha_nacAlumno' type='date' placeholder='Fecha de nacimiento'>";
        echo "<select name='tipoviaAlumno' id='' >";
        echo "<option value='' disabled selected>Selecciona una opcion</option>";
        echo "<option value='mansion'>Mansión</option>";
        echo "<option value='puente'>Debajo de un puente</option>";
        echo "<option value='basurero'>Basurero</option>";
        echo "</select>";
        echo "<input name='calleAlumno' type='text' placeholder='Nombre de la calle'>";
        echo "<input name='numeroAlumno' type='number' placeholder='Numero de la calle'>";
        echo "<input name='localidadAlumno' type='text' placeholder='Localidad'>";
        echo "<input name='telefonoAlumno' type='number' placeholder='Telefono'>";
        echo "<input type='submit' value='Buscar Alumnos' name='buscarVisto'>";

        break;
    case 7:

        break;
}

function mostrarTablaVisto($conexion, $consulta)
{
    $resultado = mysqli_query($conexion, $consulta);
    echo "<form method='post' action=''>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<td>";
    echo "Nombre";
    echo "</td>";
    echo "<td>";
    echo "Apellidos";
    echo "</td>";
    echo "<td>";
    echo "DNI";
    echo "</td>";
    echo "<td>";
    echo "Fecha de Nacimiento";
    echo "</td>";
    echo "<td>";
    echo "TIpo de Via";
    echo "</td>";
    echo "<td>";
    echo "Calle del alumno";
    echo "</td>";
    echo "<td>";
    echo "Numero del alumno";
    echo "</td>";
    echo "<td>";
    echo "Localidad";
    echo "</td>";
    echo "<td>";
    echo "Telefono";
    echo "</td>";
    echo "</tr>";
    while ($fila = mysqli_fetch_row($resultado)) {
        echo "<tr>";
        for ($i = 1; $i <= 9; $i++) {
            echo "<td>";
            echo $fila[$i];
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "</form>";
    mysqli_close($conexion);
}
function mostrarTablaEliminar($conexion, $consulta)
{
    $resultado = mysqli_query($conexion, $consulta);
    $_SESSION["IDs"] = array();
    $contador = 0;
    echo "<form method='post' action=''>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<td>";
    echo "Nombre";
    echo "</td>";
    echo "<td>";
    echo "Apellidos";
    echo "</td>";
    echo "<td>";
    echo "DNI";
    echo "</td>";
    echo "<td>";
    echo "Fecha de Nacimiento";
    echo "</td>";
    echo "<td>";
    echo "TIpo de Via";
    echo "</td>";
    echo "<td>";
    echo "Calle del alumno";
    echo "</td>";
    echo "<td>";
    echo "Numero del alumno";
    echo "</td>";
    echo "<td>";
    echo "Localidad";
    echo "</td>";
    echo "<td>";
    echo "Telefono";
    echo "</td>";
    echo "<td>";
    echo "Palomita llevame";
    echo "</td>";
    echo "</tr>";
    while ($fila = mysqli_fetch_row($resultado)) {
        array_push($_SESSION["IDs"], $fila[0]);
        echo "<tr>";
        for ($i = 1; $i <= 9; $i++) {
            echo "<td>";
            echo $fila[$i];
            echo "</td>";
        }
        echo "<td>";
        echo "<input type='checkbox' name='$contador'>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<input type='submit' value='Eliminar' name='eliminarAlumnos'>";
    echo "</form>";
    mysqli_close($conexion);

}
function eliminarAlumno($conexion)
{
    for ($i = 0; $i < count($_SESSION["IDs"]); $i++) {
        if (isset($_POST[$i])) {
            $id = $_SESSION["IDs"][$i];
            $consulta = " DELETE
                      FROM escuela.alumnos
                      WHERE id = $id";
            $resultado = mysqli_query($conexion, $consulta);
        }
    }

}
function crearBusqueda()
{
    $nombreAlumno = "";
    $apellidosAlumno = "";
    $dniAlumno = "";
    $fecha_nacAlumno = "";
    $tipoviaAlumno = "";
    $calleAlumno = "";
    $numeroAlumno = "";
    $localidadAlumno = "";
    $telefonoAlumno = "";
    if (isset($_POST["nombreAlumno"])) {$nombreAlumno = $_POST["nombreAlumno"];}if (isset($_POST["apellidosAlumno"])) {$apellidosAlumno = $_POST["apellidosAlumno"];}if (isset($_POST["dniAlumno"])) {$dniAlumno = $_POST["dniAlumno"];}if (isset($_POST["fecha_nacAlumno"])) {$fecha_nacAlumno = $_POST["fecha_nacAlumno"];}if (isset($_POST["tipoviaAlumno"])) {$tipoviaAlumno = $_POST["tipoviaAlumno"];}if (isset($_POST["calleAlumno"])) {$calleAlumno = $_POST["calleAlumno"];}if (isset($_POST["numeroAlumno"])) {$numeroAlumno = $_POST["numeroAlumno"];}if (isset($_POST["localidadAlumno"])) {$localidadAlumno = $_POST["localidadAlumno"];}if (isset($_POST["telefonoAlumno"])) {$telefonoAlumno = $_POST["telefonoAlumno"];}
    //  COMPROBAR QUE NO EXISTE UN USUARIO IGUAL
    $consulta = "SELECT
    *
FROM
    alumnos
WHERE
        nombre like '%$nombreAlumno%' AND
        apellidos  like '%$apellidosAlumno%' AND
        dni  like '%$dniAlumno%' AND
        fechaNacimiento like '%$fecha_nacAlumno%' AND
        idTipoVia like '%$tipoviaAlumno%' AND
        nombreVia like '%$calleAlumno%' AND
        numeroVia like '%$numeroAlumno%' AND
        localidad like '%$localidadAlumno%' AND
        telefono like '%$telefonoAlumno%'";

    return $consulta;
}
function mostrarTablaEditable($conexion, $consulta)
{
    $resultado = mysqli_query($conexion, $consulta);
    $_SESSION["IDs"] = array();
    $contador = 1;
    echo "<form method='post' action=''>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<td>";
    echo "Nombre";
    echo "</td>";
    echo "<td>";
    echo "Apellidos";
    echo "</td>";
    echo "<td>";
    echo "DNI";
    echo "</td>";
    echo "<td>";
    echo "Fecha de Nacimiento";
    echo "</td>";
    echo "<td>";
    echo "TIpo de Via";
    echo "</td>";
    echo "<td>";
    echo "Calle del alumno";
    echo "</td>";
    echo "<td>";
    echo "Numero del alumno";
    echo "</td>";
    echo "<td>";
    echo "Localidad";
    echo "</td>";
    echo "<td>";
    echo "Telefono";
    echo "</td>";
    echo "</tr>";
    while ($fila = mysqli_fetch_row($resultado)) {
        array_push($_SESSION["IDs"], $fila[0]);
        echo "<tr>";
        for ($i = 1; $i <= 9; $i++) {
            echo "<td>";
            echo "<input name='$contador' value='$fila[$i]' type='text'>";
            $contador++;
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "<input type='submit' value='Guardar Cambios' name='actualizarAlumnos'>";
    echo "</form>";
    mysqli_close($conexion);
}
function guardarCambios($conexion)
{
    $contador = 1;
    for ($i = 0; $i < count($_SESSION["IDs"]); $i++) {
        $data = array();
        for ($a = 0; $a < 9; $a++) {
            array_push($data, $_POST[$contador]);
            $contador++;
        }
        $id = $_SESSION["IDs"][$i];
        $consulta = "    UPDATE alumnos
                         SET nombre = ?,
                             apellidos= ?,
                             dni = ?,
                             fechaNacimiento = ?,
                             idTipoVia = ?,
                             nombreVia = ?,
                             numeroVia = ?,
                             localidad = ?,
                             telefono = ?
                         WHERE id = $id";

        $resultado = mysqli_prepare($conexion, $consulta);
        $ok = mysqli_stmt_bind_param($resultado, "sssssssss", ...$data);
        $ok = mysqli_stmt_execute($resultado);

        if ($ok == false) {
            echo "error";
        } else {
            $_SESSION["seccion"] = 4;
            mysqli_stmt_close($resultado);
        }
    }
    mysqli_close($conexion);
}
function añadirAlumno($conexion)
{
    $consulta = "CREATE TABLE IF NOT EXISTS `alumnos` (
`id` INT(10) NOT NULL AUTO_INCREMENT ,
`nombre` VARCHAR(50) NOT NULL , `apellidos` VARCHAR(50) NOT NULL ,
`dni` VARCHAR(50) NOT NULL , `fechaNacimiento` VARCHAR(50) NOT NULL ,
`idTipoVia` VARCHAR(50) NOT NULL , `nombreVia` VARCHAR(50) NOT NULL ,
`numeroVia` VARCHAR(50) NOT NULL , `localidad` VARCHAR(50) NOT NULL ,
`telefono` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
    $resultado = mysqli_query($conexion, $consulta);

    if (isset($_POST["nombreAlumno"]) && isset($_POST["apellidosAlumno"])
        && isset($_POST["dniAlumno"]) && isset($_POST["fecha_nacAlumno"])
        && isset($_POST["tipoviaAlumno"]) && isset($_POST["calleAlumno"])
        && isset($_POST["numeroAlumno"]) && isset($_POST["localidadAlumno"])
        && isset($_POST["telefonoAlumno"])) {

        $data = array($_POST["nombreAlumno"],
            $_POST["apellidosAlumno"],
            $_POST["dniAlumno"],
            $_POST["fecha_nacAlumno"],
            $_POST["tipoviaAlumno"],
            $_POST["calleAlumno"],
            $_POST["numeroAlumno"],
            $_POST["localidadAlumno"],
            $_POST["telefonoAlumno"]);

        $consulta = "INSERT INTO `alumnos` (`nombre`, `apellidos`, `dni`, `fechaNacimiento`, `idTipoVia`, `nombreVia`, `numeroVia`, `localidad`, `telefono`)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $resultado = mysqli_prepare($conexion, $consulta);
        $ok = mysqli_stmt_bind_param($resultado, "sssssssss", ...$data);
        $ok = mysqli_stmt_execute($resultado);
        if ($ok == false) {
            echo "Error!!";
        } else {
            echo "Alumno introducido";
            mysqli_stmt_close($resultado);
        }
    }
    mysqli_close($conexion);
}
function login($conexion)
{

//  COMPROBAR QUE NO EXISTE UN USUARIO IGUAL
    $usuario = $_POST["usuario"];
    $consulta = "SELECT usuario FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $consulta);
    if (mysqli_fetch_row($resultado) !== null) {
// SI EXISTE, COMPRUEBA SI LA CONTRASEÑA COINCIDE

        $consulta = "SELECT contraseña FROM usuarios WHERE usuario = '$usuario'";
        $resultado = mysqli_query($conexion, $consulta);
        $hash = mysqli_fetch_row($resultado);
        if (password_verify($_POST["contraseña"], $hash[0]) == 1) {
            $_SESSION["seccion"] = 2;
            return 0;
        } else {
            return 1;
        }

    } else {
        return 2;
        $_SESSION["seccion"] = 0;
    }

//    CERRAR LA CONEXION
    mysqli_close($conexion);

}
function registro($conexion)
{
//    CREAR TABLA SI NO EXISTE
    $consulta = "CREATE TABLE IF NOT EXISTS `escuela`.`usuarios` ( `id` INT NOT NULL AUTO_INCREMENT , `usuario` VARCHAR(60) NOT NULL ,
 `contraseña` VARCHAR(255) NOT NULL , `fecha_alt` VARCHAR(60) NOT NULL , `permisos` VARCHAR(60) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
    $resultado = mysqli_query($conexion, $consulta);
//  COMPROBAR QUE NO EXISTE UN USUARIO IGUAL
    $usuario = $_POST["usuario"];
    $consulta = "SELECT usuario FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_fetch_row($resultado) !== null) {
        $_SESSION["seccion"] = 1;
        return 1;
    } else {
//    CREAR EL USUARIO
        $hoy = getdate();
        $fecha = $hoy["mday"] . "/" . $hoy["mon"] . "/" . $hoy["year"];
        $contra = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);

         $consulta = "INSERT INTO `usuarios` (`usuario`, `contraseña`, `fecha_alt`, `permisos`)VALUES (?, ?, ?, ?)";
        $resultado = mysqli_prepare($conexion, $consulta);
        $ok = mysqli_stmt_bind_param($resultado, "ssss", ...$data);
        $ok = mysqli_stmt_execute($resultado);

        if ($ok == false) {
            echo "error";
        } else {
            $_SESSION["seccion"] = 0;
            mysqli_stmt_close($resultado);
        }
    }

//    CERRAR LA CONEXION
    mysqli_close($conexion);
}
function imp($array)
{
    echo '<pre>';
    print_r($array);
    echo '<pre>';
}
?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/js.js"></script>
</body>
</html>