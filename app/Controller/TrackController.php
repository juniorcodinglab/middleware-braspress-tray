<?php
namespace App\Controller;

use App\Core\Controller;
use Exception;
use function searchCotation;

class TrackController extends Controller{
    
    public function freightBraspress($request, $response, array $args){

        $freightReturn = searchCotation(
            $this->settings["api"]["apiUrl"], 
            $this->settings["api"]["apiUser"], 
            $this->settings["api"]["apiPass"], 
            [
                "cnpjRemetente" => "45844254000124",
                "cnpjDestinatario" => "45844254000124",
                "modal" => "R",
                "tipoFrete" => 1,
                "cepOrigem" => "19045600",
                "cepDestino" => "19045630",
                "vlrMercadoria" => 100.00,
                "peso" => 1,
                "volumes" => 1,
                "cubagem" => [[
                    "altura" => 0.46,
                    "largura" => 0.67,
                    "comprimento" => 0.67,
                    "volumes" => 1
                ]]
            ]
        );


        $xml = [
            "resultado" => [
                "codigo" => $freightReturn->id,
                "transportadora" => "BRASPRESS",
                "servico" => "EXPRESSO",
                "transporte" => "TERRESTRE",
                "valor" => $freightReturn->totalFrete,
                "peso" => 1,
                "prazo_min" => $freightReturn->prazo,
                "prazo_max" => $freightReturn->prazo,
            ]
        ];

        /**
         * 
         <cotacao>
            <resultado>
                <codigo>03220</codigo>
                <transportadora></transportadora>
                <servico>SEDEX</servico>
                <transporte>TERRESTRE</transporte>
                <valor>111.34</valor>
                <peso>5.334</peso>
                <prazo_min>2</prazo_min>
                <prazo_max>2</prazo_max>
                <imagem_frete>https://fretefacil.tray.com.br/images/sedex.png</imagem_frete>
                <aviso_envio></aviso_envio>
                <entrega_domiciliar>1</entrega_domiciliar>
            </resultado>
        </cotacao>
         */

    }
}
