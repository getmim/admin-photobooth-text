<?php

return [
    '__name' => 'admin-photobooth-text',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/admin-photobooth-text.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/admin-photobooth-text' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'admin' => NULL
            ],
            [
                'admin-photobooth' => NULL
            ],
            [
                'photobooth-text' => NULL
            ],
            [
                'lib-form' => NULL
            ],
            [
                'lib-sms' => NULL
            ]
        ],
        'optional' => [
            [
                'lib-shorturl' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'AdminPhotoboothText\\Controller' => [
                'type' => 'file',
                'base' => 'modules/admin-photobooth-text/controller'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'admin' => [
            'adminPhotoboothPreText' => [
                'path' => [
                    'value' => '/photobooth/(:id)/text',
                    'params' => [
                        'id'  => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'AdminPhotoboothText\\Controller\\Text::text'
            ],
            'adminPhotoboothText' => [
                'path' => [
                    'value' => '/photobooth/(:id)/text',
                    'params' => [
                        'id'  => 'number'
                    ]
                ],
                'method' => 'POST',
                'handler' => 'AdminPhotoboothText\\Controller\\Text::send'
            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'admin.photobooth.sms' => [
                'content' => [
                    'label' => 'Text',
                    'type' => 'textarea',
                    'nolabel' => true,
                    'rules' => [
                        'required' => true,
                        'empty' => false
                    ]
                ]
            ]
        ]
    ],
    'adminPhotoBoothText' => [
        'text' => 'Please download your images on (:url)'
    ]
];