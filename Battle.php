<?php
require_once 'Hero.php';
class Battle {
    private $heroes;
    private $rounds;
    private $history;

    public function __construct($heroes) {
        $this->heroes = $heroes;
        $this->rounds = 0;
        $this->history = [];
    }

    public function getHeroes() {
        return $this->heroes;
    }

    public function getRounds() {
        return $this->rounds;
    }

    public function startBattle() {
        foreach ($this->heroes as $hero) {
            if ($hero === null) {
                throw new Exception("One of the heroes is null.");
            }
        }

        while (count(array_filter($this->heroes, function($hero) { return $hero->isAlive(); })) > 1) {
            $this->rounds++;
            $attacker = $this->getRandomHero();
            $defender = $this->getRandomHero($attacker);

            if ($attacker === null || $defender === null) {
                continue;
            }

            $result = $attacker->attack($defender);
            $this->history[] = [
                'round' => $this->rounds,
                'attacker' => $attacker->getId(),
                'defender' => $defender->getId(),
                'result' => $result,
                'attacker_health' => $attacker->getHealth(),
                'defender_health' => $defender->getHealth()
            ];
        }

        return [
            'rounds' => $this->rounds,
            'history' => $this->history
        ];
    }

    private function getRandomHero($excludeHero = null) {
        $aliveHeroes = array_filter($this->heroes, function($hero) use ($excludeHero) {
            return $hero->isAlive() && $hero !== $excludeHero;
        });

        if (empty($aliveHeroes)) {
            return null;
        }

        return $aliveHeroes[array_rand($aliveHeroes)];
    }

    private function simulateRound() {
        $attacker = $this->selectRandomAliveHero();
        $defender = $this->selectRandomAliveHero($attacker->getId());

        $attackResult = $attacker->attack($defender);
        $this->history[] = [
            'round' => $this->rounds,
            'attacker' => $attacker->getType(),
            'defender' => $defender->getType(),
            'action' => $attackResult,
            'heroes' => $this->getHeroesStatus()
        ];

        foreach($this->heroes as $hero) {
            $hero->heal(10);
        }
    }

    private function countAliveHeroes() {
        $aliveCount = 0;
        foreach ($this->heroes as $hero) {
            if ($hero->isAlive()) {
                $aliveCount++;
            }
        }
        return $aliveCount;
    }

    private function selectRandomAliveHero($excludeId = null) {
        $aliveHeroes = [];
        foreach ($this->heroes as $hero) {
            if ($hero->isAlive() && $hero->getId() != $excludeId) {
                $aliveHeroes[] = $hero;
            }
        }
        $randomIndex = array_rand($aliveHeroes);
        return $aliveHeroes[$randomIndex];
    }

    private function getHeroesStatus() {
        $heroesStatus = [];
        foreach ($this->heroes as $hero) {
            $heroesStatus[] = [
                'type' => $hero->getType(),
                'health' => $hero->getHealth()
            ];
        }
        return $heroesStatus;
    }

    private function recordFinalSurvivor() {
        foreach ($this->heroes as $hero) {
            if ($hero->isAlive()) {
                $this->history[] = [
                    'round' => $this->rounds + 1,
                    'attacker' => null,
                    'defender' => $hero->getType(),
                    'action' => 'Survivor',
                    'heroes' => $this->getHeroesStatus()
                ];
                break;
            }
        }
    }
}
?>