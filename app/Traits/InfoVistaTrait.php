<?php
namespace App\Traits;

trait InfoVistaTrait
{

    public function generarBreadCrumbs($controlador)
    {
        helper('util');
        $li = '';
        foreach ($this->usuario->permisos as $key=>$value) {
            if ($value['controlador'] != getNameClass($controlador)) {
                continue;
            }
            if ($value['nodo_padre'] > 0) {
                $li .= $this->obtenerListadoPadre($value['nodo_padre']);
            }
            $li .= $this->elementoHTML($value);
        }
        return $li;
    }

    public function obtenerListadoPadre($idPadre)
    {   
        $li = '';
        foreach ($this->usuario->permisos as $key=>$value) {
           if ($value['id'] != $idPadre) {
               continue;
           }
           if ($value['nodo_padre'] > 0) {
               $this->obtenerListadoPadre($value['nodo_padre']);
           }
           $li .= $this->elementoHTML($value); break;
        }
        return $li;
    }

    public function elementoHTML($modulo)
    {
        return "<li class='separator'><i class='flaticon-right-arrow'></i></li>                                   
                <li class='nav-item'>
                    <a href='javascript:;'>{$modulo['nombre']}</a>
                </li>";
    }

    public function nombreModulo($controlador, $defaultNombre='Modulo')
    {
        helper('util');
        $nombre = '';
        foreach ($this->usuario->permisos as $key=>$value) {
            if ($value['controlador'] != getNameClass($controlador)) {
                continue;
            }
            $nombre = !empty($value['descripcion']) ? $value['descripcion'] : $defaultNombre; break;
        }
        return $nombre;
    }
}