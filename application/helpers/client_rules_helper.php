<?php

function get_rules_client_create(){
    return array(
        array(
                'field' => 'full_name',
                'label' => 'Nombre',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El nombre del cliente es requerido.',
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
                        'required' => 'El privilegio del nuevo cliente es requerido.',
                ),
        ),
        array(
                'field' => 'enterprise',
                'label' => 'Empresa',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'La empresa del nuevo cliente es requerida.',
                ),
        ),
        array(
                'field' => 'seller',
                'label' => 'Vendedor',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El vendedor asignado al nuevo cliente es requerido.',
                ),
        ),
    );
}

function get_rules_client_edit(){
        return array(
            array(
                    'field' => 'full_name',
                    'label' => 'Nombre',
                    'rules' => 'required|trim',
                    'errors' => array(
                            'required' => 'El nombre del cliente es requerido.',
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
                            'required' => 'El privilegio del nuevo cliente es requerido.',
                    ),
            ),
            array(
                'field' => 'enterprise',
                'label' => 'Empresa',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'La empresa del nuevo cliente es requerida.',
                ),
            ),
        );
    }