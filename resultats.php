<?php
require "connect.php";

$conn = new mysqli(SERVEUR, NOM, PASSE, BASE);
if ($conn->connect_error) {
    die("<p class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4'>Erreur de connexion à la base de données.</p>");
}

$query = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
$categorie = isset($_GET['cat']) ? $conn->real_escape_string($_GET['cat']) : '';

// Fonction pour générer les filtres personnalisables
function generateCustomFilters($baseUrl, $filtersConfig)
{
    $html = '<div class="bg-gray-100 p-4 rounded-lg mb-6">';
    $html .= '<h4 class="font-bold text-lg mb-3 text-gabon-blue">Personnaliser les résultats :</h4>';
    $html .= '<div class="flex flex-wrap gap-4">';

    foreach ($filtersConfig as $filter) {
        $html .= '<div class="bg-white rounded-lg shadow-sm p-3 w-full md:w-auto">';
        $html .= '<label class="block text-sm font-medium text-gray-700 mb-1">' . $filter['label'] . '</label>';

        if ($filter['type'] === 'select') {
            $html .= '<select name="' . $filter['name'] . '" class="filter-select w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gabon-green focus:border-transparent" onchange="applyFilters()">';
            foreach ($filter['options'] as $value => $text) {
                $selected = (isset($_GET[$filter['name']]) && $_GET[$filter['name']] === $value) ? 'selected' : '';
                $html .= '<option value="' . $value . '" ' . $selected . '>' . $text . '</option>';
            }
            $html .= '</select>';
        } elseif ($filter['type'] === 'checkbox') {
            foreach ($filter['options'] as $value => $text) {
                $checked = (isset($_GET[$filter['name']]) && in_array($value, explode(',', $_GET[$filter['name']]))) ? 'checked' : '';
                $html .= '<div class="flex items-center mt-1">';
                $html .= '<input type="checkbox" name="' . $filter['name'] . '[]" value="' . $value . '" class="filter-checkbox h-4 w-4 text-gabon-green focus:ring-gabon-green border-gray-300 rounded" ' . $checked . '>';
                $html .= '<label class="ml-2 block text-sm text-gray-700">' . $text . '</label>';
                $html .= '</div>';
            }
        }

        $html .= '</div>';
    }

    $html .= '<div class="flex items-end w-full md:w-auto">';
    $html .= '<button type="button" onclick="applyFilters()" class="bg-gabon-green hover:bg-green-700 text-white px-4 py-2 rounded-md transition flex items-center h-10">';
    $html .= '<i class="fas fa-filter mr-2"></i> Appliquer';
    $html .= '</button>';
    $html .= '</div>';

    $html .= '</div></div>';

    return $html;
}

function afficherSection($titre_section, $contenu_section)
{
    echo "<div class='mb-10'>
            <h3 class='text-2xl font-bold text-gabon-blue mb-4 pb-2 border-b border-gabon-yellow'>$titre_section</h3>
            <div class='space-y-6'>$contenu_section</div>
          </div>";
}

function afficherCarte($titre, $contenu, $type)
{
    $couleurs = [
        'ville' => 'border-gabon-blue bg-blue-50',
        'departement' => 'border-gabon-green bg-green-50',
        'province' => 'border-gabon-yellow bg-yellow-50',
        'personnage' => 'border-amber-500 bg-amber-50',
        'ethnie' => 'border-teal-500 bg-teal-50'
    ];

    $couleur = $couleurs[$type] ?? 'border-gray-500 bg-gray-50';

    return "<div class='rounded-lg shadow-md overflow-hidden $couleur'>
              <div class='p-6'>
                <h4 class='text-xl font-semibold mb-3 text-gabon-blue'>$titre</h4>
                <div class='prose'>$contenu</div>
              </div>
            </div>";
}

?>

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche | Gabon Explorer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="./assets/js/tailwind.js"></script>
    <script src="./assets/js/custom.js"></script>
    <link rel="stylesheet" href="./assets/css/custom.css">

