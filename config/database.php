<?php
return array(

    'default' => 'mysql',

    'connections' => array(

        # Our primary database connection
        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'serteza.com',
            'database'  => 'sertezac_nutricion',
            'username'  => 'sertezac',
            'password'  => '5erte34?crh',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

        # Our secondary database connection
        'mysql2' => array(
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => 's',
            'username'  => 'user2',
            'password'  => 'pass2',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),
    ),
);