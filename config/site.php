<?php

/*
|--------------------------------------------------------------------------
| Contenu éditorial & SEO
|--------------------------------------------------------------------------
|
| Prestations, zones d'intervention et FAQ. Ce fichier est la source unique :
| il alimente à la fois les pages (via Inertia), les données structurées
| JSON-LD et le sitemap.xml.
|
*/

return [

    /*
    |----------------------------------------------------------------------
    | Prestations
    |----------------------------------------------------------------------
    | Trois familles, affichées dans l'ordre de 'families' : 'entreprise',
    | 'maison' (libellé « Privé ») et 'ponctuel'. Le champ 'family'
    | sert au regroupement à l'écran et dans le sélecteur du formulaire ; le
    | reste du site (JSON-LD, pages locales) consomme la liste à plat.
    |
    | 'icon' correspond à un composant lucide-vue-next.
    */
    'families' => [
        'entreprise' => [
            'label' => 'En entreprise',
            'lead' => 'Bureaux, commerces et immeubles, en contrat régulier et en dehors de vos heures d\'activité, pour ne pas déranger le personnel.',
        ],
        'maison' => [
            'label' => 'Privé',
            'lead' => 'Votre maison ou votre appartement, entretenu au rythme qui vous convient.',
        ],
        'ponctuel' => [
            'label' => 'Travaux ponctuels',
            'lead' => 'Une remise en état, un chantier qui se termine, des surfaces difficiles d\'accès.',
        ],
    ],

    'services' => [
        [
            'slug' => 'menage-regulier',
            'family' => 'maison',
            'icon' => 'Home',
            'title' => 'Ménage régulier',
            'short' => 'Chaque semaine ou toutes les deux semaines',
            'text' => 'Poussières, sols, cuisine et salle de bain, au rythme que vous choisissez. La même personne revient à chaque passage et connaît votre intérieur.',
        ],
        [
            'slug' => 'grand-nettoyage',
            'family' => 'maison',
            'icon' => 'Sparkles',
            'title' => 'Grand nettoyage',
            'short' => 'De fond en comble, une fois ou à chaque saison',
            'text' => 'Derrière les meubles, plinthes, portes, intérieur des armoires, four et hotte : tout ce que le ménage courant ne touche pas.',
        ],
        [
            'slug' => 'vitres-verandas',
            'family' => 'maison',
            'icon' => 'Frame',
            'title' => 'Vitres et vérandas',
            'short' => 'Fenêtres, baies, châssis et toitures vitrées',
            'text' => 'Vitres lavées à l\'eau osmosée, intérieur et extérieur, châssis et appuis compris. Les toitures de véranda se font à la perche, depuis le sol.',
        ],
        [
            'slug' => 'fin-de-bail',
            'family' => 'maison',
            'icon' => 'KeyRound',
            'title' => 'Fin de bail et déménagement',
            'short' => 'Avant l\'état des lieux de sortie',
            'text' => 'Le logement est rendu propre pièce par pièce : sols, sanitaires, cuisine, vitres intérieures et placards vidés.',
        ],
        [
            'slug' => 'entretien-bureaux',
            'family' => 'entreprise',
            'icon' => 'Briefcase',
            'title' => 'Entretien de bureaux',
            'short' => 'Postes de travail, salles de réunion, poubelles',
            'text' => 'Passage quotidien, hebdomadaire ou selon votre rythme, tôt le matin ou en soirée pour ne déranger personne.',
        ],
        [
            'slug' => 'commerces-vitrines',
            'family' => 'entreprise',
            'icon' => 'Store',
            'title' => 'Commerces et vitrines',
            'short' => 'Devanture et surface de vente',
            'text' => 'Vitrine, sol et comptoir prêts avant l\'ouverture. En passage ponctuel ou en contrat hebdomadaire, bimensuel ou mensuel.',
        ],
        [
            'slug' => 'parties-communes',
            'family' => 'entreprise',
            'icon' => 'Building',
            'title' => 'Immeubles et parties communes',
            'short' => 'Halls, escaliers, ascenseurs',
            'text' => 'Entretien des halls d\'entrée, cages d\'escalier, ascenseurs et couloirs, pour les syndics, les gestionnaires et les copropriétés.',
        ],
        [
            'slug' => 'sanitaires-cuisines',
            'family' => 'entreprise',
            'icon' => 'SprayCan',
            'title' => 'Sanitaires et cuisines',
            'short' => 'Désinfection et réapprovisionnement',
            'text' => 'Toilettes, lavabos, coins café et kitchenettes nettoyés et désinfectés. Papier, savon et essuie-mains réapprovisionnés si vous le souhaitez.',
        ],
        [
            'slug' => 'apres-chantier',
            'family' => 'ponctuel',
            'icon' => 'HardHat',
            'title' => 'Nettoyage après chantier',
            'short' => 'Poussière, ciment, peinture, étiquettes',
            'text' => 'Après une construction ou une rénovation : poussières de ponçage, résidus de ciment, de silicone et de peinture, étiquettes sur les vitrages.',
        ],
        [
            'slug' => 'sols-moquettes',
            'family' => 'ponctuel',
            'icon' => 'Footprints',
            'title' => 'Sols, moquettes et tapis',
            'short' => 'Lavage, décapage, shampouinage',
            'text' => 'Lavage et décapage des sols durs, shampouinage des moquettes et des tapis, traitement des taches avant qu\'elles ne s\'incrustent.',
        ],
        [
            'slug' => 'vitres-en-hauteur',
            'family' => 'ponctuel',
            'icon' => 'Building2',
            'title' => 'Vitres en hauteur',
            'short' => 'Façades vitrées et verrières',
            'text' => 'Les vitrages jusqu\'à trois étages environ se nettoient depuis le sol, à la perche télescopique, sans échafaudage ni nacelle.',
        ],
        [
            'slug' => 'panneaux-solaires',
            'family' => 'ponctuel',
            'icon' => 'SunMedium',
            'title' => 'Panneaux photovoltaïques',
            'short' => 'Nettoyage doux, sans détergent',
            'text' => 'Des panneaux encrassés produisent moins. Nous les lavons à l\'eau osmosée, sans détergent agressif ni rayure sur le verre.',
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Zones d'intervention — pages locales
    |----------------------------------------------------------------------
    | Chaque entrée génère une page /nettoyage/{slug} optimisée pour
    | la requête « nettoyage {commune} ».
    |
    | 'intro' et 'focus' doivent rester UNIQUES d'une commune à l'autre :
    | deux textes identiques seraient traités comme du contenu dupliqué.
    */
    'zones' => [

        /* ---------------- Région de Bruxelles-Capitale ---------------- */

        [
            'slug' => 'bruxelles',
            'city' => 'Bruxelles',
            'postal' => '1000',
            'province' => 'Bruxelles',
            'primary' => true,
            'intro' => "Du Sablon au quartier européen, Bruxelles-Ville concentre commerces, bureaux et immeubles de rapport. La poussière de trafic et les retombées de pollution y salissent les vitrages nettement plus vite qu'ailleurs.",
            'focus' => "Pour une devanture en plein centre, un passage toutes les deux semaines est le rythme qui tient réellement la propreté ; nous intervenons tôt le matin, avant l'ouverture.",
            'areas' => ['Centre', 'Sablon', 'Quartier européen', 'Louise', 'Laeken', 'Neder-Over-Heembeek'],
        ],
        [
            'slug' => 'schaerbeek',
            'city' => 'Schaerbeek',
            'postal' => '1030',
            'province' => 'Bruxelles',
            'intro' => "Schaerbeek, ce sont des maisons bruxelloises à trois façades, des bow-windows et beaucoup de châssis anciens. Ces vitrages à petits bois demandent de la patience et un séchage soigné sur les appuis en pierre bleue.",
            'focus' => "Nous nettoyons aussi les vitrines des chaussées commerçantes et les parties communes des immeubles de rapport, pour les propriétaires comme pour les syndics.",
            'areas' => ['Josaphat', 'Helmet', 'Chaussée de Haecht', 'Place Dailly', 'Terdelt'],
        ],
        [
            'slug' => 'etterbeek',
            'city' => 'Etterbeek',
            'postal' => '1040',
            'province' => 'Bruxelles',
            'intro' => "Etterbeek mélange maisons de maître, petits immeubles et bureaux liés aux institutions européennes. Beaucoup d'appartements y ont des fenêtres non accessibles depuis l'intérieur.",
            'focus' => "La perche télescopique permet de traiter ces façades depuis la rue ou la cour, sans nacelle et sans immobiliser le trottoir.",
            'areas' => ['Jourdan', 'Chasse', 'Mérode', 'Cinquantenaire'],
        ],
        [
            'slug' => 'ixelles',
            'city' => 'Ixelles',
            'postal' => '1050',
            'province' => 'Bruxelles',
            'intro' => "Ixelles compte parmi les communes où l'on nous appelle le plus : maisons de maître autour des Étangs, appartements Art déco, commerces du Châtelain et de la place Flagey.",
            'focus' => "Les grandes fenêtres à guillotine et les baies d'angle typiques du quartier se nettoient entièrement à l'eau osmosée, sans marque de calcaire au séchage.",
            'areas' => ['Étangs d\'Ixelles', 'Châtelain', 'Flagey', 'Louise', 'Cimetière d\'Ixelles'],
        ],
        [
            'slug' => 'saint-gilles',
            'city' => 'Saint-Gilles',
            'postal' => '1060',
            'province' => 'Bruxelles',
            'intro' => "Saint-Gilles est la commune des façades Art nouveau, des sgraffites et des vitraux. Ce sont des vitrages fragiles, souvent sertis au plomb, sur lesquels on ne travaille ni au grattoir ni au produit agressif.",
            'focus' => "Nous adaptons la méthode au vitrage : eau pure et brosse douce sur les verres anciens, finition manuelle sur les vitraux.",
            'areas' => ['Parvis de Saint-Gilles', 'Barrière', 'Ma Campagne', 'Bosnie'],
        ],
        [
            'slug' => 'anderlecht',
            'city' => 'Anderlecht',
            'postal' => '1070',
            'province' => 'Bruxelles',
            'intro' => "Anderlecht couvre à la fois des quartiers résidentiels calmes, des zonings et des halls industriels. Les surfaces vitrées y sont souvent grandes et hautes.",
            'focus' => "Pour les entrepôts, garages et show-rooms, nous établissons un contrat d'entretien avec un passage à fréquence fixe et une facturation mensuelle.",
            'areas' => ['Scheut', 'Neerpede', 'Cureghem', 'Erasme', 'Le Peterbos'],
        ],
        [
            'slug' => 'molenbeek-saint-jean',
            'city' => 'Molenbeek-Saint-Jean',
            'postal' => '1080',
            'province' => 'Bruxelles',
            'intro' => "Entre le canal et les anciennes zones industrielles, Molenbeek compte beaucoup de lofts, d'ateliers reconvertis et de verrières d'usine. Ces grandes surfaces vitrées sont spectaculaires — et vite grises.",
            'focus' => "Nous intervenons sur les verrières et sheds industriels avec le matériel adapté, y compris quand l'accès intérieur passe par un plateau occupé.",
            'areas' => ['Le canal', 'Karreveld', 'Osseghem', 'Bruxelles-Ouest'],
        ],
        [
            'slug' => 'koekelberg',
            'city' => 'Koekelberg',
            'postal' => '1081',
            'province' => 'Bruxelles',
            'intro' => "Koekelberg est une petite commune dense, dominée par la Basilique. L'habitat y est fait de maisons mitoyennes serrées, dont les fenêtres arrière donnent sur des jardinets peu accessibles.",
            'focus' => "Nous nettoyons les deux faces, façade et arrière, en un seul passage — c'est ce qui évite l'effet « une vitre sur deux propre ».",
            'areas' => ['Basilique', 'Simonis', 'Parc Élisabeth'],
        ],
        [
            'slug' => 'berchem-sainte-agathe',
            'city' => 'Berchem-Sainte-Agathe',
            'postal' => '1082',
            'province' => 'Bruxelles',
            'intro' => "Berchem-Sainte-Agathe garde un caractère résidentiel : maisons quatre façades, jardins et vérandas donnant sur l'arrière. C'est le type de bien où le nettoyage extérieur se fait sans que vous soyez présent.",
            'focus' => "Un accès au jardin suffit : vous nous laissez un code ou une clé, et vous retrouvez le travail fait en rentrant.",
            'areas' => ['Hunderenveld', 'Cité Moderne', 'Zavelenberg'],
        ],
        [
            'slug' => 'ganshoren',
            'city' => 'Ganshoren',
            'postal' => '1083',
            'province' => 'Bruxelles',
            'intro' => "Ganshoren aligne des immeubles à appartements des années 60 et 70, avec de longues baies vitrées et des balcons vitrés. Ces surfaces s'encrassent uniformément et se voient immédiatement quand elles sont propres.",
            'focus' => "Nous travaillons aussi pour les syndics : parties communes, halls d'entrée et cages d'escalier vitrées, avec un rapport de passage.",
            'areas' => ['Villas de Ganshoren', 'Rivieren', 'Basilique'],
        ],
        [
            'slug' => 'jette',
            'city' => 'Jette',
            'postal' => '1090',
            'province' => 'Bruxelles',
            'intro' => "Jette combine maisons familiales, immeubles récents et le pôle hospitalier. Les vitrages y vont de la simple fenêtre de cuisine à des façades entièrement vitrées.",
            'focus' => "Pour les cabinets, cliniques et commerces de la commune, nous proposons des passages en dehors des heures de consultation.",
            'areas' => ['Miroir', 'Woeste', 'Heymbosch', 'Dieleghem'],
        ],
        [
            'slug' => 'evere',
            'city' => 'Evere',
            'postal' => '1140',
            'province' => 'Bruxelles',
            'intro' => "Evere accueille de nombreux immeubles de bureaux et sièges d'entreprises le long des grands axes, à côté de quartiers résidentiels tranquilles.",
            'focus' => "Pour les plateaux de bureaux, nous intervenons en soirée ou le samedi matin, afin de ne perturber aucun poste de travail.",
            'areas' => ['Conscience', 'Paduwa', 'Germinal', 'Da Vinci'],
        ],
        [
            'slug' => 'woluwe-saint-pierre',
            'city' => 'Woluwe-Saint-Pierre',
            'postal' => '1150',
            'province' => 'Bruxelles',
            'intro' => "Woluwe-Saint-Pierre est une commune de villas, de jardins et de grandes baies vitrées orientées vers la verdure. C'est aussi là que les vitres se salissent le plus vite au printemps, à cause des pollens.",
            'focus' => "Deux passages par an, l'un après les pollens et l'autre à l'automne, suffisent généralement à tenir toute l'année.",
            'areas' => ['Stockel', 'Chant d\'Oiseau', 'Sainte-Alix', 'Joli-Bois', 'Montgomery'],
        ],
        [
            'slug' => 'auderghem',
            'city' => 'Auderghem',
            'postal' => '1160',
            'province' => 'Bruxelles',
            'intro' => "Auderghem borde la forêt de Soignes : beaucoup de vérandas, de vitrages en toiture et de fenêtres de toit donnant sur les arbres. Sève, pollen et poussière s'y déposent en couche continue.",
            'focus' => "Les toitures de véranda font partie de nos interventions courantes ici — c'est la surface que la plupart des gens n'atteignent jamais eux-mêmes.",
            'areas' => ['Val Duchesse', 'Rouge-Cloître', 'Transvaal', 'Blankedelle'],
        ],
        [
            'slug' => 'watermael-boitsfort',
            'city' => 'Watermael-Boitsfort',
            'postal' => '1170',
            'province' => 'Bruxelles',
            'intro' => "Watermael-Boitsfort est la commune la plus verte de Bruxelles, avec les cités-jardins Le Logis et Floréal. Maisons basses, fenêtres nombreuses, châssis en bois peint.",
            'focus' => "Sur ces châssis anciens, nous nettoyons sans détremper le bois ni décoller la peinture, et nous essuyons chaque appui à la main.",
            'areas' => ['Le Logis', 'Floréal', 'Trois Tilleuls', 'Coin du Balai'],
        ],
        [
            'slug' => 'uccle',
            'city' => 'Uccle',
            'postal' => '1180',
            'province' => 'Bruxelles',
            'intro' => "Uccle est l'une de nos communes les plus demandées : maisons de maître, villas de Fort-Jaco, grandes fenêtres à double hauteur et vérandas ouvrant sur le jardin.",
            'focus' => "L'eau osmosée sèche seule sur ces grandes surfaces, sans la moindre trace de calcaire — c'est ce qui fait la différence sur un vitrage de trois mètres.",
            'areas' => ['Fort-Jaco', 'Saint-Job', 'Vivier d\'Oie', 'Calevoet', 'Observatoire'],
        ],
        [
            'slug' => 'forest',
            'city' => 'Forest',
            'postal' => '1190',
            'province' => 'Bruxelles',
            'intro' => "Forest juxtapose l'Altitude Cent, ses maisons bourgeoises et ses immeubles Art déco, et le bas de la commune, plus dense et plus commerçant.",
            'focus' => "Nous adaptons le devis au type de bien : à la fenêtre pour une maison, au mètre courant de vitrine pour un commerce.",
            'areas' => ['Altitude Cent', 'Parc de Forest', 'Saint-Antoine', 'Duden'],
        ],
        [
            'slug' => 'woluwe-saint-lambert',
            'city' => 'Woluwe-Saint-Lambert',
            'postal' => '1200',
            'province' => 'Bruxelles',
            'intro' => "Woluwe-Saint-Lambert compte beaucoup de résidences avec parties communes vitrées, de bureaux et de commerces autour du Woluwe Shopping.",
            'focus' => "Halls d'entrée, sas vitrés et portes automatiques : ce sont les surfaces les plus touchées de la journée, et celles qui se voient le plus.",
            'areas' => ['Roodebeek', 'Tomberg', 'Georges Henri', 'Kapelleveld', 'Hof-ten-Berg'],
        ],
        [
            'slug' => 'saint-josse-ten-noode',
            'city' => 'Saint-Josse-ten-Noode',
            'postal' => '1210',
            'province' => 'Bruxelles',
            'intro' => "La plus petite commune du pays est aussi l'une des plus denses en bureaux, hôtels et commerces, autour du quartier Nord et de la place Madou.",
            'focus' => "Pour les hôtels et les surfaces commerciales, nous travaillons avant 8 h afin que la façade soit nette à l'ouverture.",
            'areas' => ['Madou', 'Quartier Nord', 'Botanique', 'Place Saint-Josse'],
        ],

        /* ---------------- Périphérie ---------------- */

        [
            'slug' => 'rhode-saint-genese',
            'city' => 'Rhode-Saint-Genèse',
            'postal' => '1640',
            'province' => 'Périphérie',
            'intro' => "Rhode-Saint-Genèse est adossée à la forêt de Soignes : grandes propriétés, vitrages panoramiques et vérandas tournées vers les arbres. Les feuilles et la sève y marquent le verre chaque automne.",
            'focus' => "Nous couvrons la commune en français comme en néerlandais pour la prise de rendez-vous.",
            'areas' => ['Espinette', 'Sept Fontaines', 'Grand Espinette', 'Hoek'],
        ],
        [
            'slug' => 'kraainem',
            'city' => 'Kraainem',
            'postal' => '1950',
            'province' => 'Périphérie',
            'intro' => "Kraainem est directement accolée à Woluwe : villas récentes, larges baies coulissantes et carports vitrés. L'accès aux jardins y est simple, ce qui rend les interventions rapides.",
            'focus' => "Deux communes voisines dans la même tournée, c'est un déplacement partagé — et un prix qui reste bas.",
            'areas' => ['Centre', 'Bois de Kraainem', 'Stockel-est'],
        ],
        [
            'slug' => 'wezembeek-oppem',
            'city' => 'Wezembeek-Oppem',
            'postal' => '1970',
            'province' => 'Périphérie',
            'intro' => "Wezembeek-Oppem est une commune résidentielle de villas avec de grandes surfaces vitrées au rez-de-chaussée et des verrières de véranda.",
            'focus' => "Les vitrages de véranda, en toiture comme en façade, sont traités à la perche depuis le jardin, sans monter sur la structure.",
            'areas' => ['Centre', 'Ban-Eik', 'Sint-Pieters'],
        ],
        [
            'slug' => 'tervuren',
            'city' => 'Tervuren',
            'postal' => '3080',
            'province' => 'Périphérie',
            'intro' => "Tervuren, ses propriétés autour du parc et ses maisons de caractère, présente souvent des fenêtres hautes à petits carreaux et des orangeries vitrées.",
            'focus' => "Sur les vitrages à croisillons, le travail se fait carreau par carreau : c'est plus long, et c'est la seule façon d'obtenir un résultat net.",
            'areas' => ['Centre', 'Vossem', 'Duisburg', 'Moorsel'],
        ],
        [
            'slug' => 'overijse',
            'city' => 'Overijse',
            'postal' => '3090',
            'province' => 'Périphérie',
            'intro' => "Overijse et Jezus-Eik, aux portes de la forêt de Soignes, comptent de nombreuses villas, serres et petits bâtiments de bureaux.",
            'focus' => "L'héritage horticole de la commune se voit encore : nous nettoyons aussi les serres et les vitrages de jardin.",
            'areas' => ['Jezus-Eik', 'Maleizen', 'Terlanen', 'Tombeek'],
        ],
        [
            'slug' => 'hoeilaart',
            'city' => 'Hoeilaart',
            'postal' => '1560',
            'province' => 'Périphérie',
            'intro' => "Hoeilaart est entourée de forêt sur trois côtés. Les vitres y verdissent plus vite qu'ailleurs, surtout sur les façades nord qui ne sèchent jamais complètement.",
            'focus' => "Nous retirons le voile vert des vitrages et des châssis, sans javel ni produit qui ruisselle dans les massifs.",
            'areas' => ['Centre', 'Groenendaal', 'Sint-Jansberg'],
        ],
        [
            'slug' => 'la-hulpe',
            'city' => 'La Hulpe',
            'postal' => '1310',
            'province' => 'Périphérie',
            'intro' => "À La Hulpe, entre le domaine Solvay et la forêt, les maisons sont noyées dans la verdure : pollen au printemps, poussière et sève l'été.",
            'focus' => "Deux passages par an suffisent généralement pour garder des vitres nettes toute l'année.",
            'areas' => ['Gaillemarde', 'Centre', 'Domaine Solvay', 'Les Aubépines'],
        ],
        [
            'slug' => 'lasne',
            'city' => 'Lasne',
            'postal' => '1380',
            'province' => 'Périphérie',
            'intro' => "Lasne, ce sont des villas entourées de jardins, de grandes baies ouvertes sur la campagne et des vérandas exposées aux feuilles et à la poussière des chemins.",
            'focus' => "Maisons quatre façades, fermettes rénovées et commerces du centre : nous prévoyons le temps qu'il faut pour les grandes surfaces vitrées.",
            'areas' => ['Ohain', 'Plancenoit', 'Couture-Saint-Germain', 'Maransart', 'Chapelle-Saint-Lambert'],
        ],
        [
            'slug' => 'waterloo',
            'city' => 'Waterloo',
            'postal' => '1410',
            'province' => 'Périphérie',
            'intro' => "À Waterloo, nous nettoyons aussi bien les vitrines de la chaussée de Bruxelles que les grandes verrières des villas du Chenois et de Mont-Saint-Jean.",
            'focus' => "Les surfaces vitrées y sont souvent hautes : nous travaillons à la perche télescopique, sans échafaudage ni nacelle.",
            'areas' => ['Le Chenois', 'Mont-Saint-Jean', 'Joli-Bois', 'Chaussée de Bruxelles'],
        ],
        [
            'slug' => 'zaventem',
            'city' => 'Zaventem',
            'postal' => '1930',
            'province' => 'Périphérie',
            'intro' => "Zaventem, c'est surtout du tertiaire : parcs d'affaires, sièges régionaux et halls logistiques, avec des façades largement vitrées.",
            'focus' => "Pour ces bâtiments, nous chiffrons au contrat annuel, avec un nombre de passages fixé à l'avance et un interlocuteur unique.",
            'areas' => ['Sterrebeek', 'Nossegem', 'Sint-Stevens-Woluwe', 'Da Vinci Park'],
        ],
        [
            'slug' => 'dilbeek',
            'city' => 'Dilbeek',
            'postal' => '1700',
            'province' => 'Périphérie',
            'intro' => "Dilbeek est une grande commune résidentielle à l'ouest de Bruxelles, faite de fermettes rénovées, de villas et de lotissements récents.",
            'focus' => "Sur les constructions récentes à triple vitrage et châssis en aluminium, le rendu à l'eau osmosée est particulièrement net.",
            'areas' => ['Schepdaal', 'Groot-Bijgaarden', 'Itterbeek', 'Sint-Martens-Bodegem'],
        ],
        [
            'slug' => 'grimbergen',
            'city' => 'Grimbergen',
            'postal' => '1850',
            'province' => 'Périphérie',
            'intro' => "Grimbergen, au nord de Bruxelles, mêle quartiers pavillonnaires, commerces de proximité et zones d'activité le long du ring.",
            'focus' => "Commerces et petites entreprises y prennent souvent un passage mensuel : c'est le meilleur rapport propreté-budget pour une vitrine.",
            'areas' => ['Strombeek-Bever', 'Beigem', 'Humbeek', 'Borgt'],
        ],
        [
            'slug' => 'londerzeel',
            'city' => 'Londerzeel',
            'postal' => '1840',
            'province' => 'Périphérie',
            'primary' => true,
            'intro' => "Clean Company est établie Watermolenstraat, à Londerzeel. C'est notre point de départ : nous pouvons y caler un passage à très court terme, pour une maison comme pour un commerce.",
            'focus' => "Maisons du centre, lotissements de Malderen et de Steenhuffel, entreprises le long de l'A12 : nous connaissons la commune rue par rue.",
            'areas' => ['Centre', 'Malderen', 'Steenhuffel', 'Sint-Jozef'],
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Partenaires — logos affichés sur la page d'accueil
    |----------------------------------------------------------------------
    | Les fichiers sont dans public/partenaires. 'dark' pose le logo sur un
    | fond noir (logo dessiné pour fond sombre).
    */
    'partners' => [
        ['name' => 'Australian Homemade Ice Cream', 'logo' => '/partenaires/australian.webp', 'width' => 222, 'height' => 260],
        ['name' => 'Belgaufra', 'logo' => '/partenaires/belgaufra.webp', 'width' => 308, 'height' => 260],
        ['name' => 'Homeland', 'logo' => '/partenaires/homeland.webp', 'width' => 323, 'height' => 260],
        ['name' => 'Baba', 'logo' => '/partenaires/baba.webp', 'width' => 809, 'height' => 260, 'dark' => true],
        ['name' => 'Antika', 'logo' => '/partenaires/antika.webp', 'width' => 607, 'height' => 260],
    ],

    /*
    |----------------------------------------------------------------------
    | FAQ — alimente la section FAQ et le balisage FAQPage
    |----------------------------------------------------------------------
    */
    'faq' => [
        [
            'q' => "Combien coûte un nettoyage ?",
            'a' => "Le prix dépend de la surface, de l'état des lieux et de la fréquence. Nous vous donnons un montant ferme après avoir vu quelques photos ou, pour un contrat régulier, après une courte visite. Le devis est gratuit et sans engagement, et le prix annoncé est celui que vous payez.",
        ],
        [
            'q' => "Travaillez-vous pour les particuliers et pour les entreprises ?",
            'a' => "Oui, les deux. Nous faisons le ménage et le grand nettoyage des maisons et des appartements, et nous entretenons les bureaux, les commerces et les immeubles, en passage ponctuel ou en contrat régulier.",
        ],
        [
            'q' => "Est-ce la même personne qui vient à chaque passage ?",
            'a' => "Oui, autant que possible. Pour un ménage régulier ou un contrat de bureaux, la même personne revient : elle connaît les lieux, vos habitudes et les points auxquels vous tenez.",
        ],
        [
            'q' => "Faut-il être présent pendant le nettoyage ?",
            'a' => "Non. Beaucoup de clients nous confient une clé ou un code. Pour un premier passage, nous préférons faire le tour des lieux avec vous.",
        ],
        [
            'q' => "Apportez-vous le matériel et les produits ?",
            'a' => "Oui, nous venons avec notre matériel et nos produits. Si vous préférez que nous utilisions les vôtres, dites-le simplement au moment du devis.",
        ],
        [
            'q' => "Comment fonctionne un contrat d'entretien de bureaux ?",
            'a' => "Nous convenons ensemble de ce qu'il y a à nettoyer, de la fréquence et des horaires, en général tôt le matin ou en soirée. Vous avez un prix mensuel fixe et un seul interlocuteur.",
        ],
        [
            'q' => "Nettoyez-vous aussi les vitres ?",
            'a' => "Oui. Nous lavons les vitres à l'eau osmosée, une eau déminéralisée qui sèche sans laisser de trace. Les châssis et les appuis de fenêtre sont compris. Les vitrages en hauteur se font à la perche télescopique, depuis le sol.",
        ],
        [
            'q' => "Faites-vous le nettoyage après des travaux ?",
            'a' => "Oui. Nous retirons les poussières de ponçage, les résidus de ciment, de silicone et de peinture, et les étiquettes sur les vitrages, pour que les lieux soient habitables ou prêts à être livrés.",
        ],
        [
            'q' => "Dans quelles communes intervenez-vous ?",
            'a' => "Dans les 19 communes de la Région de Bruxelles-Capitale et autour de Bruxelles : Londerzeel, Grimbergen, Dilbeek, Zaventem, Kraainem, Wezembeek-Oppem, Tervuren, Overijse, Hoeilaart, Rhode-Saint-Genèse, La Hulpe, Lasne et Waterloo. Si votre commune n'est pas dans la liste, appelez-nous.",
        ],
        [
            'q' => "Sous quel délai recevrai-je mon devis ?",
            'a' => "Nous répondons à toute demande sous 24 h ouvrables. Pour la plupart des maisons, quelques photos suffisent à établir un prix ferme sans visite.",
        ],
        [
            'q' => "Que se passe-t-il si je ne suis pas satisfait ?",
            'a' => "Dites-le-nous dans les jours qui suivent : nous repassons sur ce qui n'a pas été bien fait, sans supplément.",
        ],
    ],

];
