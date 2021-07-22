<?php 
namespace App\Libraries\Validacion;

class ValidaDocumento
{	
    public $default = [
		'nombre' => [
			'label'=>'Nombre',
            'rules'  => 'required',
            'errors' => [
                'required' => 'El nombre para el documento es requerido.',				
            ]
        ],
        'descripcion'    => [
			'label'=>'Descripción',
            'rules'  => 'required|min_length[8]',
            'errors' => [
                'required' => 'Capture una descripción.',
				'min_length'=>'La Descripción debe contener mínimo 8 caracteres.'
            ]
        ],
        'alias'    => [
			'label'=>'Alias',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Capture un alias para el documento.',				
            ]
        ],
		'cobertura'    => [
			'label'=>'Nivel de Cobertura',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'No se recibió el Identificador del Nivel de Cobertura.',
				'numeric'=>'El Identificador del  Nivel de Cobertura debe ser numérico.'
            ]
        ]
	];

    public $datos = [
        'publicado' => [
			'label'=>'Fecha de Publicación',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Se requiere la Fecha de Publicación.',				
            ]
        ],
        'paginas'    => [
			'label'=>'Número de Páginas',
            'rules'  => 'required|numeric',
            'errors' => [
                'required'=>'Ingrese el Número de Páginas que contiene el documento.',
				'numeric'=>'El campo Número de Páginas debe ser numérico.'
            ]
        ],
        'pais'    => [
			'label'=>'País',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Seleccione un País.',
                'numeric' => 'El Identificador del País debe ser numérico.'				
            ]
        ],
        'institucion'    => [
			'label'=>'Institución / Dependencia',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Seleccione la Institución / Dependencia.',	
                'numeric' => 'El Identificador de la Institución / Dependencia debe ser numérico.'				
            ]
        ],
        'entidad_apf'    => [
			'label'=>'Entidad APF',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Entidad APF.',	
                'numeric' => 'El Identificador de la Entidad APF debe ser numérico.'					
            ]
        ],
        'entidad_r'    => [
			'label'=>'Entidad Responsable',
            'rules'  => 'required|min_length[5]',
            'errors' => [
                'required' => 'Ingrese la Entidad Responsable.',
                'min_length'=> 'El campo Entidad Responsable debe contener mínimo 5 caracteres'				
            ]
        ],
        'instrumento'    => [
			'label'=>'Instrumento Concurrente',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Indique si es un Instrumento Concurrente.',
                'numeric' => 'Elija una opción válida del Instrumento Concurrente.'				
            ]
        ],
        'tipo'    => [
			'label'=>'Tipo',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Seleccione el Tipo de Categoría del Proyecto.',				
            ]
        ],
        'clave'    => [
			'label'=>'Palabras Claves',
            'rules'  => 'required',
            'errors' => [
                'required' => 'No se recibió ninguna palabra clave.',				
            ]
        ],
        'lugar'    => [
			'label'=>'Lugar de Aplicación',
            'rules'  => 'required|min_length[5]',
            'errors' => [
                'required' => 'Ingrese el Lugar de Aplicación.',
                'min_length'=> 'El campo Lugar de Aplicación debe contener mínimo 5 caracteres'					
            ]
        ],
		'id'    => [
			'label'=>'ID Proyecto',
            'rules'  => 'required',
            'errors' => [
                'required' => 'No se recibió el Identificador del Proyecto.',				
            ]
        ]
	];

    public function esSolicitudPlaneacionValida($datos)
    {
        $reglas = $this->obtenerReglas(['publicado','paginas', 'pais', 'institucion', 'entidad_apf', 'entidad_r', 'instrumento','tipo', 'clave', 'lugar', 'id']);

        if (count($reglas)==0) {
            return  ['Solicitud'=>false, 'Error'=>'Validacíón no realizada.'];
        }

        return $this->validar($datos, $reglas);
    }

    public function validar($request, $reglas)
    {
        $validation =  \Config\Services::validation();
        $validation->setRules($reglas);
        $validation->run($request);

        $validacion = [];

        foreach ($reglas as $campo=>$regla) {
            if ($validation->hasError($campo)) {
                $validacion = ['Solicitud'=>false, 'Error'=>$validation->getError($campo)];
                break;
            }
        }

    
        return count($validacion)>0 ? $validacion : ['Solicitud'=>true];
    }

    public function obtenerReglas($reglas)
    {
        $aplicarReglas = [];
        foreach ($reglas as $campo) {

            if (!isset($this->datos[$campo])) {
                continue;
            }
            $aplicarReglas[$campo] = $this->datos[$campo];
        }

        return $aplicarReglas;
    }

}
