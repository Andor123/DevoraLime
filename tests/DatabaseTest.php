<?php
use PHPUnit\Framework\TestCase;
require_once 'api.php';

class DatabaseTest extends TestCase {
    public function testFetchArenaDataFromDatabase() {
        $arenaId = '1234';
        $arenaData = fetchAreanDataFromDatabase($arenaId);

        $this->assertNotNull($arenaData);
        $this->assertArrayHasKey('heroes', $arenaData);
        $this->assertGreaterThanOrEqual(1, count($arenaData['heroes']));
    }
}
?>