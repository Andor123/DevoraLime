<?php
require_once 'Battle.php';
require_once 'Hero.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    if ($_GET['action'] === 'generateHeroes') {
        $numberOfHeroes = $_POST['numberOfHeroes'];
        generateHeroes($numberOfHeroes);
    } elseif ($_GET['action'] === 'startBattle') {
        $arenaId = $_POST['arenaId'];
        startBattle($arenaId);
    }
}

function generateHeroes($numberOfHeroes) {
    $heroes = [];
    for ($i = 0; $i < $numberOfHeroes; $i++) {
        $randomType = rand(1, 3);
        switch ($randomType) {
            case 1:
                $hero = new Archer($i + 1);
                break;
            case 2:
                $hero = new Horseman($i + 1);
                break;
            case 3:
                $hero = new Swordsman($i + 1);
                break;
        }
        $heroes[] = $hero;
    }
    $battle = new Battle($heroes);
    $arenaId = uniqid();
    echo "Arena ID: " . $arenaId;
}

function startBattle($arenaId) {
    $archer = new Archer(1);
    $horseman = new Horseman(2);
    $swordsman = new Swordsman(3);
    $heroes = [$archer, $horseman, $swordsman];

    $battle = new Battle($heroes);
    $battleHistory = $battle->startBattle();

    foreach ($battleHistory['history'] as $round) {
        echo "Round: " . $round['round'] . "<br>";
        echo "Attacker: " . $round['attacker'] . "<br>";
        echo "Defender: " . $round['defender'] . "<br>";
        echo "Result: " . $round['result'] . "<br>";
        echo "Attacker Health: " . $round['attacker_health'] . "<br>";
        echo "Defender Health: " . $round['defender_health'] . "<br><br>";
    }
}

function fetchAreanDataFromDatabase($arenaId) {
    $arenas = [
        '1234' => [
            'heroes' => [
                ['id' => 1, 'type' => 'Archer', 'health' => 100],
                ['id' => 2, 'type' => 'Knight', 'health' => 150],
                ['id' => 3, 'type' => 'Swordsman', 'health' => 120]
            ]
        ]
    ];

    return isset($arenas[$arenaId]) ? $arenas[$arenaId] : null;
}
?>