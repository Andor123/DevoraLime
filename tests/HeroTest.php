<?php
use PHPUnit\Framework\TestCase;
require_once "Hero.php";

class HeroTest extends TestCase {
    public function testHealthInitialization() {
        $hero = new Archer(1);
        $this->assertEquals(100, $hero->getHealth());
        $this->assertEquals(100, $hero->getMaxHealth());
    }

    public function testAttackMethod() {
        $archer = new Archer(1);
        $horseman = new Horseman(2);

        $result = $archer->attack($horseman);

        $this->assertStringContainsString('caused damage', $result);
        $this->assertGreaterThanOrEqual(0, $horseman->getHealth());
    }

    public function testDefendMethod() {
        $horseman = new Horseman(1);
        $archer = new Archer(2);

        $result = $horseman->defend($archer);

        $this->assertStringContainsString('defended agains', $result);
        $this->assertGreaterThanOrEqual(0, $horseman->getHealth());
    }
}
?>