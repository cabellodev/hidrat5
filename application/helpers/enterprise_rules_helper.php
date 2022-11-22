<?php

function get_rules_enterprise(){
    return array(
        array(
                'field' => 'rut',
                'label' => 'rut',
                'rules' => 'required|trim|min_length[11]',
                'errors' => array(
                    'required' => 'El Rut de la empresa es requerido.',
                    'min_length' => 'El campo rut necesita mínimo 8 dígitos.',
                ),
        ),
        array(
                'field' => 'name',
                'label' => 'Nombre',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El nombre de la empresa es requerido.',
                ),
        ),
    );
}