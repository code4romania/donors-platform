<?php

declare(strict_types=1);

return [

    'all'  => 'All',
    'none' => 'None',
    'back' => 'Back',

    'own_profile' => 'My profile',

    'menu' => [
        'dashboard'    => 'Dashboard',
        'help'         => 'Guide',
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
        'reset'         => 'Reset filters',
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
            'regranting' => 'Regranting value',
            'operational' => 'Operational costs',
        ],
    ],

    'view' => [
        'chart' => 'Graph view',
        'table' => 'Table view',
    ],

    'chart' => [
        'title' => 'Available data',
        'help'  => 'In order to compare one or more domains, click on the domain names in the legend to activate or deactivate them.',
    ],

    'filter' => [
        'year'   => 'Filter by year',
        'domain' => 'Filter by domain',
        'donor'  => 'Filter by donor',
    ],

    'permission' => [
        'view'   => 'View',
        'create' => 'Create',
        'edit'   => 'Edit',
        'delete' => 'Delete',
    ],

    'role' => [
        'admin'   => 'Administrator',
        'donor'   => 'Donor',
        'manager' => 'Grant manager',
        'user'    => 'User',
    ],

    'table' => [
        'empty' => 'No matching records found.',
    ],

    'org_type' => [
        'foundation' => 'Foundation',
        'federation' => 'Federation',
        'company'    => 'Company',
    ],
];
