<?php

namespace Tests\Unit;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->getJson('/api')
            ->assertJsonStructure(
                [
                    'paginas_clientes' =>
                        [
                            "current_page",
                            "data",
                            "first_page_url",
                            "from",
                            "last_page",
                            "last_page_url",
                            "next_page_url",
                            "path",
                            "per_page",
                            "prev_page_url",
                            "to",
                            "total"
                        ],
                    'cliente_maior_compra_2016' => [
                        "valorTotal",
                        "id_compra",
                        "nome",
                        "cpf",
                    ],
                    'cliente_mais_fiel' => [],
                    'indicacoes_p_clientes' => []
                ]
            );
    }
}
