<?php

declare(strict_types=1);

return [
    'menu' => [
        'dashboard'    => 'Dashboard',
        'users'        => 'User management',
        'back_to_site' => 'Back to site',
    ],

    'action' => [
        'cancel'    => 'Cancel',
        'create'    => 'Create :model',
        'delete'    => 'Delete :model',
        'draft'     => 'Create draft',
        'edit'      => 'Edit :model',
        'publish'   => 'Publish',
        'unpublish' => 'Unublish',
        'save'      => 'Save',
    ],

    'event' => [
        'created' => ':model created.',
        'updated' => ':model updated.',
        'deleted' => ':model deleted.',
        'errors'  => 'There is one form error.|There are :count form errors.',
    ],

    'field' => [
        'currency'              => 'Currency',
        'domains'               => 'Domains',
        'email'                 => 'Email address',
        'first_name'            => 'First name',
        'hq'                    => 'HQ',
        'last_name'             => 'Last name',
        'logo'                  => 'Logo',
        'managed'               => 'Managed by a grant manager',
        'name'                  => 'Name',
        'other'                 => 'Other',
        'password_confirmation' => 'Password confirmation',
        'password'              => 'Password',
        'phone'                 => 'Phone',
        'published_status'      => 'Status',
        'regranting_value'      => 'Regranting value',
        'role'                  => 'Role',
        'roleLabel'             => 'Role',
        'type'                  => 'Type',
    ],

    'model' => [
        'donor' => [
            'singular' => 'Donor',
            'plural'   => 'Donors',

            'section' => [
                'organization' => [
                    'title' => 'Organization',
                    'description' => 'Iste et quisquam enim aut error aut. A quidem quas. Ex tenetur id nesciunt eligendi tenetur ut. Porro esse vero adipisci qui est. Ipsam ab non aut. Suscipit nulla est sed et enim illo eos.',
                ],
                'contact' => [
                    'title' => 'Contact person',
                    'description' => 'Podit aut debitis et cum exercitationem. Officiis esse impedit est sunt non. Laboriosam reiciendis optio sapiente quaerat illum est mollitia.',
                ],
            ],
        ],
        'domain' => [
            'singular' => 'Domain',
            'plural'   => 'Domains',

            'section' => [
                'title' => 'Lorem ipsum',
                'description' => 'Iste et quisquam enim aut error aut. A quidem quas. Ex tenetur id nesciunt eligendi tenetur ut. Porro esse vero adipisci qui est. Ipsam ab non aut. Suscipit nulla est sed et enim illo eos.',
            ],
        ],
        'grant' => [
            'singular' => 'Grant',
            'plural'   => 'Grants',

            'section' => [
                'info' => [
                    'title' => 'Grant',
                    'description' => 'Iste et quisquam enim aut error aut. A quidem quas. Ex tenetur id nesciunt eligendi tenetur ut. Porro esse vero adipisci qui est. Ipsam ab non aut. Suscipit nulla est sed et enim illo eos.',
                ],
                'donors' => [
                    'title' => 'Donors',
                    'description' => 'Iste et quisquam enim aut error aut. A quidem quas. Ex tenetur id nesciunt eligendi tenetur ut. Porro esse vero adipisci qui est. Ipsam ab non aut. Suscipit nulla est sed et enim illo eos.',
                ],
                'manager' => [
                    'title' => 'Grant manager',
                    'description' => 'Iste et quisquam enim aut error aut. A quidem quas. Ex tenetur id nesciunt eligendi tenetur ut. Porro esse vero adipisci qui est. Ipsam ab non aut. Suscipit nulla est sed et enim illo eos.',
                ],
            ],
        ],
        'grantee' => [
            'singular' => 'Grantee',
            'plural'   => 'Grantees',

            'section' => [
                'title' => 'Lorem ipsum',
                'description' => 'Iste et quisquam enim aut error aut. A quidem quas. Ex tenetur id nesciunt eligendi tenetur ut. Porro esse vero adipisci qui est. Ipsam ab non aut. Suscipit nulla est sed et enim illo eos.',
            ],
        ],
        'user' => [
            'singular' => 'User',
            'plural'   => 'Users',

            'section' => [
                'title' => 'Lorem ipsum',
                'description' => 'Iste et quisquam enim aut error aut. A quidem quas. Ex tenetur id nesciunt eligendi tenetur ut. Porro esse vero adipisci qui est. Ipsam ab non aut. Suscipit nulla est sed et enim illo eos.',
            ],
        ],
    ],

    'status' => [
        'draft'     => 'Draft',
        'published' => 'Published',
    ],

    'stats' => [
        'donors' => 'Donors registered on the platform',
        'funding' => 'Euros invested in :count strategic areas',
        'grantees' => 'Grantees supported by all donors',
    ],

    'role' => [
        'admin'   => 'Administrator',
        'donor'   => 'Donor',
        'manager' => 'Grant manager',
    ],
];
