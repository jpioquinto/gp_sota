<?php 
namespace App\Libraries\Validacion;

class ValidaUR
{	
    public $ur = [
		'nombre' => [
			'label'=>'Nombre',
            'rules'  => 'required|min_length[5]',
            'errors' => [
                'required' => 'Ingrese el Nombre de la UR.',
				'min_length'=>'El nombre debe contener mínimo 5 caracteres.'
            ]
        ],
        'sigla'    => [
			'label'=>'SIGLA',
            'rules'  => 'required',
            'errors' => [
                'required' => 'El campo SIGLA es obligatorio.'
            ]
        ],
		'entidad'    => [
			'label'=>'Entidad',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'No se recibió el Identificador de la Entidad.',
				'numeric'=>'El Identificador de la Entidad debe ser un dato numérico.'
            ]
        ],
		'municipio'    => [
			'label'=>'Del. / Munpio.',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'No se recibió el Identificador de la Del. / Munpio.',
				'numeric'=>'El Identificador de la Del. / Munpio. debe ser un dato numérico.'
            ]
        ]
	];

    public function esSolicitudValida($datos)
    {
        $validation =  \Config\Services::validation();
        $validation->setRules($this->ur);
        $validation->run($datos);

        if ($validation->hasError('nombre')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('nombre')];
        }
		if ($validation->hasError('sigla')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('sigla')];
        }
		if ($validation->hasError('entidad')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('entidad')];
        }
		if ($validation->hasError('municipio')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('municipio')];
        }
        return ['Solicitud'=>true];
    }
}
