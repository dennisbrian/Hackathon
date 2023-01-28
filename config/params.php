<?php
return [
    'localDomain'  => 'http://localhost/web/',
    'company_name' =>  "",
    'company_logo' =>  "",
    'company_login'=>  "",
    'email_footer' =>  "",
    'links'        =>  "",
    's3_bucket'    => '',
    'denyDomains' => [
        'yopmail.com',
        'bccto.me',
    ],
    'hail812/yii2-adminlte3' => [
        'pluginMap' => [
            'sweetalert2' => [
                'css' => 'sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                'js' => 'sweetalert2/sweetalert2.min.js'
            ],
            'toastr' => [
                'css' => ['toastr/toastr.min.css'],
                'js' => ['toastr/toastr.min.js']
            ],
        ]
    ],
    's3_presigned_expire_second' => '10',
];
