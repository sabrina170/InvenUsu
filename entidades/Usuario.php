<?php

class Usuario
{

    private $codigo;
    private $codigonum;
    private $nombre;
    private $usuario;
    private $email;
    private $password;
    private $privilegio;
    private $fecha_registro;

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function getCodigonum()
    {
        return $this->codigonum;
    }

    public function setCodigonum($codigonum)
    {
        $this->codigonum = $codigonum;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPrivilegio()
    {
        return $this->privilegio;
    }

    public function setPrivilegio($privilegio)
    {
        $this->privilegio = $privilegio;
    }

    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    public function setFecha_registro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

}
