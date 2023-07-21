<?php

namespace App\Controller;

use App\Core\Controller;
use Exception;
use function searchCotation;

class TrackController extends Controller
{

    public function freightBraspress($request, $response, array $args)
    {

        $query = $request->getParams();

        $xmlResponse = array(
            'cotacao' => array()
        );

        if ($query['token'] !== "123ABC456DEF") {
            return $response->write($xmlResponse);
        }

        $prods = explode("/", $query['prods']);

        foreach ($prods as $prod) {

            $prod = explode(";", $prod);

            // Metros = Double
            $query['comprimento']   += $prod[0];

            $query['volumes']       += 1;

            // Metros = Double
            $query['largura']       += $prod[1];

            // Metros = Double
            $query['altura']        += $prod[2];

            // Metros Cúbicos = Double
            $query['cubagem']       += $prod[3];

            // Metros = Int
            $query['quantidade']    += $prod[4];

            // Kg = Double
            $query['peso']          += $prod[5];

            // Código do Produto = String
            $query['codProduto'][]  = $prod[6];

            // Unitário = Double
            $query['valor']         += $prod[7];
        }

        $freightReturn = searchCotation(
            $this->settings["api"]["apiUrl"],
            $this->settings["api"]["apiUser"],
            $this->settings["api"]["apiPass"],
            [
                "cnpjRemetente" => "45844254000124",
                "cnpjDestinatario" => "45844254000124",
                "modal" => "R",
                "tipoFrete" => 1,
                "cepOrigem" => $query['cep'],
                "cepDestino" => $query['cep_destino'],
                "vlrMercadoria" => $query['valor'],
                "peso" => $query['peso'],
                "volumes" => $query['volumes'],
                "cubagem" => [[
                    "altura" => $query['altura'],
                    "largura" => $query['largura'],
                    "comprimento" => $query['comprimento'],
                    "volumes" => 1
                ]]
            ]
        );

        $xmlResponse = array(
            'cotacao' => array(
                'resultado' => array(
                    "codigo" => $freightReturn->id,
                    "transportadora" => "BRASPRESS",
                    "servico" => "EXPRESSO",
                    "transporte" => "TERRESTRE",
                    "valor" => $freightReturn->totalFrete,
                    "peso" => $query['peso'],
                    "prazo_min" => $freightReturn->prazo,
                    "prazo_max" => $freightReturn->prazo,
                ),
            )
        );

        $xml_string = arrayToXml($xmlResponse);

        return $response->write($xml_string);

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
