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
        'conjunto_datos'    => [
			'label'=>'Conjunto de Datos',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Seleccione el Conjunto de Datos.',	
                'numeric' => 'El Identificador del Conjunto de Datos debe ser numérico.'				
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
        'url'    => [
			'label'=>'Ubicación del archivo',
            'rules'  => 'valid_url',
            'errors' => [
                'valid_url' => 'La ubicación no es una URL válida.',                				
            ]
        ],
		'id'    => [
			'label'=>'ID Proyecto',
            'rules'  => 'required',
            'errors' => [
                'required' => 'No se recibió el Identificador del Proyecto.',				
            ]
        ],
        'autor'    => [
			'label'=>'Autor',
            'rules'  => 'required|min_length[5]',
            'errors' => [
                'required' => 'Ingrese el Autor.',
                'min_length'=> 'El Autor debe contener mínimo 5 caracteres'				
            ]
        ],
        'tema'    => [
			'label'=>'Tema 1',
            'rules'  => 'required|min_length[5]',
            'errors' => [
                'required' => 'Ingrese el Tema 1.',
                'min_length'=> 'El Tema 1 debe contener mínimo 5 caracteres'				
            ]
        ],
        'tema1'    => [
			'label'=>'Tema 1',
            'rules'  => 'required|min_length[5]',
            'errors' => [
                'required' => 'Ingrese el Tema.',
                'min_length'=> 'El Tema debe contener mínimo 5 caracteres'				
            ]
        ],
        'vigencia'    => [
			'label'=>'Vigencia',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Ingrese la vigencia.',
                'numeric' => 'El campo Vigencia debe ser una cantidad numérica.'				
            ]
        ],
        'vigencia_final'    => [
			'label'=>'Instrumento Concurrente',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Ingrese la Vigencia Final.',
                'numeric' => 'El campo Vigencia Final debe ser una cantidad numérica.'			
            ]
        ],
        'armonizado'    => [
			'label'=>'Armonizado a la LGAHOTDU',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Indique si está Armonizado a la LGAHOTDU.',
                'numeric' => 'Elija una opción válida para indicar si está Armonizado a la LGAHOTDU.'				
            ]
        ]
	];

    public function esSolicitudPlaneacionValida($datos)
    {
        $reglas = $this->obtenerReglas(
            ['nombre', 'descripcion', 'alias', 'cobertura','publicado','paginas', 'pais', 'institucion', 'entidad_apf', 'entidad_r', 'instrumento','tipo', 'clave', 'lugar', 'id']
        );

        if (count($reglas)==0) {
            return  ['Solicitud'=>false, 'Error'=>'Validacíón no realizada.'];
        }

        return $this->validar($datos, $reglas);
    }

    public function esSolicitudNormatividadValida($datos)
    {
        $reglas = $this->obtenerReglas(
            ['nombre', 'descripcion', 'alias', 'cobertura','pais', 'idioma', 'institucion', 'entidad_apf', 'instrumento','armonizado', 'tipo', 'clasificacion', 'vigencia', 'vigencia_final','clave', 'lugar', 'id']
        );

        if (count($reglas)==0) {
            return  ['Solicitud'=>false, 'Error'=>'Validacíón no realizada.'];
        }

        return $this->validar($datos, $reglas);
    }

    public function esSolicitudEstadisticaValida($datos)
    {
        $reglas = $this->obtenerReglas(
            ['nombre', 'descripcion', 'alias', 'cobertura','pais', 'tema1', 'institucion', 'entidad_apf', 'instrumento', 'tipo', 'publicado', 'vigencia', 'conjunto_datos', 'unidad','clave', 'lugar', 'id']
        );

        if (count($reglas)==0) {
            return  ['Solicitud'=>false, 'Error'=>'Validacíón no realizada.'];
        }

        return $this->validar($datos, $reglas);
    }

    public function esSolicitudReunionValida($datos)
    {
        $reglas = $this->obtenerReglas(
            ['nombre', 'descripcion', 'alias','pais', 'autor', 'institucion', 'entidad_apf', 'instrumento', 'tipo', 'publicado', 'paginas', 'conjunto_datos','clave', 'lugar', 'id']
        );

        if (count($reglas)==0) {
            return  ['Solicitud'=>false, 'Error'=>'Validacíón no realizada.'];
        }

        return $this->validar($datos, $reglas);
    }

    public function esSolicitudNotaPrensaValida($datos)
    {
        $reglas = $this->obtenerReglas(
            ['nombre', 'descripcion', 'alias', 'cobertura', 'pais', 'idioma', 'tema', 'autor', 'institucion', 'conjunto_datos',  'publicado', 'paginas', 'entidad_apf', 'tipo', 'clave', 'lugar', 'id']
        );

        if (count($reglas)==0) {
            return  ['Solicitud'=>false, 'Error'=>'Validacíón no realizada.'];
        }

        return $this->validar($datos, $reglas);
    }

    public function esSolicitudInvestigacionValida($datos)
    {
        $reglas = $this->obtenerReglas(
            ['nombre', 'descripcion', 'alias', 'cobertura', 'pais', 'idioma', 'tema', 'autor1', 'clasificacion', 'institucion', 'conjunto_datos',  'publicado', 'paginas', 'clave', 'id']
        );

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
        $datos = array_merge($this->default, $this->datos);
        foreach ($reglas as $campo) {

            if (!isset($datos[$campo])) {
                continue;
            }
            $aplicarReglas[$campo] = $datos[$campo];
        }

        return $aplicarReglas;
    }
}
