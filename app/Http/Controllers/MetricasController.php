<?php

namespace App\Http\Controllers;

use App\Managers\MetricasManager;
use Illuminate\Http\Request;

class MetricasController extends Controller
{
    public function index(Request $request, MetricasManager $manager)
    {
        $retorno = [
            'paginas_clientes' => $manager->paginateData([], [], ($request->get('page')??1)),
            'cliente_maior_compra_2016' => $manager->clienteMaiorCompra('2016'),
            'cliente_mais_fiel' => $manager->clienteMaisFiel(),
            'indicacoes_p_clientes' => $manager->indicacaoPorCliente()
        ];

        return $retorno;
    }
}
