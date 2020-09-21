<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-if="locale === 'ro'">
            <p>
                Acesta este un ecran la care poți reveni oricând pentru a afla
                informații utile despre secțiunile, datele și informațiile din
                acest instrument digital. Dacă este prima ta vizită în
                platformă, te rugăm să citești informațiile de mai jos.
            </p>

            <panel title="Definiții">
                <div class="prose max-w-none">
                    <ul>
                        <li>
                            <strong>Finanțator:</strong> orice entitate de tip
                            Fundație, Federație sau Companie care oferă fonduri.
                            În platformă, un finanțator are dreptul de a vedea
                            toate datele încărcate de toți finanțatorii, poate
                            să își administreze propriul cont de finanțator, să
                            adauge, editeze sau șterge granturile alocate și
                            poate să adauge și să aloce manageri de granturi
                            pentru fondurile proprii
                        </li>
                        <li>
                            <strong>Grant manager:</strong> orice entitate
                            juridică alocată de către un finanțator unuia sau
                            mai multor granturi proprii, care are dreptul de a
                            administra granturile, titularii de granturi și
                            proiectele alocate lui.
                        </li>
                        <li>
                            <strong>Grant:</strong> sumă de bani alocată de un
                            finanțator pe unul sau mai multe domenii. Un grant
                            poate avea unul sau multe proiecte beneficiare,
                            respectiv unul sau mai mulți titulari de grant ca
                            beneficiari
                        </li>
                        <li>
                            <strong>Proiect:</strong> o subsecțiune a unui
                            grant. Exemplu: În cadrul grantului ”Adoptă un
                            proiect” există 10 proiecte câștigătoare. Fiecare
                            proiect câștigător poate avea unul sau mai mulți
                            titulari de grant ca beneficiari.
                        </li>
                        <li>
                            <strong>Titular de grant:</strong> organizație, grup
                            informal sau persoană care este beneficiarul
                            finanțării alocate prin intermediul unui grant.
                        </li>
                    </ul>
                </div>
            </panel>

            <panel title="Acțiuni">
                <div class="prose max-w-none">
                    <ul>
                        <li>
                            În secțiunea <strong>Panou de control</strong> vei
                            putea vedea un overview al datelor prezente în
                            platformă: suma totală a granturilor introduse,
                            numărul total de finanțatori precum și un grafic cu
                            ajutorul căruia vei putea compara datele agregate.
                            <strong>Important</strong> suma agregată este
                            exprimată în euro. Granturile alocate pot fi
                            adăugate în platformă în lei, euro sau dolari, iar
                            totalul exprimat în datele agregate se calculează la
                            cursul mediu de schimb valutar al lunii în care a
                            fost alocat grantul.
                        </li>
                        <li>
                            În secțiunea <strong>Finanțatori</strong> vei putea
                            vedea toți finanțatorii prezenți în platformă și vei
                            putea naviga ușor în profilul fiecăruia dintre ei,
                            inclusiv al tău.
                        </li>
                        <li>
                            În secțiunea <strong>Grant managers</strong> vei
                            putea vedea o listă a tuturor managerilor de
                            granturi care sunt alocați pe unul sau mai multe
                            granturi ale finanțatorilor din platformă
                        </li>
                        <li>
                            În secțiunea <strong>Domenii</strong> vei vedea o
                            listă a domeniilor active în acest moment în
                            platformă. Dacă, împreună cu ceilalți finanțatori
                            ajungeți la concluzia că această listă trebuie
                            completată sau modificată, te rugăm să ne transmiți
                            o solicitare pe e-mail.
                        </li>
                        <li>
                            În secțiunea <strong>Granturi</strong> vei putea
                            vedea toate granturile tuturor finanțatorilor din
                            platformă, inclusiv ale tale și vei putea filtra
                            prin domenii, finanțatori sau grant managers.
                        </li>
                        <li>
                            În secțiunea <strong>Titulari</strong> de grant vei
                            putea vedea toate organizațiile beneficiare ale
                            tuturor granturilor din platformă, inclusiv ale
                            tale.
                        </li>
                    </ul>
                </div>
            </panel>

            <panel title="Note">
                <div class="prose max-w-none">
                    <ul>
                        <li>
                            Fiecare grant pe care îl adaugi în platformă poate
                            fi alocat pe unul sau mai multe domenii. Cu toate
                            acestea, în datele agregate el poate fi numărat doar
                            la
                            <strong>o singură categorie principală</strong>
                            pentru a evita duplicarea unor sume. Așadar dacă
                            adaugi un grant pe care îl încadrezi la
                            <em>Educație universitară</em> și <em>STEM</em>,
                            atunci el va fi adăugat ca sumă doar la unul dintre
                            cele două domenii.
                        </li>
                        <li>
                            Pentru a putea adăuga proiecte este necesar ca
                            titularii de grant (organizațiile non-profit) să fie
                            deja
                            <strong
                                >adăugați în lista de Titulari de grant</strong
                            >. Nu vei putea, la acest moment adăuga un nou
                            titular de grant direct în pagina în care adaugi
                            beneficiarii grantului.
                        </li>
                        <li>
                            Dacă ești
                            <strong
                                >Grant Manager și administrezi inclusiv fonduri
                                proprii</strong
                            >, vei avea, la acest moment, două conturi separate
                            - unul de Finanțator și unul de Grant Manager,
                            pentru a putea păstra separarea completă între cele
                            două roluri.
                        </li>
                    </ul>
                </div>
            </panel>
        </template>

        <template v-if="locale === 'en'">
            <p>
                This is a screen that will remain available at any moment for
                you to find out useful information about the sections, data and
                information in this digital instrument. If this is the first
                time you log in the platform, please read the information below.
            </p>

            <panel title="Definitions">
                <div class="prose max-w-none">
                    <ul>
                        <li>
                            <strong>Donor:</strong> every entity registered as a
                            Foundation, Federation or Company that grants
                            funding. In this platform, a donor has the right to
                            see all the data that has been uploaded in the
                            platform by all donors, can manage its own donor
                            account, can add, edit or delete grants and can
                            allocate its own grants to grant managers.
                        </li>
                        <li>
                            <strong>Grant manager:</strong> every entity that
                            has been allocated by a donor to manage one or more
                            grants, who has the right to edit and add projects
                            and beneficiaries in the grants it has rights on.
                        </li>
                        <li>
                            <strong>Grant:</strong> a sum of money allocated by
                            a donor on one or more domains. A grant may have one
                            or more projects and one or more grantees as
                            beneficiaries.
                        </li>
                        <li>
                            <strong>Project:</strong> a subsection of a grant.
                            Example: In the ”Adopt a project” grant there are
                            ten winning projects. Each winning project may have
                            one or more grantees as beneficiaries.
                        </li>
                        <li>
                            <strong>Grantee:</strong> an organisation, informal
                            group or person who is the beneficiary of the
                            funding allocated through a grant.
                        </li>
                    </ul>
                </div>
            </panel>

            <panel title="Actions">
                <div class="prose max-w-none">
                    <ul>
                        <li>
                            In the <strong>Dashboard</strong> section you will
                            be able to see an overview of the data in the
                            platform. The total sum of the grant, total number
                            of donors as well as a chart that helps you compare
                            the aggregated data. <strong>Important</strong> the
                            aggregated sum is expressed in euros. The allocated
                            grants may be added in the platform in lei, dollars
                            or euros, and the aggregated data is calculated
                            considering the median exchange rate of the month
                            when the grant started.
                        </li>
                        <li>
                            In the <strong>Donors</strong> section you will be
                            able to see all the donors in the platform and you
                            will be able to navigate to every donor profile,
                            including yours
                        </li>
                        <li>
                            In the <strong>Grant Managers</strong> section you
                            will be able to see a list of all grant managers who
                            have been allocated on one or more grants by the
                            donors in the platform.
                        </li>
                        <li>
                            In the <strong>Domains</strong> section you will be
                            able to see a list of all currently active domains
                            in the platform. If, together with the other donors,
                            you reach the conclusion that this list needs to be
                            edited or extended, please send us a request via
                            email.
                        </li>
                        <li>
                            In the <strong>Grants</strong> section you will be
                            able to see all the grants of all donors in the
                            platform, including your own and you will be able to
                            filter by domain, donor or grant manager.
                        </li>
                        <li>
                            In the <strong>Grantees</strong> section you will be
                            able to see all the beneficiary organisations of all
                            the grants in the platform, including your own.
                        </li>
                    </ul>
                </div>
            </panel>

            <panel title="Notes">
                <div class="prose max-w-none">
                    <ul>
                        <li>
                            Each grant you add in the platform can be allocated
                            on one or more domains. However, in the aggregated
                            data, the grant can be added only under
                            <strong>one single main category</strong> in order
                            to avoid duplicating the sums. Therefore, if you add
                            a grant that you will mark under
                            <em>University Education</em> and <em>STEM</em>,
                            then the grant will be added as value only under one
                            of the two domains.
                        </li>
                        <li>
                            In order to add projects in grants it is necessary
                            that the
                            <strong>grantees are already added</strong> in the
                            Grantee list. At this moment you cannot add a
                            grantee directly in the page where you add the grant
                            projects and beneficiaries.
                        </li>
                        <li>
                            If you are a
                            <strong
                                >Grant Manager and you also manage owned
                                funds</strong
                            >
                            you will have, at this moment, two separate accounts
                            - a Donor account and Grant Manager account, in
                            order to keep a complete separation between the two
                            roles.
                        </li>
                    </ul>
                </div>
            </panel>
        </template>
    </layout>
</template>

<script>
    import LocaleMixin from '@/mixins/locale';

    export default {
        mixins: [
            //
            LocaleMixin,
        ],
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        computed: {
            pageTitle() {
                let title = {
                    ro: 'Bine ai venit!',
                    en: 'Welcome!',
                };

                return title[this.locale];
            },
            breadcrumbs() {
                return [
                    {
                        label: this.pageTitle,
                        href: null,
                    },
                ];
            },
        },
    };
</script>
