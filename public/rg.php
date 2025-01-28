<?php
require '../app/Controllers/Password.php'; // Asegúrate de que este archivo contiene la función getRandomString

// Configuración de la base de datos
$host = 'localhost'; // Cambia esto si tu base de datos está en otro servidor
$dbname = 'prueba';
$username = 'root'; // Cambia esto por tu usuario de la base de datos
$password = ''; // Cambia esto por tu contraseña de la base de datos

try {
    // Crear una conexión PDO
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configurar PDO para manejar excepciones
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nit = $_POST['nit'];
    $email = $_POST['correo'];

    // Generar contraseña automática
    $password = getRandomString(12); 
    $hash = md5($password); // Encriptar la contraseña generada

    try {
        // Insertar datos en la tabla usuario
        $stmt = $db->prepare("INSERT INTO usuario (nit, correo, contrasena) VALUES (?, ?, ?)");
        $stmt->execute([$nit, $email, $hash]);
        
        // Mostrar la contraseña generada al usuario
        echo "<p>Registro exitoso. Tu contraseña generada es: <strong>$password</strong></p>";
    } catch (PDOException $e) {
        echo "<p>Error al registrar: " . $e->getMessage() . "</p>";
    }
}
?>

<!-- Estilos CSS -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"], input[type="email"] {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        width: 100%;
        padding: 10px;
        background-color: #28a745;
        border: none;
        border-radius: 4px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
    }
    button:hover {
        background-color: #218838;
    }
    h3 {
        margin-bottom: 20px;
        text-align: center;
    }
</style>

<!-- Formulario HTML -->
<form method="POST">
    <h3>Registro, contraseñas automáticas</h3>
    <div class="form-group">
        <label for="nit">Nit de usuario</label>
        <input type="text" name="nit" id="nit" placeholder="Ingresa tu NIT" required>
    </div>
    <div class="form-group">
        <label for="correo">Correo electrónico</label>
        <input type="email" name="correo" id="correo" placeholder="Ingresa tu correo electrónico" required>
    </div>
    <hr>
    <button type="submit">Registrarse</button>
</form>