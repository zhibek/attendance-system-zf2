<?php
return array(
    'doctrine' => array(
        'driver' => array(
            'attendance_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../../library/Attendance/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Attendance\Entity' => 'attendance_entities'
                ),
            ),
        ),
    ),
);