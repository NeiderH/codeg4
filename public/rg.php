<?php
require '../app/Controllers/Password.php';

$host = 'localhost'; 
$dbname = 'prueba';
$username = 'root'; 
$password = ''; 

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>

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
    .password-container {
        margin-top: 10px;
        text-align: center;
    }
    .copy-btn {
        margin-top: 5px;
        padding: 5px 10px;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
    }
    .copy-btn:hover {
        background-color: #0056b3;
    }
</style>

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
    <?php
  session_start(); // Asegúrate de iniciar la sesión al principio

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nit = $_POST['nit'];
      $email = $_POST['correo'];
  
      $password = getRandomString(12); 
      $hash = md5($password);
  
      try {
          $stmt = $db->prepare("INSERT INTO usuario (nit, correo, contrasena) VALUES (?, ?, ?)");
          $stmt->execute([$nit, $email, $hash]);
  
          $_SESSION['generated_password'] = $password; 
  
          echo "
          <div class='password-container'>
              <p>Registro exitoso. Tu contraseña generada es: <strong id='generated-password'>$password</strong></p>
              <button type='button' class='copy-btn' onclick='copyToClipboard()'>Copiar contraseña</button>
          </div>";
      } catch (PDOException $e) {
          echo "<p>Error al registrar: " . $e->getMessage() . "</p>";
      }
  }
  
    ?>
    <a href="login.php">Login</a>
</form>

<script>
function copyToClipboard() {
    const password = document.getElementById('generated-password').textContent;
    navigator.clipboard.writeText(password).then(() => {
        alert('Contraseña copiada al portapapeles.');
    }).catch(err => {
        alert('Error al copiar la contraseña: ' + err);
    });
}
</script>
