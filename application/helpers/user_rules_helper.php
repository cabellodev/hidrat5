<?php

function get_rules_user_create(){
    return array(
        array(
                'field' => 'rut',
                'label' => 'rut',
                'rules' => 'required|trim|min_length[11]',
                'errors' => array(
                    'required' => 'El rut del usuario es requerido.',
                    'min_length' => 'El campo rut necesita mínimo 8 dígitos.',
                ),
        ),
        array(
                'field' => 'full_name',
                'label' => 'Nombre',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El nombre del usuario es requerido.',
                ),
        ),
        array(
                'field' => 'email',
                'label' => 'Correo electrónico',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'El correo electrónico es requerido.',
                    'valid_email' => 'La dirección de correo electrónico debe seguir el formato ejemplo@gmail.com'
                ),
        ),
        array(
                'field' => 'passwd',
                'label' => 'Contraseña',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'La contraseña es requerida.',
                ),
        ),
        array(
                'field' => 'range',
                'label' => 'Rango',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El privilegio del nuevo usuario es requerido.',
                ),
        ),
    );
}

function get_rules_user_edit(){
        return array(
            array(
                    'field' => 'rut',
                    'label' => 'rut',
                    'rules' => 'required|trim',
                    'errors' => array(
                        'required' => 'El rut del usuario es requerido.',
                    ),
            ),
            array(
                    'field' => 'full_name',
                    'label' => 'Nombre',
                    'rules' => 'required|trim',
                    'errors' => array(
                            'required' => 'El nombre del usuario es requerido.',
                    ),
            ),
            array(
                    'field' => 'email',
                    'label' => 'Correo electrónico',
                    'rules' => 'required|trim|valid_email',
                    'errors' => array(
                        'required' => 'El correo electrónico es requerido.',
                        'valid_email' => 'La dirección de correo electrónico debe incluir el carácter @ (ejemplo@gmail.com)'
                    ),
            ),
            array(
                    'field' => 'range',
                    'label' => 'Rango',
                    'rules' => 'required|trim',
                    'errors' => array(
                            'required' => 'El privilegio del nuevo usuario es requerido.',
                    ),
            ),
        );
    }