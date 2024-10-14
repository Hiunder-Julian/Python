<?php
session_start(); // Iniciar sesión para manejar mensajes flash

// Conexión a la base de datos
$servername = "localhost"; // o tu servidor
$username = "root"; // tu usuario de base de datos
$password = ""; // tu contraseña de base de datos
$dbname = "Moragas"; // nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos de la tabla Juego2
$sql = "SELECT id, Nombre, imagen FROM Juego2"; // Cambia a Juego2
$result = $conn->query($sql);
$juegos2 = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $juegos2[] = $row;
    }
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agregar_juego'])) {
        $nuevo_nombre = $_POST['nuevo_nombre'];
        $nuevo_imagen = $_FILES['nuevo_imagen'];
        $nuevo_target_file = '';

        // Manejo de la nueva imagen
        if ($nuevo_imagen['error'] == 0) {
            $target_dir = "";
            $nuevo_target_file = $target_dir . basename($nuevo_imagen["name"]);
            if (!move_uploaded_file($nuevo_imagen["tmp_name"], $nuevo_target_file)) {
                echo "Error al mover el archivo.";
            }

            // Insertar en la base de datos
            $sql = "INSERT INTO Juego2 (Nombre, imagen) VALUES (?, ?)"; // Cambia a Juego2
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ss", $nuevo_nombre, $nuevo_target_file);
                
                if ($stmt->execute()) {
                    $_SESSION['message'] = "Juego agregado con éxito.";
                } else {
                    $_SESSION['message'] = "Error al agregar el juego: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error en la preparación de la consulta: " . $conn->error;
            }
        }
    } else {
        // Manejo de la actualización existente
        $juego_id = $_POST['juego_id'];
        $nombre = $_POST['nombre'];
        $imagen = $_FILES['imagen'];
        $target_file = '';

        // Manejo de la imagen
        if ($imagen['error'] == 0) {
            $target_dir = "";
            $target_file = $target_dir . basename($imagen["name"]);
            if (!move_uploaded_file($imagen["tmp_name"], $target_file)) {
                echo "Error al mover el archivo.";
            }
        } else {
            // Mantener la imagen actual si no se subió una nueva
            $target_file = $_POST['imagen_actual'];
        }

        // Actualizar en la base de datos
        $sql = "UPDATE Juego2 SET Nombre=?, imagen=? WHERE id=?"; // Cambia a Juego2
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            // Actualizar solo nombre e imagen
            $stmt->bind_param("ssi", $nombre, $target_file, $juego_id);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = "Juego actualizado con éxito.";
            } else {
                $_SESSION['message'] = "Error al actualizar el juego: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración de Juego2</title>
    <style>
        /* (tu estilo aquí, similar al anterior) */
    </style>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #000000, #000000);
            color: #000000;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.5rem;
        }

        ul {
            list-style-type: none;
            padding: 0;
            width: 90%;
            max-width: 600px;
            margin: 0 auto;
        }

        li {
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="file"] {
            padding: 4px;
        }

        img {
            display: block;
            margin: 10px 0;
            border-radius: 5px;
            width: 100px;
            height: auto;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            display: none;
        }

        #nuevoJuegoForm {
            margin-top: 20px;
        }
</style>
<body>
    <header>
        <h1>Administración de Juegos 2</h1>
        <a href="admin.php">
            <button type="button">Juego1</button>
        </a>
    </header>
    
    <ul>
        <?php foreach ($juegos2 as $juego2): ?>
            <li>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="juego_id" value="<?php echo $juego2['id']; ?>">
                    <input type="hidden" name="imagen_actual" value="<?php echo $juego2['imagen']; ?>">
                    
                    <label>Nombre:</label>
                    <input type="text" name="nombre" value="<?php echo $juego2['Nombre']; ?>" required>
                    
                    <label>Foto:</label>
                    <input type="file" name="imagen" accept="image/*">
                    <img src="<?php echo $juego2['imagen']; ?>" alt="Imagen actual">
                    
                    <button type="submit">Actualizar Juego</button>
                    
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <button id="agregarJuego" type="button">Agregar imagen</button>

    <div id="nuevoJuegoForm" style="display:none;">
        <form action="" method="post" enctype="multipart/form-data">
            <label>Nombre:</label>
            <input type="text" name="nuevo_nombre" required>
            
            <label>Foto:</label>
            <input type="file" name="nuevo_imagen" accept="image/*" required>
            
            <button type="submit" name="agregar_juego">Agregar imagen</button>
        </form>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="message">
            <p><?php echo $_SESSION['message']; ?></p>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <script>
        document.getElementById("agregarJuego").onclick = function() {
            var form = document.getElementById("nuevoJuegoForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        };
    </script>
</body>
</html>
