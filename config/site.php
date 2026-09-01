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
    | 'icon' correspond à un composant lucide-vue-next.
    */
    'services' => [
        [
            'slug' => 'vitres-residentielles',
            'icon' => 'Home',
            'title' => 'Vitres de maison',
            'short' => 'Fenêtres, baies vitrées et châssis',
            'text' => 'Fenêtres, baies vitrées, châssis et encadrements de votre habitation, nettoyés sans traces ni résidus, intérieur comme extérieur.',
        ],
        [
            'slug' => 'vitrines-commerciales',
            'icon' => 'Store',
            'title' => 'Vitrines de commerce',
            'short' => 'Devantures, en ponctuel ou en contrat',
            'text' => 'Des devantures impeccables qui valorisent votre commerce. Passage ponctuel ou entretien régulier (hebdomadaire, bimensuel, mensuel).',
        ],
        [
            'slug' => 'immeubles-bureaux',
            'icon' => 'Building2',
            'title' => 'Immeubles & bureaux',
            'short' => 'Halls, plateaux, parties communes',
            'text' => 'Surfaces vitrées de vos bureaux, halls d\'entrée et parties communes, nettoyées en toute discrétion, en dehors des heures d\'affluence si besoin.',
        ],
        [
            'slug' => 'verandas-verrieres',
            'icon' => 'Frame',
            'title' => 'Vérandas & verrières',
            'short' => 'Vitrages en hauteur et toitures',
            'text' => 'Toitures de véranda, verrières et vitrages en hauteur remis à neuf grâce aux perches télescopiques, sans échafaudage ni dégâts.',
        ],
        [
            'slug' => 'panneaux-solaires',
            'icon' => 'SunMedium',
            'title' => 'Panneaux photovoltaïques',
            'short' => 'Jusqu\'à +20 % de rendement',
            'text' => 'Des panneaux encrassés produisent moins. Nettoyage doux à l\'eau osmosée, sans détergent agressif ni rayure sur le verre.',
        ],
        [
            'slug' => 'nettoyage-apres-chantier',
            'icon' => 'HardHat',
            'title' => 'Nettoyage après chantier',
            'short' => 'Étiquettes, ciment, peinture',
            'text' => 'Retrait des étiquettes, résidus de ciment, silicone, peinture et poussières de ponçage après vos travaux de construction ou de rénovation.',
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Zones d'intervention — pages locales
    |----------------------------------------------------------------------
    | Chaque entrée génère une page /lavage-de-vitres/{slug} optimisée pour
    | la requête « lavage de vitres {commune} ».
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
            'intro' => "Elo Glass est établie Route de l'Etat, à Lasne. C'est notre point de départ vers Bruxelles, et la commune où nous pouvons caler un créneau à très court terme.",
            'focus' => "Villas avec grandes baies, vérandas, maisons quatre façades et commerces du centre : nous connaissons le bâti de la commune.",
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
    ],

    /*
    |----------------------------------------------------------------------
    | FAQ — alimente la section FAQ et le balisage FAQPage
    |----------------------------------------------------------------------
    */
    'faq' => [
        [
            'q' => 'Combien coûte un lavage de vitres ?',
            'a' => "Le prix dépend du nombre de vitres, de leur accessibilité et de leur état. Pour une maison, comptez en général entre 80 € et 200 € par passage. Le devis est gratuit, sans engagement, et le prix annoncé est celui que vous payez : il n'y a pas de supplément découvert sur place.",
        ],
        [
            'q' => 'Intervenez-vous chez les particuliers comme chez les professionnels ?',
            'a' => "Oui, les deux. Nous nettoyons les vitres de maisons et d'appartements, mais aussi les vitrines de commerces, les bureaux, les halls d'immeubles et les surfaces vitrées de bâtiments professionnels, en passage ponctuel ou en contrat d'entretien régulier.",
        ],
        [
            'q' => 'À quelle fréquence faut-il faire nettoyer ses vitres ?',
            'a' => "Pour une habitation, deux à quatre passages par an suffisent, idéalement au printemps après les pollens et à l'automne. Pour une vitrine commerciale à Bruxelles, un passage toutes les une à deux semaines est nécessaire pour rester impeccable : la poussière de trafic salit très vite.",
        ],
        [
            'q' => 'Nettoyez-vous aussi les châssis et les encadrements ?',
            'a' => "Oui. Le nettoyage des châssis, des encadrements et des appuis de fenêtre est compris dans la prestation : une vitre parfaite dans un châssis sale ne donne aucun résultat visuel.",
        ],
        [
            'q' => 'Comment nettoyez-vous les vitres en hauteur ?',
            'a' => "Avec des perches télescopiques alimentées en eau osmosée, qui permettent d'atteindre les vitrages jusqu'à environ trois étages depuis le sol, sans échafaudage ni nacelle. C'est plus rapide, moins cher et sans risque pour vos façades et vos plantations.",
        ],
        [
            'q' => "Qu'est-ce que l'eau osmosée et pourquoi l'utiliser ?",
            'a' => "C'est une eau totalement déminéralisée, débarrassée du calcaire et des minéraux. Elle sèche seule sans laisser la moindre trace, sans besoin de raclette ni de produit chimique. C'est la méthode utilisée aujourd'hui par les professionnels du vitrage.",
        ],
        [
            'q' => 'Faut-il être présent pendant le nettoyage ?',
            'a' => "Pour l'extérieur uniquement, non : votre présence n'est pas nécessaire tant que l'accès au terrain est possible. Pour l'intérieur, il faut évidemment quelqu'un sur place. Beaucoup de nos clients nous confient simplement un code ou une clé.",
        ],
        [
            'q' => 'Dans quelles communes intervenez-vous ?',
            'a' => "Nous couvrons les 19 communes de la Région de Bruxelles-Capitale ainsi que toute la périphérie : Rhode-Saint-Genèse, Kraainem, Wezembeek-Oppem, Tervuren, Overijse, Hoeilaart, Zaventem, Dilbeek, Grimbergen, La Hulpe, Lasne et Waterloo.",
        ],
        [
            'q' => 'Sous quel délai recevrai-je mon devis ?',
            'a' => "Nous répondons à toute demande sous 24 h ouvrables. Pour la plupart des maisons et des vitrines, quelques photos et le nombre de fenêtres suffisent à établir un prix ferme sans visite préalable.",
        ],
        [
            'q' => 'Êtes-vous assurés ?',
            'a' => "Oui, Elo Glass SRL est une société enregistrée à la Banque-Carrefour des Entreprises sous le numéro 0475.199.436 et couverte en responsabilité civile professionnelle pour l'ensemble de ses interventions.",
        ],
    ],

];
