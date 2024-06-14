<?php
use PHPUnit\Framework\TestCase;
require_once 'Battle.php';

class BattleTest extends TestCase {
    public function testBattleInitialization() {
        $archer = new Archer(1);
        $horseman = new Horseman(2);
        $swordsman = new Swordsman(3);
        $heroes = [$archer, $horseman, $swordsman];

        $battle = new Battle($heroes);

        $this->assertCount(3, $battle->getHeroes());
        $this->assertEquals(0, $battle->getRounds());
    }

    public function testStartBattle() {
        $archer = new Archer(1);
        $horseman = new Horseman(2);
        $swordsman = new Swordsman(3);
        $heroes = [$archer, $horseman, $swordsman];

        $battle = new Battle($heroes);
        $battleHistory = $battle->startBattle();

        // Check battle history structure and content
        $this->assertIsArray($battleHistory);
        $this->assertArrayHasKey('rounds', $battleHistory);
        $this->assertArrayHasKey('history', $battleHistory);
        $this->assertNotEmpty($battleHistory['history']);
    }
}
?>