<?php
require_once __DIR__ . '/../models/TokenApi.php';
require_once __DIR__ . '/../models/ClientApi.php';

class TokenApiController
{
    private $tokenApiModel;
    private $clientApiModel;

    public function __construct()
    {
        $this->tokenApiModel = new TokenApi();
        $this->clientApiModel = new ClientApi();
    }

    public function getConexion()
    {
        return $this->tokenApiModel->getConexion();
    }

    // Listar todos los tokens
    public function listarTokens()
    {
        return $this->tokenApiModel->obtenerTokens();
    }

    // Obtener un token por ID
    public function obtenerToken($id)
    {
        return $this->tokenApiModel->obtenerTokenPorId($id);
    }

    // Obtener tokens por cliente
    public function obtenerTokensPorCliente($id_client_api)
    {
        return $this->tokenApiModel->obtenerTokensPorCliente($id_client_api);
    }

    // Crear un nuevo token
    public function crearToken($id_client_api)
    {
        $token = $this->tokenApiModel->generarToken();
        return $this->tokenApiModel->guardarToken($id_client_api, $token);
    }

    // Editar un token
    public function editarToken($id, $estado)
    {
        return $this->tokenApiModel->actualizarToken($id, $estado);
    }

    // Eliminar un token
    public function borrarToken($id)
    {
        return $this->tokenApiModel->eliminarToken($id);
    }

    // Obtener clientes para el select
    public function obtenerClientes()
    {
        return $this->clientApiModel->obtenerClientes();
    }
}
?>
