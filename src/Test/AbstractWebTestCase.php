<?php
namespace App\Test;

use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractWebTestCase extends WebTestCase
{
    private AbstractDatabaseTool $databaseTool;

    protected function loadFixtures(): void
    {
        $this->databaseTool = static::getContainer()
            ->get(DatabaseToolCollection::class)
            ->get();

        // Load all fixtures
        $this->databaseTool->loadAllFixtures();
    }
}