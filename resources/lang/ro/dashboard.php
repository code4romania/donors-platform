<?php

declare(strict_types=1);

return [

    'all'  => 'Toate',
    'none' => 'Niciunul',
    'back' => 'Înapoi',

    'own_profile' => 'Profilul meu',

    'menu' => [
        'dashboard'    => 'Panoul de control',
        'help'         => 'Ghid',
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
        'reset'         => 'Resetează filtrele',
        'save'          => 'Salvează',
        'search'        => 'Caută',
        'unpublish'     => 'Unublish',
        'view'          => 'Vizualizează',
        'viewModel'     => 'Vizualizează :model',
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
            'regranting' => 'Valoarea de regranting',
            'operational' => 'Costuri operaționale',
            'remaining' => 'Valoare neutilizată',
        ],
    ],

    'view' => [
        'chart' => 'Grafic',
        'table' => 'Tabel',
    ],

    'chart' => [
        'title' => 'Date disponibile',
        'help'  => 'Pentru a compara două sau mai multe domenii între ele, apasă pe denumirile domeniilor din legendă pentru a le activa sau dezactiva.',
    ],

    'filter' => [
        'year'   => 'Filtrează după an',
        'domain' => 'Filtrează după domeniu',
        'donor'  => 'Filtrează după finanțator',
    ],

    'permission' => [
        'view'   => 'Vizualizare',
        'create' => 'Creare',
        'edit'   => 'Editare',
        'delete' => 'Ștergere',
    ],

    'role' => [
        'admin'   => 'Administrator',
        'donor'   => 'Finanțator',
        'manager' => 'Grant manager',
        'analyst' => 'Analist',
    ],

    'table' => [
        'empty' => 'Nu au fost găsite înregistrări corespunzătoare.',
    ],

    'org_type' => [
        'foundation' => 'Fundație',
        'federation' => 'Federație',
        'company'    => 'Companie',
    ],

    'help' => [
        'numbers_only' => 'doar cifre',
    ],
];