</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Barre de progression -->
    <div class="w-full h-1 bg-gray-200 fixed top-0 z-50">
        <div id="progressBar" class="h-1 bg-gradient-to-r from-accent-500 via-primary-500 to-secondary-500 w-0"></div>
    </div>
    <header class="hero-pattern bg-gabon-blue py-6 shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full mr-4 bg-secondary-500 flex items-center justify-center animate-pulse-slow">
                        <img src="./assets/images/logo.png" alt="Logo" class="w-10 h-10">
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">
                            Gabon Explorer
                        </h1>
                        <p class="text-gabon-yellow text-sm">Votre portail de connaissances sur le Gabon</p>
                    </div>
                </div>
                <form action="resultats.php" method="get" class="flex relative w-full md:w-auto">
                    <input name="q" type="search" id="searchInput" placeholder="ville, département, province, personnage, ethnie..."
                        class="flex-1 px-4 py-2 rounded-l-full border-0 bg-white text-gray-800 focus:ring-2 focus:ring-gabon-yellow focus:outline-none"
                        value="<?= htmlspecialchars($query) ?>" />
                    <div id="suggestions" class="absolute mt-10 bg-white border border-gray-200 rounded-lg shadow-lg w-full z-50 max-h-60 overflow-y-auto"></div>
                    <button type="submit" class="text-white px-5 py-2 rounded-r-full bg-gradient-to-r from-gabon-green to-gabon-blue hover:opacity-90 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row items-center mb-6 gap-4">
                <div class="bg-gabon-green p-3 rounded-full">
                    <i class="fas fa-search text-white text-xl"></i>
                </div>
                <div class="text-center md:text-left">
                    <h2 class="text-2xl font-bold text-gabon-blue">Résultats pour :
                        <span class="text-gabon-green"><?= htmlspecialchars($query) ?></span>
                    </h2>
                    <p class="text-gray-600">Exploration des données culturelles, géographiques et historiques</p>
                </div>
                <div class="md:ml-auto mt-4 md:mt-0">
                    <a href="index.php" class="bg-gabon-blue hover:bg-blue-800 text-white px-4 py-2 rounded-md transition flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Page d'accueil
                    </a>
                </div>
            </div>

            <?php
            // Récupération des paramètres de tri et filtres
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'nom';
            $order = isset($_GET['order']) ? $_GET['order'] : 'asc';
            $allowed_sorts = ['nom', 'population', 'date_naissance', 'age'];
            $allowed_orders = ['asc', 'desc'];

            // Validation des paramètres
            if (!in_array($sort, $allowed_sorts)) $sort = 'nom';
            if (!in_array($order, $allowed_orders)) $order = 'asc';

            // Détection des catégories
            $categories = [
                'villes' => ['icon' => 'city', 'title' => 'Villes'],
                'departements' => ['icon' => 'map-signs', 'title' => 'Départements'],
                'provinces' => ['icon' => 'map', 'title' => 'Provinces'],
                'personnages' => ['icon' => 'users', 'title' => 'Personnalités'],
                'ethnies' => ['icon' => 'people-group', 'title' => 'Ethnies']
            ];

            if (array_key_exists(strtolower($query), $categories) || !empty($categorie)) {
                $current_cat = !empty($categorie) ? $categorie : strtolower($query);
                $cat_config = $categories[$current_cat];

                // Base URL pour les liens de tri
                $baseUrl = "resultats.php?q=$query&cat=$current_cat";

                // Configuration des filtres personnalisés
                $filtersConfig = [];

                switch ($current_cat) {
                    case 'villes':
                        $filtersConfig = [
                            [
                                'label' => 'Trier par',
                                'name' => 'sort',
                                'type' => 'select',
                                'options' => [
                                    'nom' => 'Nom (A-Z)',
                                    'nom_desc' => 'Nom (Z-A)',
                                    'population' => 'Population (croissant)',
                                    'population_desc' => 'Population (décroissant)'
                                ]
                            ],
                            [
                                'label' => 'Commence par',
                                'name' => 'starts_with',
                                'type' => 'select',
                                'options' => array_merge(
                                    ['all' => 'Toutes lettres'],
                                    array_combine(range('A', 'Z'), range('A', 'Z'))
                                )
                            ],
                            [
                                'label' => 'Par province',
                                'name' => 'province',
                                'type' => 'checkbox',
                                'options' => [
                                    'estuaire' => 'Estuaire',
                                    'haut-ogooue' => 'Haut-Ogooué',
                                    'moyen-ogooue' => 'Moyen-Ogooué',
                                    'ngounie' => 'Ngounié',
                                    'nyanga' => 'Nyanga',
                                    'ogooue-ivindo' => 'Ogooué-Ivindo',
                                    'ogooue-lolo' => 'Ogooué-Lolo',
                                    'ogooue-maritime' => 'Ogooué-Maritime',
                                    'woleu-ntem' => 'Woleu-Ntem'
                                ]
                            ]
                        ];
                        break;

                    case 'departements':
                        $filtersConfig = [
                            [
                                'label' => 'Trier par',
                                'name' => 'sort',
                                'type' => 'select',
                                'options' => [
                                    'nom' => 'Nom (A-Z)',
                                    'nom_desc' => 'Nom (Z-A)',
                                    'population' => 'Population (croissant)',
                                    'population_desc' => 'Population (décroissant)'
                                ]
                            ],
                            [
                                'label' => 'Population',
                                'name' => 'population_range',
                                'type' => 'select',
                                'options' => [
                                    'all' => 'Toute population',
                                    '0-50000' => 'Moins de 50,000',
                                    '50000-100000' => '50,000 à 100,000',
                                    '100000-200000' => '100,000 à 200,000',
                                    '200000+' => 'Plus de 200,000'
                                ]
                            ]
                        ];
                        break;

                    case 'personnages':
                        $filtersConfig = [
                            [
                                'label' => 'Trier par',
                                'name' => 'sort',
                                'type' => 'select',
                                'options' => [
                                    'nom' => 'Nom (A-Z)',
                                    'nom_desc' => 'Nom (Z-A)',
                                    'age' => 'Âge (croissant)',
                                    'age_desc' => 'Âge (décroissant)'
                                ]
                            ],
                            [
                                'label' => 'Par époque',
                                'name' => 'epoque',
                                'type' => 'checkbox',
                                'options' => [
                                    'pre_colonial' => 'Pré-colonial',
                                    'colonial' => 'Colonial',
                                    'post_independence' => 'Post-indépendance',
                                    'contemporain' => 'Contemporain'
                                ]
                            ]
                        ];
                        break;
                }

                echo "<div class='mb-8'>
                        <div class='flex items-center mb-4'>
                            <div class='bg-gabon-green p-2 rounded-full mr-3'>
                                <i class='fas fa-{$cat_config['icon']} text-white'></i>
                            </div>
                            <h3 class='text-2xl font-bold text-gabon-blue'>
                                {$cat_config['title']}
                            </h3>
                        </div>";

                // Afficher les filtres personnalisés
                if (!empty($filtersConfig)) {
                    echo generateCustomFilters($baseUrl, $filtersConfig);
                }

                // Affichage du tableau selon la catégorie
                echo "<div class='overflow-x-auto rounded-lg shadow'>";
                echo "<table class='min-w-full bg-white'>";

                switch ($current_cat) {
                    case 'villes':
                        // Construction de la requête pour les villes
                        $sql = "SELECT v.nom AS ville, d.nom AS departement, 
                                       p.nom AS province, v.population
                                FROM villes v
                                JOIN departements d ON v.departement_id = d.id
                                JOIN provinces p ON d.province_id = p.id
                                ORDER BY ";

                        // Ajout du tri
                        if ($sort === 'population') {
                            $sql .= "v.population $order, v.nom";
                        } else {
                            $sql .= "v.nom $order";
                        }

                        $res = $conn->query($sql);

                        // En-têtes du tableau
                        echo "<thead class='bg-gabon-blue text-white'>
                                <tr>
                                    <th class='py-3 px-4 text-left'>Ville</th>
                                    <th class='py-3 px-4 text-left'>Département</th>
                                    <th class='py-3 px-4 text-left'>Province</th>
                                    <th class='py-3 px-4 text-right'>Population</th>
                                </tr>
                              </thead>
                              <tbody>";

                        while ($row = $res->fetch_assoc()) {
                            $population = number_format($row['population'] ?? 0, 0, ',', ' ');
                            echo "<tr class='border-b hover:bg-gray-50'>
                                    <td class='py-3 px-4 font-medium'>{$row['ville']}</td>
                                    <td class='py-3 px-4'>{$row['departement']}</td>
                                    <td class='py-3 px-4'>{$row['province']}</td>
                                    <td class='py-3 px-4 text-right font-medium'>$population</td>
                                  </tr>";
                        }
                        break;

                    case 'departements':
                        // Requête pour les départements
                        $sql = "SELECT d.nom AS departement, d.chef_lieu, 
                                        p.nom AS province, d.population
                                FROM departements d
                                JOIN provinces p ON d.province_id = p.id
                                ORDER BY ";

                        if ($sort === 'population') {
                            $sql .= "d.population $order, d.nom";
                        } else {
                            $sql .= "d.nom $order";
                        }

                        $res = $conn->query($sql);

                        echo "<thead class='bg-gabon-blue text-white'>
                                <tr>
                                    <th class='py-3 px-4 text-left'>Département</th>
                                    <th class='py-3 px-4 text-left'>Chef-lieu</th>
                                    <th class='py-3 px-4 text-left'>Province</th>
                                    <th class='py-3 px-4 text-right'>Population</th>
                                </tr>
                              </thead>
                              <tbody>";

                        while ($row = $res->fetch_assoc()) {
                            $population = number_format($row['population'] ?? 0, 0, ',', ' ');
                            echo "<tr class='border-b hover:bg-gray-50'>
                                    <td class='py-3 px-4 font-medium'>{$row['departement']}</td>
                                    <td class='py-3 px-4'>{$row['chef_lieu']}</td>
                                    <td class='py-3 px-4'>{$row['province']}</td>
                                    <td class='py-3 px-4 text-right font-medium'>$population</td>
                                  </tr>";
                        }
                        break;

                    case 'provinces':
                        // Requête pour les provinces
                        $sql = "SELECT p.nom AS province, p.chef_lieu, 
                                       COUNT(d.id) AS nb_departements
                                FROM provinces p
                                LEFT JOIN departements d ON p.id = d.province_id
                                GROUP BY p.id
                                ORDER BY ";

                        if ($sort === 'population') {
                            // Note: Ajouter un champ population si disponible
                            $sql .= "p.nom $order";
                        } else {
                            $sql .= "p.nom $order";
                        }

                        $res = $conn->query($sql);

                        echo "<thead class='bg-gabon-blue text-white'>
                                <tr>
                                    <th class='py-3 px-4 text-left'>Province</th>
                                    <th class='py-3 px-4 text-left'>Chef-lieu</th>
                                    <th class='py-3 px-4 text-right'>Départements</th>
                                </tr>
                              </thead>
                              <tbody>";

                        while ($row = $res->fetch_assoc()) {
                            echo "<tr class='border-b hover:bg-gray-50'>
                                    <td class='py-3 px-4 font-medium'>{$row['province']}</td>
                                    <td class='py-3 px-4'>{$row['chef_lieu']}</td>
                                    <td class='py-3 px-4 text-right font-medium'>{$row['nb_departements']}</td>
                                  </tr>";
                        }
                        break;

                    case 'personnages':
                        // Requête pour les personnages
                        $sql = "SELECT p.nom, p.date_naissance, 
                                       p.lieu_naissance, pr.nom AS province, 
                                       e.nom AS ethnie, 
                                       YEAR(CURDATE()) - YEAR(p.date_naissance) - 
                                       (RIGHT(CURDATE(), 5) < RIGHT(p.date_naissance, 5)) AS age,
                                       p.image
                                FROM personnages p
                                LEFT JOIN provinces pr ON p.province_id = pr.id
                                LEFT JOIN ethnies e ON p.ethnie_id = e.id
                                ORDER BY ";

                        if ($sort === 'age') {
                            $sql .= "age $order, p.nom";
                        } else if ($sort === 'age_desc') {
                            $sql .= "age desc";
                        } else {
                            $sql .= "p.nom $order";
                        }

                        $res = $conn->query($sql);

                        echo "<thead class='bg-gabon-blue text-white'>
                                <tr>
                                    <th class='py-3 px-4 text-left'>Nom</th>
                                    <th class='py-3 px-4 text-left'>Lieu de naissance</th>
                                    <th class='py-3 px-4 text-left'>Province</th>
                                    <th class='py-3 px-4 text-left'>Ethnie</th>
                                    <th class='py-3 px-4 text-right'>Âge</th>
                                </tr>
                              </thead>
                              <tbody>";

                        while ($row = $res->fetch_assoc()) {
                            $age = $row['age'] ?? 'Inconnu';
                            echo "<tr class='border-b hover:bg-gray-50'>
                                    <td class='py-3 px-4 font-medium'>{$row['nom']}</td>
                                    <td class='py-3 px-4'>{$row['lieu_naissance']}</td>
                                    <td class='py-3 px-4'>{$row['province']}</td>
                                    <td class='py-3 px-4'>{$row['ethnie']}</td>
                                    <td class='py-3 px-4 text-right font-medium'>$age</td>
                                  </tr>";
                        }
                        break;

                    case 'ethnies':
                        // Requête pour les ethnies
                        $sql = "SELECT e.nom AS ethnie, p.nom AS province, 
                                       LENGTH(e.description) AS desc_length
                                FROM ethnies e
                                LEFT JOIN provinces p ON e.province_id = p.id
                                ORDER BY ";

                        if ($sort === 'population') {
                            // Note: Ajouter un champ population si disponible
                            $sql .= "e.nom $order";
                        } else {
                            $sql .= "e.nom $order";
                        }

                        $res = $conn->query($sql);

                        echo "<thead class='bg-gabon-blue text-white'>
                                <tr>
                                    <th class='py-3 px-4 text-left'>Ethnie</th>
                                    <th class='py-3 px-4 text-left'>Province principale</th>
                                    <th class='py-3 px-4 text-right'>Long. description</th>
                                </tr>
                              </thead>
                              <tbody>";

                        while ($row = $res->fetch_assoc()) {
                            $desc_length = number_format($row['desc_length'] ?? 0, 0, ',', ' ');
                            echo "<tr class='border-b hover:bg-gray-50'>
                                    <td class='py-3 px-4 font-medium'>{$row['ethnie']}</td>
                                    <td class='py-3 px-4'>{$row['province']}</td>
                                    <td class='py-3 px-4 text-right font-medium'>{$desc_length} caractères</td>
                                  </tr>";
                        }
                        break;
                }

                echo "</tbody></table></div></div>";
            } else {
                // Si aucune catégorie spécifique n'est trouvée, on affiche les résultats généraux
                $hasResults = false;
                $sections = [];

                // Rechercher une ville
                $res = $conn->query("
                    SELECT v.nom AS ville, d.nom AS departement, p.nom AS province, v.population
                    FROM villes v
                    JOIN departements d ON v.departement_id = d.id
                    JOIN provinces p ON d.province_id = p.id
                    WHERE v.nom LIKE '%$query%'
                ");

                $villesContent = '';
                while ($row = $res->fetch_assoc()) {
                    $hasResults = true;
                    $ville = htmlspecialchars($row['ville'] ?? '', ENT_QUOTES, 'UTF-8');
                    $departement = htmlspecialchars($row['departement'] ?? '', ENT_QUOTES, 'UTF-8');
                    $province = htmlspecialchars($row['province'] ?? '', ENT_QUOTES, 'UTF-8');
                    $population = number_format($row['population'] ?? 0, 0, ',', ' ');

                    $contenu = "
                        <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                            <div>
                                <h5 class='font-semibold text-gray-700'>Localisation</h5>
                                <p><i class='fas fa-map-marker-alt text-gabon-blue mr-2'></i> $ville, $departement</p>
                                <p><i class='fas fa-globe-africa text-gabon-blue mr-2'></i> Province: $province</p>
                            </div>
                            <div>
                                <h5 class='font-semibold text-gray-700'>Démographie</h5>
                                <p><i class='fas fa-users text-gabon-blue mr-2'></i> Population: $population habitants</p>
                            </div>
                            <div>
                                <h5 class='font-semibold text-gray-700'>Contexte</h5>
                                <p><i class='fas fa-info-circle text-gabon-blue mr-2'></i> Ville gabonaise située dans le département de $departement</p>
                            </div>
                        </div>
                    ";

                    $villesContent .= afficherCarte(
                        "Ville de $ville",
                        $contenu,
                        'ville'
                    );
                }

                if (!empty($villesContent)) {
                    $sections[] = [
                        'titre' => '<i class="fas fa-city mr-2"></i> Villes',
                        'contenu' => $villesContent
                    ];
                }

                // Rechercher un département
                $res = $conn->query("
                    SELECT d.nom AS departement, d.chef_lieu, p.nom AS province, d.population
                    FROM departements d
                    JOIN provinces p ON d.province_id = p.id
                    WHERE d.nom LIKE '%$query%'
                ");

                $departementsContent = '';
                while ($row = $res->fetch_assoc()) {
                    $hasResults = true;
                    $departement = htmlspecialchars($row['departement'] ?? '', ENT_QUOTES, 'UTF-8');
                    $chef_lieu = htmlspecialchars($row['chef_lieu'] ?? '', ENT_QUOTES, 'UTF-8');
                    $province = htmlspecialchars($row['province'] ?? '', ENT_QUOTES, 'UTF-8');
                    $population = number_format($row['population'] ?? 0, 0, ',', ' ');

                    $contenu = "
                        <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                            <div>
                                <h5 class='font-semibold text-gray-700'>Administration</h5>
                                <p><i class='fas fa-flag text-gabon-green mr-2'></i> Département: $departement</p>
                                <p><i class='fas fa-city text-gabon-green mr-2'></i> Chef-lieu: $chef_lieu</p>
                            </div>
                            <div>
                                <h5 class='font-semibold text-gray-700'>Géographie</h5>
                                <p><i class='fas fa-map text-gabon-green mr-2'></i> Province: $province</p>
                                <p><i class='fas fa-users text-gabon-green mr-2'></i> Population: $population habitants</p>
                            </div>
                            <div>
                                <h5 class='font-semibold text-gray-700'>Contexte</h5>
                                <p><i class='fas fa-book text-gabon-green mr-2'></i> Subdivision administrative gabonaise</p>
                            </div>
                        </div>
                    ";

                    $departementsContent .= afficherCarte(
                        "Département de $departement",
                        $contenu,
                        'departement'
                    );
                }

                if (!empty($departementsContent)) {
                    $sections[] = [
                        'titre' => '<i class="fas fa-map-signs mr-2"></i> Départements',
                        'contenu' => $departementsContent
                    ];
                }

                // Rechercher une province
                $res = $conn->query("
                    SELECT p.nom, p.chef_lieu, COUNT(d.id) AS nb_departements
                    FROM provinces p
                    LEFT JOIN departements d ON p.id = d.province_id
                    WHERE p.nom LIKE '%$query%'
                    GROUP BY p.id
                ");

                $provincesContent = '';
                while ($row = $res->fetch_assoc()) {
                    $hasResults = true;
                    $province = htmlspecialchars($row['nom'] ?? '', ENT_QUOTES, 'UTF-8');
                    $chef_lieu = htmlspecialchars($row['chef_lieu'] ?? '', ENT_QUOTES, 'UTF-8');
                    $nb_departements = $row['nb_departements'] ?? 0;

                    $contenu = "
                        <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                            <div>
                                <h5 class='font-semibold text-gray-700'>Capitale</h5>
                                <p><i class='fas fa-star text-gabon-yellow mr-2'></i> Chef-lieu: $chef_lieu</p>
                            </div>
                            <div>
                                <h5 class='font-semibold text-gray-700'>Organisation</h5>
                                <p><i class='fas fa-layer-group text-gabon-yellow mr-2'></i> Départements: $nb_departements</p>
                            </div>
                            <div>
                                <h5 class='font-semibold text-gray-700'>Contexte</h5>
                                <p><i class='fas fa-book text-gabon-yellow mr-2'></i> Principale subdivision territoriale du Gabon</p>
                            </div>
                        </div>
                    ";

                    $provincesContent .= afficherCarte(
                        "Province de $province",
                        $contenu,
                        'province'
                    );
                }

                if (!empty($provincesContent)) {
                    $sections[] = [
                        'titre' => '<i class="fas fa-map mr-2"></i> Provinces',
                        'contenu' => $provincesContent
                    ];
                }

                // Rechercher un personnage
                $res = $conn->query("
                    SELECT p.nom, p.description, p.histoire, p.date_naissance, 
                           p.date_deces, p.lieu_naissance, p.image, 
                           pr.nom AS province, e.nom AS ethnie
                    FROM personnages p
                    LEFT JOIN provinces pr ON p.province_id = pr.id
                    LEFT JOIN ethnies e ON p.ethnie_id = e.id
                    WHERE p.nom LIKE '%$query%'
                ");

                $personnagesContent = '';
                while ($row = $res->fetch_assoc()) {
                    $hasResults = true;
                    $nom = htmlspecialchars($row['nom'] ?? '', ENT_QUOTES, 'UTF-8');
                    $description = nl2br(htmlspecialchars($row['description'] ?? '', ENT_QUOTES, 'UTF-8'));
                    $histoire = nl2br(htmlspecialchars($row['histoire'] ?? '', ENT_QUOTES, 'UTF-8'));
                    $naissance = htmlspecialchars($row['date_naissance'] ?? '', ENT_QUOTES, 'UTF-8');
                    $deces = htmlspecialchars($row['date_deces'] ?? '', ENT_QUOTES, 'UTF-8');
                    $lieu = htmlspecialchars($row['lieu_naissance'] ?? '', ENT_QUOTES, 'UTF-8');
                    $province = htmlspecialchars($row['province'] ?? '', ENT_QUOTES, 'UTF-8');
                    $ethnie = htmlspecialchars($row['ethnie'] ?? '', ENT_QUOTES, 'UTF-8');
                    $image = htmlspecialchars($row['image'] ?? '', ENT_QUOTES, 'UTF-8');
                    $image_path = file_exists("./assets/images/personnalitees/$image")
                        ? "./assets/images/personnalitees/$image"
                        : "./assets/images/personnalitees/default.jpg";

                    $contenu = "
                        <div class='bg-gradient-to-br from-primary-50 to-accent-50 rounded-xl overflow-hidden shadow-lg'>
                    <div class='flex flex-col md:flex-row'>
                      <div class='md:w-1/3 p-4 flex justify-center items-center'>
                        <img src='$image_path' alt='Portrait de $nom' class='w-32 h-32 md:w-40 md:h-40 object-cover rounded-full border-4 border-white shadow-lg'>
                      </div>
                      <div class='md:w-2/3 p-4'>
                        <h3 class='text-xl font-bold text-gray-800'>$nom</h3>
                        <div class='flex flex-wrap gap-2 mt-2 mb-3'>
                          <span class='bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded'>$ethnie</span>
                          <span class='bg-accent-100 text-accent-800 text-xs px-2 py-1 rounded'>$province</span>
                          <span class='bg-secondary-100 text-secondary-800 text-xs px-2 py-1 rounded'>$lieu</span>
                        </div>
                        <p class='text-gray-600 mb-4'>$description</p>
                        <div class='flex justify-between text-sm text-gray-500'>
                          <span><i class='fas fa-birthday-cake mr-1'></i> $naissance</span>
                          <span><i class='fas fa-cross mr-1'></i> $deces</span>
                        </div>
                      </div>
                    </div>
                    <div class='p-4 bg-white'>
                      <h4 class='font-semibold text-gray-800 mb-2'>Histoire et contributions</h4>
                      <p class='text-gray-600'>$histoire</p>
                    </div>
                  </div>";

                    $personnagesContent .= afficherCarte(
                        "Personnalité : $nom",
                        $contenu,
                        'personnage'
                    );
                }

                if (!empty($personnagesContent)) {
                    $sections[] = [
                        'titre' => '<i class="fas fa-users mr-2"></i> Personnalités',
                        'contenu' => $personnagesContent
                    ];
                }

                // Rechercher une ethnie
                $res = $conn->query("
                    SELECT e.nom AS ethnie, e.description, p.nom AS province
                    FROM ethnies e
                    LEFT JOIN provinces p ON e.province_id = p.id
                    WHERE e.nom LIKE '%$query%'
                ");

                $ethniesContent = '';
                while ($row = $res->fetch_assoc()) {
                    $hasResults = true;
                    $ethnie = htmlspecialchars($row['ethnie'] ?? '', ENT_QUOTES, 'UTF-8');
                    $description = nl2br(htmlspecialchars($row['description'] ?? '', ENT_QUOTES, 'UTF-8'));
                    $province = htmlspecialchars($row['province'] ?? '', ENT_QUOTES, 'UTF-8');

                    $contenu = "
                        <div class='flex flex-col md:flex-row gap-6'>
                            <div class='md:w-1/3 bg-teal-50 p-4 rounded-lg'>
                                <h5 class='font-bold text-lg mb-3'><i class='fas fa-info-circle text-teal-500 mr-2'></i> Caractéristiques</h5>
                                <p><span class='font-semibold'>Nom:</span> $ethnie</p>
                                <p><span class='font-semibold'>Province principale:</span> $province</p>
                                <div class='mt-4 p-3 bg-white rounded'>
                                    <p class='text-sm italic'><i class='fas fa-lightbulb text-teal-500 mr-2'></i> Cette ethnie fait partie du riche patrimoine culturel gabonais</p>
                                </div>
                            </div>
                            <div class='md:w-2/3'>
                                <h5 class='font-bold text-lg mb-3'><i class='fas fa-book-open text-teal-500 mr-2'></i> Présentation</h5>
                                <p>$description</p>
                            </div>
                        </div>
                    ";

                    $ethniesContent .= afficherCarte(
                        "Ethnie : $ethnie",
                        $contenu,
                        'ethnie'
                    );
                }

                if (!empty($ethniesContent)) {
                    $sections[] = [
                        'titre' => '<i class="fas fa-people-group mr-2"></i> Ethnies',
                        'contenu' => $ethniesContent
                    ];
                }

                // Afficher toutes les sections
                foreach ($sections as $section) {
                    afficherSection($section['titre'], $section['contenu']);
                }

                // Aucun résultat
                if (!$hasResults) {
                    echo "<div class='text-center py-12'>
                            <div class='bg-gray-100 inline-block p-6 rounded-full mb-4'>
                                <i class='fas fa-search fa-3x text-gray-400'></i>
                            </div>
                            <h3 class='text-2xl font-bold text-gray-700 mb-2'>Aucun résultat trouvé</h3>
                            <p class='text-gray-600 mb-6'>Votre recherche pour \"" . htmlspecialchars($query) . "\" n'a retourné aucun résultat dans notre base de connaissances.</p>
                            <a href='index.php' class='bg-gabon-blue hover:bg-blue-800 text-white px-6 py-3 rounded-lg transition inline-block'>
                                <i class='fas fa-arrow-left mr-2'></i>Effectuer une nouvelle recherche
                            </a>
                          </div>";
                }
            }
            ?>

        </div>
    </main>
    <!-- Retour en haut -->
    <a  href="#" class="flex backToTop fixed bottom-0 right-6 w-10 h-9 rounded-full bg-gradient-to-r from-primary-600 to-accent-600 hover:from-secondary-600 hover:to-accent-900 text-white  items-center justify-center shadow-lg hover:shadow-xl transition ease-linear z-50">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-primary-800 to-accent-800 text-white py-12 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Section à propos -->
            <div class="md:col-span-2">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full mr-4 bg-secondary-500 flex items-center justify-center">
                        <img src="./assets/images/logo.png" alt="Logo" class="w-8 h-8">
                    </div>
                    <div class="text-2xl font-bold">Gabon Explorer</div>
                </div>
                <p class="text-gray-300 mb-4">Une plateforme éducative pour découvrir l'histoire, la culture et les richesses du Gabon.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-white hover:text-secondary-300"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white hover:text-secondary-300"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white hover:text-secondary-300"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white hover:text-secondary-300"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>


            <!-- Contact -->
            <div>
                <h4 class="text-xl font-semibold mb-4 text-secondary-300">Contact</h4>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-envelope mt-1 mr-3 text-secondary-300"></i>
                        <span><a class="underline" href="mailto:guimapidesmond@outlokk.com">contact@gabonexplorer.ga</a></span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone mt-1 mr-3 text-secondary-300"></i>
                        <span>+241 62 94 75 66</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-secondary-300"></i>
                        <span>Franceville, Gabon</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-7xl mx-auto mt-10 pt-6 border-t border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; <?= date('Y') ?> Gabon Explorer. Tous droits réservés.</p>
                <p class="text-green-300 text-sm mt-2 md:mt-0">Découvrir, comprendre et préserver la richesse du Gabon</p>
            </div>
        </div>
    </footer>

    <script>
        function applyFilters() {
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = 'resultats.php';

            // Ajouter le paramètre de recherche
            const qInput = document.createElement('input');
            qInput.type = 'hidden';
            qInput.name = 'q';
            qInput.value = '<?= htmlspecialchars($query) ?>';
            form.appendChild(qInput);

            // Ajouter le paramètre de catégorie
            const catInput = document.createElement('input');
            catInput.type = 'hidden';
            catInput.name = 'cat';
            catInput.value = '<?= htmlspecialchars($categorie) ?>';
            form.appendChild(catInput);

            // Collecter les filtres sélectionnés
            document.querySelectorAll('.filter-select').forEach(select => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = select.name;
                input.value = select.value;
                form.appendChild(input);
            });

            // Collecter les cases à cocher
            document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
                if (checkbox.checked) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = checkbox.name;
                    input.value = checkbox.value;
                    form.appendChild(input);
                }
            });

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>
