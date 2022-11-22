<?php

function get_rules_ot_create(){
    return array(
        array(
                'field' => 'ot_number',
                'label' => 'Numero de OT',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'El número de OT es requerido.',
                ),
        ),
        array(
                'field' => 'enterprise',
                'label' => 'Empresa',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'La empresa es requerido.',
                ),
        ),
        array(
                'field' => 'service',
                'label' => 'Tipo de servicio',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El tipo de servicio es requerido.',
                ),
        ),

        array(
                'field' => 'component',
                'label' => 'Componente',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'El componente es requerido.',
                ),
        ),

        array(
                'field' => 'priority',
                'label' => 'Prioridad',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'La prioridad es requerida.',
                ),
        ),

        array(
                'field' => 'date_admission',
                'label' => 'Fecha de ingreso',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'La fecha de ingreso es requerida.',
                ),
        ),

        array(
                'field' => 'days_quotation',
                'label' => 'Días para cotizar',
                'rules' => 'required|trim',
                'errors' => array(
                        'required' => 'Los días para cotizar son requeridos.',
                ),
        ),
    );
}
