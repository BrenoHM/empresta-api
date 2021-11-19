<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instituicao;
use App\Models\Convenio;

class SimulacaoController extends Controller
{
    //

    public function simulacao(Request $request)
    {

        $request->validate([
            'valor_emprestimo' => 'required|numeric|gt:0',
        ]);
        
        $instituicoes = $request->instituicoes ? $request->instituicoes : Instituicao::getAll('chave');

        $convenios    = $request->convenios ? $request->convenios : Convenio::getAll('chave');

        $taxas        = collect(json_decode(file_get_contents(database_path('taxas_instituicoes.json'))));

        $result = [];

        foreach( $instituicoes as $instituicao ) {

            foreach($convenios as $convenio) {

                $taxa = $taxas->where('instituicao', strtoupper($instituicao))->where('convenio', strtoupper($convenio));

                if( $taxa ) {

                    foreach( $taxa as $t ) {

                        $item = [
                            "taxa" => $t->taxaJuros,
                            "parcelas" => $t->parcelas,
                            "valor_parcela" => round($request->valor_emprestimo * $t->coeficiente, 2),
                            "convenio" => $t->convenio
                        ];

                        if( $request->parcela != 0 ){

                            if( $request->parcela == $t->parcelas ){

                                if(!isset($result[$instituicao])){
                                    $result[$instituicao] = [];
                                }
                        
                                array_push($result[$instituicao], $item);

                            }

                        }else{

                            if(!isset($result[$instituicao])){
                                $result[$instituicao] = [];
                            }

                            array_push($result[$instituicao], $item);
                        }
                    }
                }

            }

        }
        
        return $result;
    }
}
