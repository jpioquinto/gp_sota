<?php 
namespace App\Libraries\Validacion;

class ValidaAccion
{	
    public $accion = [
		'definicion' => [
			'label'=>'Definición',
            'rules'  => 'required|min_length[5]',
            'errors' => [
                'required' => 'Ingrese la Definición.',
				'min_length'=>'La Definición debe contener mínimo 5 caracteres.'
            ]
        ],
        'descripcion'    => [
			'label'=>'Descripción',
            'rules'  => 'required|min_length[8]',
            'errors' => [
                'required' => 'Ingrese una descripción para la acción.',
				'min_length'=>'La Definición debe contener mínimo 8 caracteres.'
            ]
        ],
		'coordinador'    => [
			'label'=>'Coordinador',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Seleccione el coordinador.',
				'min_length'=>'No se recibió el identificador del coordinador.'
            ]
        ],
		'ponderacion'    => [
			'label'=>'Ponderación',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Ingrese la Ponderación para esta Acción.',
				'numeric'=>'La Ponderación debe ser numérica.'
            ]
        ],
		'orden'    => [
			'label'=>'Orden',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Ingrese el orden en que se posicionará esta acción en el listado.',
				'numeric'=>'El campo Orden debe ser de tipo entero.'
            ]
        ]
	];

    public $subaccion = [
        'accion_id' => [
			'label'=>'Acción General',
            'rules'  => 'required',
            'errors' => [
                'required' => 'No se recibió el Identificador de la Acción General.'				
            ]
        ],
		'definicion' => [
			'label'=>'Definición',
            'rules'  => 'required|min_length[5]',
            'errors' => [
                'required' => 'Ingrese la Definición.',
				'min_length'=>'La Definición debe contener mínimo 5 caracteres.'
            ]
        ],
        'descripcion'    => [
			'label'=>'Descripción',
            'rules'  => 'required|min_length[8]',
            'errors' => [
                'required' => 'Ingrese una descripción para la acción.',
				'min_length'=>'La Definición debe contener mínimo 8 caracteres.'
            ]
        ],
        'programa'    => [
			'label'=>'Programa Ramo',
            'rules'  => 'required|min_length[3]',
            'errors' => [
                'required' => 'Ingrese el Identificador del Programa del Ramo.',
				'min_length'=>'El Identificador debe contener mínimo 3 caracteres.'
            ]
        ],
        'fecha_ini'    => [
			'label'=>'Fecha Inicio',
            'rules'  => 'required|min_length[10]|valid_date[Y-m-d]',
            'errors' => [
                'required' => 'Seleccione la Fecha de Inicio.',
				'min_length'=>'El campo Fecha Inicio debe contener mínimo 10 caracteres.',
                'valid_date'=>'El formato proporcionado para la Fecha de Inicio no es válido.'
            ]
        ],
        'fecha_fin'    => [
			'label'=>'Fecha Fin',
            'rules'  => 'required|min_length[10]|valid_date[Y-m-d]',
            'errors' => [
                'required' => 'Seleccione la Fecha de Finalización.',
				'min_length'=>'El campo Fecha Fin debe contener mínimo 10 caracteres.',
                'valid_date'=>'El formato proporcionado para la Fecha de Finalización no es válido.'
            ]
        ],
		'responsable'    => [
			'label'=>'Responsable',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Seleccione el responsable.',
				'min_length'=>'No se recibió el identificador del responsable.'
            ]
        ],
        'evidencia'    => [
			'label'=>'¿Requiere evidencia?',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Indique si se requiere adjuntar evidencia para esta acción.',
				'numeric'=>'No se ha específicado si se requiere evidencia para esta acción.'
            ]
        ],
        'meta'    => [
			'label'=>'Meta',
            'rules'  => 'required|min_length[15]',
            'errors' => [
                'required' => 'Capture la Meta propuesta para este acción.',
				'min_length'=>'El campo Meta debe contener mínimo 15 caracteres.'
            ]
        ]
	];

    public function esSolicitudAccionValida($datos)
    {
        $validation =  \Config\Services::validation();
        $validation->setRules($this->accion);
        $validation->run($datos);

        if ($validation->hasError('definicion')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('definicion')];
        }
		if ($validation->hasError('descripcion')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('descripcion')];
        }
		if ($validation->hasError('coordinador')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('coordinador')];
        }
		if ($validation->hasError('ponderacion')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('ponderacion')];
        }
		if ($validation->hasError('orden')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('orden')];
        }
        return ['Solicitud'=>true];
    }

    public function esSolicitudSubAccionValida($datos)
    {
        $validation =  \Config\Services::validation();
        $validation->setRules($this->subaccion);
        $validation->run($datos);

        if ($validation->hasError('definicion')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('definicion')];
        }
		if ($validation->hasError('descripcion')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('descripcion')];
        }
		if ($validation->hasError('responsable')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('responsable')];
        }
		if ($validation->hasError('programa')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('programa')];
        }
		if ($validation->hasError('fecha_ini')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('fecha_ini')];
        }
        if ($validation->hasError('fecha_fin')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('fecha_fin')];
        }
        if ($validation->hasError('meta')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('meta')];
        }
        return ['Solicitud'=>true];
    }

}
