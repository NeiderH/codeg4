<?php
namespace App\Controllers;

use App\Models\UsuarioModel;

class RegistroController extends BaseController
{
    public function registrar()
    {
        if ($this->request->getMethod() === 'post') {
            $nit = $this->request->getPost('nit');
            $email = $this->request->getPost('correo');

            // Generar contraseña automática
            $password = bin2hex(random_bytes(6)); // Genera una contraseña de 12 caracteres
            $hash = md5($password); // Encriptar la contraseña

            // Guardar en la base de datos
            $usuarioModel = new UsuarioModel();

            try {
                $usuarioModel->insert([
                    'nit'       => $nit,
                    'correo'    => $email,
                    'contrasena' => $hash,
                ]);

                return "<p>Registro exitoso. Tu contraseña generada es: <strong>$password</strong></p>";
            } catch (\Exception $e) {
                return "<p>Error al registrar: " . $e->getMessage() . "</p>";
            }
        }

        // Cargar la vista del formulario
        return view('rg.php');
    }
}
?>