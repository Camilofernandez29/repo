<?php
    include_once 'database.php';
    
    session_start();

    if(isset($_GET['cerrar_sesion'])){
        session_unset(); 

        // destroy the session 
        session_destroy(); 
    }
    
    if(isset($_SESSION['rol'])){
        switch($_SESSION['rol']){
            case 1:
                header('location: admin.php');
            break;

            case 2:
            header('location: colab.php');
            break;

            default:
        }
    }

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $db = new Database();
         $query = $db->connect()->prepare('SELECT *FROM usuarios WHERE nombre = :nombre AND clave = :clave');
        
        $query->execute(['nombre' => $username, 'clave' => $password]);

        $row = $query->fetch(PDO::FETCH_NUM);
        if(password_verify($password,$row[2]))
        {
            echo 'contraseña valida';


        }else{


            echo 'contraseña invalida';


        }

        if($row){
            $rol = $row[3];
            
            $_SESSION['rol'] = $rol;

            switch($rol){
                case 1:
                    header('location: admin.php');
                
                break;

                case 2:
                header('location: colab.php');
                break;

                default:
            }
        }else{
            // no existe el usuario
            echo "Nombre de usuario o contraseña incorrecto";
        
        }
        

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Login</title>
</head>
<body>
    <form action="#" method="POST">
        Username: <br/><input type="text" name="username"><br/>
        Password: <br/><input type="text" name="password"><br/>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>