<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $signup = [
        'usuario' => [
			'label'=>'Usuario',
            'rules'  => 'required|min_length[8]|is_unique[gp_usuarios.nickname]',
            'errors' => [
                'required' => 'Ingrese el usuario.',
				'min_length'=>'El usuario debe contener mínimo 8 caracteres.'
            ]
        ],
        'password'    => [
			'label'=>'Contraseña',
            'rules'  => 'required|min_length[8]',
            'errors' => [
                'required' => 'Ingrese la contraseña.',
				'min_length'=>'La contraseña debe contener mínimo 8 caracteres.'
            ]
        ],
    ];
	public $signin = [
        'usuario' => [
			'label'=>'Usuario',
            'rules'  => 'required|min_length[8]',
            'errors' => [
                'required' => 'Ingrese el usuario.',
				'min_length'=>'El usuario debe contener mínimo 8 caracteres.'
            ]
        ],
        'password'    => [
			'label'=>'Contraseña',
            'rules'  => 'required|min_length[8]',
            'errors' => [
                'required' => 'Ingrese la contraseña.',
				'min_length'=>'La contraseña debe contener mínimo 8 caracteres.'
            ]
        ],
    ];
	public $contact = [
		'nombre' => [
			'label'=>'Nombre',
            'rules'  => 'required|min_length[3]',
            'errors' => [
                'required' => 'Ingrese el Nombre.',
				'min_length'=>'El Nombre debe contener mínimo 3 caracteres.'
            ]
        ],
        'ap_paterno'    => [
			'label'=>'Apellido Paterno',
            'rules'  => 'required|min_length[3]',
            'errors' => [
                'required' => 'Ingrese el Apellido Paterno.',
				'min_length'=>'El Apellido Paterno debe contener mínimo 3 caracteres.'
            ]
        ],
		'cargo'    => [
			'label'=>'Cargo',
            'rules'  => 'required|min_length[6]',
            'errors' => [
                'required' => 'Ingrese el Cargo.',
				'min_length'=>'El Cargo debe contener mínimo 6 caracteres.'
            ]
        ],
		'estado'    => [
			'label'=>'Estado',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Seleccione el estado.',
				'numeric'=>'No se recibió el identificador del estado.'
            ]
        ],
		'municipio'    => [
			'label'=>'Municipio',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Seleccione el municipio.',
				'numeric'=>'No se recibió el identificador del municipio.'
            ]
        ],
		'puesto'    => [
			'label'=>'Puesto',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Seleccione el puesto.',
				'numeric'=>'No se recibió el identificador del puesto.'
            ]
        ],
	];
}
