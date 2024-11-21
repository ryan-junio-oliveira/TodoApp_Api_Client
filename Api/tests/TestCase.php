<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase; // Garantir que o banco de dados será resetado após cada teste

    /**
     * Configure o ambiente de testes.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Realiza a migração para garantir que as tabelas estejam no banco de dados em memória
        Artisan::call('migrate');
    }
}
