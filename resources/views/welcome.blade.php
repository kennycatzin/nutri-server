<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../storage/fonts/Spartan.ttf">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        * {
    font-family: fantasy;
}

.black {
    background-color: #292b2c;
}
 img {
    position: absolute;
    top: 0;

}
.container {
    background-color: white;
    width: 840px;
    height: auto;
    margin: auto;
}

.cabecera {
    width: 840px;
    text-align: center;
    margin: auto;
    color: white;
}

.logo {
    width: 840px;
    margin: auto;
    padding-top: 40px;
    text-align: center;
}

footer {
    color: white;
    width: 720px;
    margin: auto;
    text-align: center;
}

.centrar {
    color: white;
    padding: 30px;
    margin: auto;
}

.iconos {
    padding: 30px;
}

.contenido {
    width: 720px;
    margin: auto;
}

.boton {
    background-color: #d9534f;
    color: white;
    font-size: 30px;
    padding: 10px;
    border-radius: 14px;
    border: 0px;
	text-decoration: none;
}

.contIm {
    text-align: right;
}

.cent {
    text-align: center;
}

.programa {
    font-size: 25px;
}

.sesion {
    font-size: 23px;
    color: #d9534f;
}

.gris {
    color: #292b2c;
    font-size: 19px;
}

.rojo {
    color: #d9534f;
}
a{
    text-decoration: none;
}

    </style>
</head>

<body class="black">
    <div class="cabecera">
        <h1> <span class="rojo">Fitness</span> & <span>shape system</span> </h1>
    </div>

    <div class="container">
        <div class="logo">
            <img src="https://nutri-serve.herokuapp.com/assets/200px.png" alt="">
        </div>
        <div>
            <table class="contenido">
                <tr>
                    <td class="cent">
                        <h3 class="programa">Programa de alimentación
                        </h3>
                        <h2 class="sesion">Sesión # {{$conteo}}
                        </h2>
                        <p class="gris"><b>No es una dieta</b> Es un estilo de vida
                        </p>
                        <br>
                        <a  href="{{$urlDieta}}" class="boton">Descargar</a>
                    </td>
                    <td class="contIm">
                        <img width="250px" src="{{url('/assets/dieta.jpg')}}" alt="">
                    </td>
                </tr>
            </table>
            <table class="contenido">
                <tr>
                    <td class="cent">
                        <h3 class="programa">Programa de entrenamiento
                        </h3>
                        <h2 class="sesion">Sesión # {{$conteo}}
                        </h2>
                        <p class="gris">
                            <b>Mejora el rendimiento </b> Físico e intelectual
                        </p>
                        <br>
                        <a  href="{{$urlEntrenamiento}}" class="boton">Descargar</a>
                    </td>
                    <td class="contIm">
                        <img width="310px" src="{{url('/assets/entrenamiento.png')}}" alt="">
                    </td>
                </tr>
            </table>
            <br><br>

        </div>
    </div>
    <footer>
        <table class="centrar">
            <tr>
                <td class="iconos">
                    <a href=""><img src="{{ url('/assets/instagram.png') }}" alt=""></a>

                </td>
                <td class="iconos">
                    <a href=""> <img src="{{ url('/assets/facebook.png') }}"  alt="">
                    </a>
                </td>
                <td class="iconos">
                    <a href=""> <img src="{{ url('/assets/gorjeo.png') }}"  alt="">
                    </a>
                </td>
                <td class="iconos">
                    <a href=""> <img src="{{ url('/assets/youtube.png') }}"  alt="">
                    </a>
                </td>
            </tr>
        </table>
    </footer>
</body>

</html>
