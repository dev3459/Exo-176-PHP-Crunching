<?php
$string = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
$brut = json_decode($string, true);
$top = $brut["feed"]["entry"]; # liste de films

// exo 1
for ($i = 0; $i < 10; $i++ ) {
    echo $i." - ".$top[$i]["im:name"]["label"] . "<br>";
}

echo "<br>";

// exo 2
$nom = array_column($top, "im:name");
$titre = array_column($nom, "label");
echo "Gravity se trouve au placement numéro : ".array_search("Gravity", $titre) . "<br>";

// exo 3
echo "Le réalisateur du film The LEGO Movie est : ".$top[array_search("The LEGO Movie", $titre)]["im:artist"]["label"] . "<br>";

// exo 4
$avant2000 = 0;
$dateFilm = [];

foreach ($top as $films) {
    $tab = explode(" ", $films["im:releaseDate"]["attributes"]["label"]);
    array_push($dateFilm, $tab[2]);

    if ($tab[2] < 2000) {
        $avant2000++;
    }
}
echo "Il y a eu ".$avant2000." films de sortie avant l'année 2000.<br>";

// exo 5
foreach ($top as $films){
    $tab = explode(" ", $films["im:releaseDate"]["attributes"]["label"]);
    if(min($dateFilm) === $tab[2]){
        echo "Le film le plus ancien est : ".$films["im:name"]["label"]." en ".$tab[2]."<br>";
    }elseif(max($dateFilm) === $tab[2]){
        echo "Le film le plus récent est : ".$films["im:name"]["label"]." en ".$tab[2]."<br>";
    }
}

//exo 6
$categorie = [];
foreach ($top as $film) {
    array_push($categorie, $film['category']['attributes']["label"]);
}

$categoryCount = array_count_values($categorie);
$categoryMax = max($categoryCount);

foreach ($categoryCount as $item => $value) {
    if($value == $categoryMax) {
        echo "La categorie la plus présente est: " . $item . ".<br>";
    }
}

//exo 7
$realisateur = [];
foreach ($top as $film) {
    array_push($realisateur, trim($film['im:artist']['label']));
}

$realisateurCount = array_count_values($realisateur);
$realisateurMax = max($realisateurCount);

foreach ($realisateurCount as $item => $value) {
    if($value == $realisateurMax) {
        echo "Le réalisateur le plus présent est: " . $item . ".<br>";
    }
}

//exo 8
$prixAchat = 0;
$prixLocation = 0;

for($x = 0; $x < 10; $x++) {
    $prixAchat = $prixAchat + $top[$x]['im:price']['attributes']['amount'];
    $prixLocation = $prixLocation + $top[$x]['im:rentalPrice']['attributes']['amount'];
}

echo "Le prix d'achat pour le top 10 des films est : " . $prixAchat . " $ <br>";
echo "Le prix de location pour le top 10 des films est : " . $prixLocation . " $ <br>";

//exo 9
$months = [];
foreach ($top as $film) {
    $month = explode(" ", $film['im:releaseDate']['attributes']['label']);
    array_push($months, $month[0]);
}

$monthsCount = array_count_values($months);
$monthsMax = max($monthsCount);

foreach ($monthsCount as $item => $value) {
    if($value === $monthsMax) {
        echo "Le mois ayant eu le plus de sortie est : " . $item . ".<br>";
    }
}

echo "<br>";

//exo 10
$prixMin = [];
foreach ($top as $film) {
    $prixMin[$film['im:name']['label']] = $film['im:price']['label'];
}

arsort($prixMin);
$val = 0;

foreach ($prixMin as $item => $price) {
    if($val < 10) {
        echo ($val + 1) . " - " . $item . " au prix de " . $price . " $ <br>";
        $val++;
    }
}