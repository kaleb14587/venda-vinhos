<?php


namespace App\Managers;


use App\Models\Cliente;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class MetricasManager extends Manager
{

    /**
     * @return mixed
     */
    function baseQuery()
    {
        return Cliente::join('compras_clientes', 'clientes.id', '=', 'compras_clientes.cliente_id')->
        join('compras', 'compras_clientes.compra_id', '=', 'compras.id')->
        join('compras_items', 'compras.id', '=', 'compras_items.compra_id')->
        join('items', 'compras_items.item_id', '=', 'items.id')
            ->selectRaw('sum(compras.valorTotal) as total, clientes.nome')
            ->groupBy('clientes.id');
    }

    /**
     * @param Builder $query
     * @param array $filters
     * @return mixed|void
     */
    function filter(Builder &$query, array $filters)
    {
    }

    /**
     * @param Builder $query
     * @param array $orders
     * @return mixed|void
     */
    function order(Builder &$query, array $orders)
    {
        $query->orderBy('total', "desc");
    }

    /**
     * @param string $ano
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function clienteMaiorCompra(string $ano)
    {
        /** @var Builder $qb */
        $qb = Cliente::
        select(['compras.valorTotal','compras.id as id_compra', 'clientes.nome', 'clientes.cpf'])->
        join('compras_clientes', 'clientes.id', '=', 'compras_clientes.cliente_id')->
        join('compras', 'compras_clientes.compra_id', '=', 'compras.id');

        return $qb->whereYear('compras.created_at', $ano)
            ->orderBy('compras.valorTotal', 'desc')->first();
    }

    /**
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function clienteMaisFiel()
    {
        /** @var Builder $qb */
        $qb = Cliente::withCount('compras')->orderBy('compras_count', 'desc');
        return $qb->first();
    }

    public function indicacaoPorCliente()
    {
        $qb = DB::select("select 
        clientes.nome,
        clientes.cpf,
        compras_clientes.cliente_id, 
        items.produto,
        variedade,
        pais,
        categoria,
        safra,count(items.produto) total from 
        clientes 
        inner join compras_clientes on clientes.id=compras_clientes.cliente_id
        left join compras_items on compras_items.compra_id = compras_clientes.compra_id
        left join items on compras_items.item_id = items.id

        group by compras_clientes.cliente_id,items.produto,
        clientes.nome,
        clientes.cpf,
        items.variedade,
        items.pais,
        items.categoria,
        items.safra
        order by compras_clientes.cliente_id desc, total desc");

        $this->removeRegistrosIndesejadosIndicacaoPorCliente($qb);
        return $qb;
    }

    private function removeRegistrosIndesejadosIndicacaoPorCliente(&$result)
    {
        $aux = [];
        $id_cliente = 0;
        foreach ($result as $indi) {
            if ($id_cliente != $indi->cliente_id) {
                $id_cliente = $indi->cliente_id;
                $aux[] = $indi;
            }
        }
        $result = $aux;
    }
}
