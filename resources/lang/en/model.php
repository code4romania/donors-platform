<?php

declare(strict_types=1);

return [

    'donor' => [
        'singular' => 'Donor',
        'plural'   => 'Donors',

        'own' => 'My donors',

        'section' => [
            'organization' => [
                'title' => 'Organization',
                'description' => '',
            ],
            'contact' => [
                'title' => 'Contact person',
                'description' => '',
            ],
        ],
    ],
    'domain' => [
        'singular' => 'Domain',
        'plural'   => 'Domains',

        'own' => 'My domains',

        'section' => [
            'title' => 'Domain',
            'description' => '',
        ],
    ],
    'grant' => [
        'singular' => 'Grant',
        'plural'   => 'Grants',

        'own' => 'My grants',

        'section' => [
            'info' => [
                'title' => 'Grant',
                'description' => 'A grant is a sum of money allocated on one or more domains. A grant may have one or more projects and one or more grantees as beneficiaries. For example, if you have a grant that you will allocate through an open call for proposals to multiple winning organisations, in this screen you will have to input the grant name, the domain and its total value. The organisations and the projects they won the call with will be added in the next screen.',
            ],
            'donors' => [
                'title' => 'Donors',
                'description' => '',
            ],
            'manager' => [
                'title' => 'Grant manager',
                'description' => '',
            ],
        ],
    ],
    'grantee' => [
        'singular' => 'Grantee',
        'plural'   => 'Grantees',

        'own' => 'My grantees',

        'section' => [
            'title' => 'Grantee',
            'description' => 'A grantee is an organisation, an informal group or a person who is the beneficiary of the funding allocated through a grant. In order to input grants in the platform and to allocate them to one or more grantees you need to add the grantees here, at this step of the process.',
        ],
    ],
    'manager' => [
        'singular' => 'Grant manager',
        'plural'   => 'Grant managers',

        'own' => 'My grant managers',

        'section' => [
            'organization' => [
                'title' => 'Organization',
                'description' => '',
            ],
            'contact' => [
                'title' => 'Contact person',
                'description' => '',
            ],
        ],
    ],
    'project' => [
        'singular' => 'Project',
        'plural'   => 'Projects',

        'own' => 'My projects',

        'section' => [
            'info' => [
                'title' => 'Projects',
                'description' => 'A project is a subsection of a grant. A grant may be given to one or more projects. Example: In the ”Adopt a project” grant there are ten winning projects. Each winning project may have one or more grantees as beneficiaries. ',
            ],
            'grantees' => [
                'title' => 'Grantee',
                'description' => 'In order to connect a project to a grantee it is necessary that the grantee is already added in the Grantee list. If you can not find the grantee in the list then please add the grantee and come back to this screen.',
            ],
        ],
    ],
    'user' => [
        'singular' => 'User',
        'plural'   => 'Users',

        'own' => 'My users',

        'section' => [
            'info' => [
                'title' => 'Lorem ipsum',
                'description' => 'Iste et quisquam enim aut error aut. A quidem quas. Ex tenetur id nesciunt eligendi tenetur ut. Porro esse vero adipisci qui est. Ipsam ab non aut. Suscipit nulla est sed et enim illo eos.',
            ],
            'permissions' => [
                'title' => 'Lorem ipsum',
                'description' => 'Iste et quisquam enim aut error aut. A quidem quas. Ex tenetur id nesciunt eligendi tenetur ut. Porro esse vero adipisci qui est. Ipsam ab non aut. Suscipit nulla est sed et enim illo eos.',
            ],
        ],
    ],

];
