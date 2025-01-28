<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id'; // Cambia esto si el campo clave primaria tiene otro nombre
    protected $allowedFields = ['nit', 'correo', 'contrasena'];
}
?>