<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../storage/fonts/Spartan.ttf">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FITNESS & SHAPE SISTEM</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Helvetica;
            }
        .titulo{
            color: red;
            z-index: 1;
            padding-top: 50px;
            width: 800px;
            text-align: center
        }
        .titulo h2{
            text-decoration: underline;
        }
        .titulo img{
            position: absolute;
            top: 0;
            left: 600px;
        }
        .top{
            padding-top: 0.5em;
        }
        .titulo p{
            color: black;
            font-size: 16px;
            font-weight: 700;
        }
        .img img{
            position: absolute;
            width: 800px;
            height: 1100px;
            left: 0;
            top: 0;
            z-index: -1;
        }
        #fisrt{
            width: 800px;
            align-items: center;
            color: #0073C4;
            margin-top: 1em;
            margin-left: 200px;
        }
        #fisrt p{
            color: black;
            font-size: 16px;
            font-weight: 700;
            padding-left: 5px;
        }
        .autocomplete{
            width: 800px;
            align-items: center;
            font-family: helvetica;
            color: #0073C4;
            margin-left: 200px;
        }
        .autocomplete p{
            color: black;
            font-size: 16px;
            font-weight: 700;
            padding-left: 5px;
        }
        .table_v{
            width: 800px;
            margin-top: 50px;
        }
        table{
            width: 80%;
            margin: auto;
            
        }
        table tr th{
            color: #0073C4;
            border: 1px #0073c4 solid;
        }
    </style>
</head>
<body>
    <div class="img">
        <img src="http://serteza.com/nut-serv/storage/public/fondo-2.png" alt="">
    </div>
    <div class="titulo">
    <h2>FITNESS AND SHAPE SYSTEM</h2>
    <img src="http://serteza.com/nut-serv/storage/public/200px.png" alt="">
    <p class="top">L.N. Rolando Arutro Almeida Burgos</p>
    <p>Especialista en Nutrición y Suplementación Deportiva</p>
    <p>Entrenador Profecional y Personalizado</p>
    <p>Cel: (999) 2 42 12 49 / e-mail: roly_alme@hotmail.com</p>
    </div>
    <div id="fisrt">
        <h4>FECHA : </h4>
        <p>{{date("d") . " de " . date("F"). " del " . date("Y")}}</p>
    </div>
    <div class="autocomplete">
        <h4>NOMBRE :</h4>
        <p>{{"Info de la bd"}}</p>
    </div>
    <div class="autocomplete">
        <h4>PESO :</h4>
        <p>{{"Info de la bd"}}</p>
    </div>
    <div class="autocomplete">
        <h4>PORCENTAJE DE TEJIDO ADIPOSO :</h4>
        <p>{{"Info de la bd"}}</p>
    </div>
    <div class="autocomplete">
        <h4>MASA MUSCULAR :</h4>
        <p>{{"Info de la bd"}}</p>
    </div>
    <div class="table_v">
        <table>
           <tr>
                <th>
                    PECHO
                </th>
                <th>
                    LUNES
                </th>
                <th>
                    JUEVES
                </th>
            </tr>
            <tr>
                <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptas sint omnis magni error beatae quaerat.</td>
                <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sapiente, praesentium?</td>
                <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem similique reiciendis nostrum harum consequuntur. Alias excepturi enim voluptatum! Sequi, ex.</td>
            </tr> 
        </table>
    </div>
</body>
</html>