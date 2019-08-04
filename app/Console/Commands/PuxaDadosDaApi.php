<?php

namespace App\Console\Commands;

use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Item;
use Illuminate\Console\Command;

class PuxaDadosDaApi extends Command
{
    const HISTORICO_COMPRAS_URL = "http://www.mocky.io/v2/598b16861100004905515ec7";
    const CLIENTES_URL = "http://www.mocky.io/v2/598b16291100004705515ec5";
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getdata2api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Data of 2 endpoints json';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = file_get_contents(self::CLIENTES_URL);
        $data = json_decode($data);
        foreach ($data as $cliente) {
            $c = Cliente::find($cliente->id);
            if (empty($c)) {
                Cliente::create([
                    'id' => $cliente->id,
                    'nome' => $cliente->nome,
                    'cpf' => $cliente->cpf
                ]);
            }
        }

        $data = file_get_contents(self::HISTORICO_COMPRAS_URL);
        $data = json_decode($data);
        foreach ($data as $hs) {
            $c = Compra::where('codigo', $hs->codigo)->first();
            if (!$c) {
                $data = date("Y-m-d", strtotime($hs->data));
                /** @var Compra $c */
                $c = Compra::create([
                    'cliente' => $hs->cliente,
                    'codigo' => $hs->codigo,
                    'created_at' => $data.' 00:00:00',
                    'valorTotal' => $hs->valorTotal,
                ]);

                foreach ($hs->itens as $item) {
                    $i = Item::create([
                        "produto"=> $item->produto,
                        "variedade"=> $item->variedade,
                        "pais"=> $item->pais,
                        "categoria"=> $item->categoria,
                        "safra"=> $item->safra,
                        'preco' => $item->preco
                    ]);
                    $c->items()->attach($i->id);
                }
            }
            $cliente_id = ltrim(str_replace('.','', $hs->cliente), '0');
            /** @var Cliente $cliente */
            $cliente = Cliente::find($cliente_id);
            $cliente->compras()->attach($c->id);
        }
    }
}
