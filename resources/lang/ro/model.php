<?php

declare(strict_types=1);

return [

    'donor' => [
        'singular' => 'Finanțator',
        'plural'   => 'Finanțatori',

        'section' => [
            'organization' => [
                'title' => 'Organizație',
                'description' => '',
            ],
            'contact' => [
                'title' => 'Persoană de contact',
                'description' => '',
            ],
        ],
    ],
    'domain' => [
        'singular' => 'Domeniu',
        'plural'   => 'Domenii',

        'section' => [
            'title' => 'Domeniu',
            'description' => '',
        ],
    ],
    'grant' => [
        'singular' => 'Grant',
        'plural'   => 'Granturi',

        'section' => [
            'info' => [
                'title' => 'Grant',
                'description' => 'Un grant este o sumă de bani alocată pentru unul sau mai multe domenii. Un grant poate avea unul sau multe proiecte beneficiare, respectiv unul sau mai multi titulari de grant ca beneficiari. De exemplu dacă ai un grant pe care îl aloci printr-un call de finanțare către mai multe organizații câștigătoare, în acest ecran trebuie să introduci numele grantului, domeniul și valoarea sa totală. Organizațiile și proiectele cu care au câștigat finanțare în cadrul acestui grant le vei adăuga în pasul următor.',
            ],
            'donors' => [
                'title' => 'Finanțatori',
                'description' => '',
            ],
            'manager' => [
                'title' => 'Grant manager',
                'description' => '',
            ],
        ],
    ],
    'grantee' => [
        'singular' => 'Titular de grant',
        'plural'   => 'Titulari de grant',

        'section' => [
            'title' => 'Titular de grant',
            'description' => 'Titularul de grant este o organizație, un grup informal sau o persoană care este beneficiarul finanțării alocate prin intermediul unui grant. Pentru a intorduce granturi în platformă și a le aloca unuia sau mai multpr titulari de grant, trebuie ca titularii să fie adăugați la acest pas în proces. ',
        ],
    ],
    'manager' => [
        'singular' => 'Grant manager',
        'plural'   => 'Grant managers',

        'section' => [
            'organization' => [
                'title' => 'Organizație',
                'description' => '',
            ],
            'contact' => [
                'title' => 'Persoană de contact',
                'description' => '',
            ],
        ],
    ],
    'project' => [
        'singular' => 'Proiect',
        'plural'   => 'Proiecte',

        'section' => [
            'info' => [
                'title' => 'Proiecte',
                'description' => 'Un proiect este o subsecțiune a unui grant. Un grant poate fi acordat unuia sau mai multor proiecte. Exemplu: În cadrul grantului ”Adoptă un proiect” există 10 proiecte câștigătoare. Fiecare proiect câștigător poate avea unul sau mai mulți titulari de grant ca beneficiari.',
            ],
            'grantees' => [
                'title' => 'Titulari de grant',
                'description' => 'Pentru a putea aloca un proiect unui titular de grant este necesar ca acesta să fie deja adăugat în lista de Titulari de grant. Dacă nu găsești în listă titularul de grant atunci te rog să îl adaugi și să revii în acest ecran.',
            ],
        ],
    ],
    'user' => [
        'singular' => 'Utilizator',
        'plural'   => 'Utilizatori',

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
