<?php 
namespace App\Libraries\Validacion;

class ValidaMedia
{	
    public $imagen = [
		'nombre' => [
			'label'=>'Nombre',
            'rules'  => 'required',
            'errors' => [
                'required' => 'No se asignó el nombre a la imagen.',				
            ]
        ],
        'descripcion'    => [
			'label'=>'Descripción',
            'rules'  => 'required|min_length[8]',
            'errors' => [
                'required' => 'Ingrese una descripción para la esta imagen.',
				'min_length'=>'La Definición debe contener mínimo 8 caracteres.'
            ]
        ],
        'ruta'    => [
			'label'=>'Directorio',
            'rules'  => 'required',
            'errors' => [
                'required' => 'No se asignó un directorio para la imagen.',				
            ]
        ],
		'proyecto_id'    => [
			'label'=>'ID Proyecto',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'No se recibió el Identificador del Proyecto.',
				'numeric'=>'El Identificador del Proyecto de ser numérico.'
            ]
        ]
	];

    public $video = [
        'nombre' => [
			'label'=>'Nombre',
            'rules'  => 'required',
            'errors' => [
                'required' => 'No se asignó el nombre del video.',				
            ]
        ],
        'descripcion'    => [
			'label'=>'Descripción',
            'rules'  => 'required|min_length[8]',
            'errors' => [
                'required' => 'Ingrese una descripción para la este video.',
				'min_length'=>'La Definición debe contener mínimo 8 caracteres.'
            ]
        ],
        'ruta'    => [
			'label'=>'Directorio',
            'rules'  => 'required',
            'errors' => [
                'required' => 'No se asignó un directorio para el video.',				
            ]
        ],
		'proyecto_id'    => [
			'label'=>'ID Proyecto',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'No se recibió el Identificador del Proyecto.',
				'numeric'=>'El Identificador del Proyecto de ser numérico.'
            ]
        ]
	];

    public function esSolicitudImagenValida($datos)
    {
        $validation =  \Config\Services::validation();
        $validation->setRules($this->imagen);
        $validation->run($datos);

        if ($validation->hasError('nombre')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('nombre')];
        }
		if ($validation->hasError('descripcion')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('descripcion')];
        }
		if ($validation->hasError('ruta')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('ruta')];
        }
		if ($validation->hasError('proyecto_id')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('proyecto_id')];
        }
        return ['Solicitud'=>true];
    }

    public function esSolicitudVideoValida($datos)
    {
        $validation =  \Config\Services::validation();
        $validation->setRules($this->video);
        $validation->run($datos);

        if ($validation->hasError('nombre')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('nombre')];
        }
		if ($validation->hasError('descripcion')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('descripcion')];
        }
		if ($validation->hasError('ruta')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('ruta')];
        }
		if ($validation->hasError('proyecto_id')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('proyecto_id')];
        }
        return ['Solicitud'=>true];
    }

}
