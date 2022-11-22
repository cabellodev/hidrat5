<?php

function get_rules_substask_create(){
    return array(
        array(
            'field' => 'user_id',
            'rules' => 'required|trim',
            'errors' => array(
                    'required' => 'El ayudante técnico es obligatorio.',
            ),
        ),
        array(
            'field' => 'subtask_id',
            'rules' => 'required|trim',
            'errors' => array(
                    'required' => 'La subtarea es obligatoria.',
            ),
        ),
        array(
            'field' => 'date_assignment',
            'rules' => 'required|trim',
            'errors' => array(
                    'required' => 'La fecha es oblgatoria.',
            ),
        ),
    );

 
}








