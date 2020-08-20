<?php

declare(strict_types=1);

return [

    'menu' => [
        'dashboard'    => 'Dashboard',
        'users'        => 'User management',
        'back_to_site' => 'Back to site',
    ],

    'action' => [
        'cancel'        => 'Cancel',
        'create'        => 'Create',
        'createModel'   => 'Create :model',
        'delete'        => 'Delete',
        'deleteConfirm' => 'Are you sure you want to delete this?',
        'deleteModel'   => 'Delete :model',
        'draft'         => 'Save draft',
        'edit'          => 'Edit',
        'editModel'     => 'Edit :model',
        'publish'       => 'Publish',
        'save'          => 'Save',
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
    ],

    'view' => [
        'chart' => 'Graph view',
        'table' => 'Table view',
    ],

    'role' => [
        'admin'   => 'Administrator',
        'donor'   => 'Donor',
        'manager' => 'Grant manager',
    ],

    'table' => [
        'empty' => 'No matching records found.',
    ],
];
