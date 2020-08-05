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
        'areas'                 => 'Areas under focus',
        'email'                 => 'Email address',
        'first_name'            => 'First name',
        'hq'                    => 'HQ',
        'last_name'             => 'Last name',
        'logo'                  => 'Logo',
        'name'                  => 'Name',
        'name'                  => 'Name',
        'other'                 => 'Other',
        'password_confirmation' => 'Password confirmation',
        'password'              => 'Password',
        'phone'                 => 'Phone',
        'published_status'      => 'Status',
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
        'focusArea' => [
            'singular' => 'Focus Area',
            'plural'   => 'Focus Areas',

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

    'role' => [
        'admin'   => 'Administrator',
        'donor'   => 'Donor',
        'manager' => 'Grant manager',
    ],
];
