<?php

declare(strict_types=1);

return [

    'all'  => 'All',
    'none' => 'None',

    'menu' => [
        'dashboard'    => 'Panoul de control',
        'users'        => 'Utilizatori',
        'back_to_site' => 'Înapoi la site',
        'settings'     => 'Setări',
    ],

    'action' => [
        'cancel'        => 'Anulează',
        'create'        => 'Adaugă',
        'createModel'   => 'Adaugă :model',
        'delete'        => 'Șterge',
        'deleteConfirm' => 'Sigur vrei să ștergi asta?',
        'deleteModel'   => 'Șterge :model',
        'draft'         => 'Salvează draft',
        'edit'          => 'Editează',
        'editModel'     => 'Editează :model',
        'filter'        => 'Filtrează',
        'publish'       => 'Publică',
        'reset'         => 'Resetează',
        'save'          => 'Salvează',
        'search'        => 'Caută',
        'unpublish'     => 'Unublish',
        'view'          => 'View',
        'viewModel'     => 'View :model',
    ],

    'event' => [
        'created' => ':model a fost creat.',
        'updated' => ':model a fost actualizat.',
        'deleted' => ':model a fost șters.',
        'errors'  => 'Există o eroare în formular.|Există :count erori în formular.',
    ],

    'status' => [
        'draft'     => 'Draft',
        'published' => 'Publicat',
    ],

    'stats' => [
        'donors' => 'Finanțatori înregistrați pe platformă',
        'funding' => 'Euro investiți în :count arii strategice',
        'grantees' => 'Beneficiari susținuți de toți finanțatorii',
        'total' => [
            'grant' => 'Valoarea totală a grantului',
            'grants' => 'Valoarea totală a granturilor',
            'grantees' => 'Numărul total al beneficiarilor',
            'domains' => 'Domenii acoperite',
        ],
    ],

    'view' => [
        'chart' => 'Grafic',
        'table' => 'Tabel',
    ],

    'role' => [
        'admin'   => 'Administrator',
        'user'    => 'Utilizator',
    ],

    'table' => [
        'empty' => 'Nu au fost găsite înregistrări corespunzătoare.',
    ],

    'org_types' => [
        'foundation' => 'Fundație',
        'federation' => 'Federație',
        'company'    => 'Companie',
    ],
];
