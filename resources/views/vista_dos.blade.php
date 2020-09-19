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
    font-family: Arial, Helvetica, sans-serif;
}

.titulo {
    color: #292b2c;
    z-index: 1;
    padding-top: 50px;
    width: 800px;
    text-align: center;
    font-family: 'Courier New', Courier, monospace;
}

.titulo h2 {
    text-decoration: underline;
}

.titulo img {
    position: absolute;
    top: 0;
    left: 630px;
}

.top {
    padding-top: 0.5em;
}

.titulo p {
    color: black;
    font-size: 16px;
    font-weight: 700;
}

.img img {
    position: absolute;
    width: 800px;
    height: 1100px;
    left: 0;
    top: 0;
    z-index: -1;
    opacity: .35;
}

#fisrt {
    width: 800px;
    align-items: center;
    color: red;
    margin-top: 1em;
    margin-left: 200px;
}

#fisrt p {
    color: black;
    font-size: 16px;
    font-weight: 700;
    padding-left: 5px;
}

.autocomplete {
    width: 800px;
    align-items: center;
    font-family: helvetica;
    color: red;
    margin-left: 200px;
}

.autocomplete p {
    color: black;
    font-size: 16px;
    font-weight: 700;
    padding-left: 5px;
}

.table_v {
    width: 800px;
    margin-top: 50px;
}

table {
    width: 80%;
    margin: auto;
}

table th {
    text-align: center;
    border: 1px black solid;
    padding: 15px 10px;
}

table td {
    text-align: left;
    border: 1px black solid;
    padding: 15px 10px;
}

.contenedor {
    width: 80%;
    margin: auto;
    height: auto;
    padding: 5px;
    display: grid;
    background-color: rgba(101, 187, 243, 0.50);
    border-radius: 10px;
    margin-top: 15px;
}

.container {
    width: 100%;
    padding: 0px;
    display: grid;
    grid-template-columns: 18% 22% 60%;
}

.container div {
    /* border: 1px red solid; */
}

.descDias {
    font-size: 15px;
    padding-left: 100px;
}

ul {
    list-style: none;
}

.comidas {
    width: auto;
}

.wrapper {
    width: 80%;
    height: auto;
    margin: auto;
    display: grid;
    grid-template-columns: 30% 70%;
    padding: 15px;
}

.notas {
    width: 80%;
    margin: auto;
    height: auto;
    margin-top: 30px;
}

#contNotas {
    width: 100%;
    height: 150px;
    border-radius: 10px;
    padding: 10px;
    background-color: rgb(128, 128, 128, .50);
}

.musculo {
    padding: 1.8px;
    margin-left: 8px;
    background-color: rgb(128, 128, 128, .30);
    font-size: 13px;
    border-radius: 10px;
}
.bg-azul {
    background-color: rgba(101, 187, 243, 0.50);
    border-radius: 10px;
    margin-top: 4px;
    border-radius: 10px;
    padding-top: 0px;
}
.taman {
    font-size: 15px;
}
    </style>
</head>
<body>
    <div class="img">
        <img width="11%" src="{{ url('/assets/fondo-2.png') }}" alt="">
    </div>
    <div class="titulo">
    <h2>FITNESS AND SHAPE SYSTEM</h2>
    <img width="19%" src="{{ url('/assets/200px.png') }}" alt="">
    <p class="top">L.N. Rolando Arutro Almeida Burgos</p>
    <p>Especialista en Nutrición y Suplementación Deportiva</p>
    <p>Entrenador Profecional y Personalizado</p>
    <p>Cel: (999) 2 42 12 49 / e-mail: roly_alme@hotmail.com</p>
    </div>
    <table>
        <tr>
            <td style="border:none; width: 45%;">
                <ul>
                    <li>Fecha: </li>
                    <li>Nombre: </li>
                    <li>Peso: </li>
                    <li>Pct tejido adiposo: </li>
                    <li>Pct masa muscular: </li>
                </ul>
            </td>
            <td style="border:none;">
                <ul>
                    <li>{{date("d") . " de " . date("F"). " del " . date("Y")}}</li>
                    <li>{{$data['nombre']}}</li>
                    <li>{{$data['peso']}} kg</li>
                    <li>{{$data['pctgrasa']}} %</li>
                    <li>{{$data['masa_muscular']}} %</li>
                   
                </ul>
            </td>
        </tr>
    </table>

    {{-- REPITE --}}
    @foreach ($data['entrenamiento'] as $entrenamiento)   
    <table class="bg-azul" cellspacing="0" cellpadding="0" border="0" style="border:none;">
        <tr class="taman">
            <td COLSPAN=2 style="width: 19%; border:none; padding-top: 0;">
                {{ $entrenamiento['dias'] }}
            </td>
            <td style="border:none; padding-top: 0;">
                ({{ $entrenamiento['descripcion'] }})
            </td>
        </tr>
        {{-- REPITE --}}
        @foreach ($entrenamiento['programa'] as $programa)
        <tr >
            <td class="taman" style="width: 19%; border:none; padding-top: 0; vertical-align:text-top;">
                {{ $programa['nombre'] }}
            </td>
            <td  class="taman" style="width: 24%; border:none; padding-top: 0; vertical-align:text-top;" ">
                <ul>
                    <li>{{ $programa['repeticiones'] }} X {{ $programa['vueltas'] }}</li>
                    <li>{{ $programa['descanso'] }} s. descanso</li>
                </ul>
            </td>
            <td class="taman" style="border:none; padding-top: 0; vertical-align:text-top; "">
                <ul>
                     {{-- REPITE --}}
                     @foreach (json_decode($programa['det_programa'], true) as $det)
                    <li>- {{ $det['ejercicio'] }} <span class="musculo ">{{ $det['musculo'] }}</span> </li>
                    @endforeach     
                </ul>
            </td>
        </tr>
        @endforeach
    </table>
    @endforeach
    <div class="notas">
        <h4>Observaciones</h4>
        <div id="contNotas">
            <p>
                {{$data['notas_entrenamiento']}}
            </p>
        </div>
    </div>
</body>
</html>