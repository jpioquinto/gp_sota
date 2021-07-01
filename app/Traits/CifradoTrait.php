<?php
namespace App\Traits;

trait CifradoTrait
{    
    public function desencriptar($dato)
    {
        return $this->encrypter->decrypt($dato);
    }

    public function encriptar($dato)
    {
        return $this->encrypter->encrypt($dato);
    }

}
