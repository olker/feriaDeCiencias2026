<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Feria</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            display:flex;
            background:#f5f7fa;
        }

        .sidebar{
            width:250px;
            height:100vh;
            background:#1e293b;
            color:white;
            padding:20px;
        }

        .sidebar h2{
            margin-bottom:30px;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:12px;
            margin-bottom:10px;
            border-radius:8px;
        }

        .sidebar a:hover{
            background:#334155;
        }

        .content{
            flex:1;
            padding:30px;
        }

    </style>

</head>
<body>

<div class="sidebar">

    <h2>FERIA</h2>

    <a href="#">Dashboard</a>
    <a href="#">Docentes</a>
    <a href="#">Alumnos</a>
    <a href="#">Cursos</a>
    <a href="#">Materias</a>
    <a href="#">Grupos</a>
    <a href="#">Reportes</a>

</div>

<div class="content">

    @yield('contenido')

</div>

</body>
</html>