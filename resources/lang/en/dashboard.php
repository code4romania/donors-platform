<?php

declare(strict_types=1);

return [

    'all'  => 'All',
    'none' => 'None',

    'menu' => [
        'dashboard'    => 'Dashboard',
        'users'        => 'User management',
        'back_to_site' => 'Back to site',
        'settings'     => 'Settings',
    ],

    'action' => [
        'cancel'        => 'Cancel',
        'create'        => 'Add',
        'createModel'   => 'Add :model',
        'delete'        => 'Delete',
        'deleteConfirm' => 'Are you sure you want to delete this?',
        'deleteModel'   => 'Delete :model',
        'draft'         => 'Save draft',
        'edit'          => 'Edit',
        'editModel'     => 'Edit :model',
        'filter'        => 'Filter',
        'publish'       => 'Publish',
        'reset'         => 'Reset',
        'save'          => 'Save',
        'search'        => 'Search',
        'unpublish'     => 'Unublish',
        'view'          => 'View',
        'viewModel'     => 'View :model',
    ],

    'event' => [
        'created' => ':model created.',
        'updated' => ':model updated.',
        'deleted' => ':model deleted.',
        'errors'  => 'There is one form error.|There are :count form errors.',
    ],

    'status' => [
        'draft'     => 'Draft',
        'published' => 'Published',
    ],

    'stats' => [
        'donors' => 'Donors registered on the platform',
        'funding' => 'Euros invested in :count strategic areas',
        'grantees' => 'Grantees supported by all donors',
        'total' => [
            'grant' => 'Total value of grant',
            'grants' => 'Total value of grants',
            'grantees' => 'Total number of grantees',
            'domains' => 'Domains covered',
        ],
    ],

    'view' => [
        'chart' => 'Graph view',
        'table' => 'Table view',
    ],

    'permission' => [
        'view'   => 'View',
        'create' => 'Create',
        'edit'   => 'Edit',
        'delete' => 'Delete',
    ],

    'role' => [
        'admin'   => 'Administrator',
        'user'    => 'User',
    ],

    'table' => [
        'empty' => 'No matching records found.',
    ],

    'org_types' => [
        'foundation' => 'Foundation',
        'federation' => 'Federation',
        'company'    => 'Company',
    ],
];
