<?php

namespace Controller;

use Model\Imcs;

use Exception;

class ImcController {
    private $ImcsModel;

    public function __construct() {
        $this->ImcsModel = new Imcs();
    }

    // CÁLCULO E CLASSIFICAÇÃO
    public function calculateImc($weight, $height) {
        try {
            /**
             * $result = [
             *  "imc": 22.82,
             *  "BMIrange": "Sobrepeso"
             * ]
             */

            $result = [];

            if(isset($weight) and isset($height)) {
                if($weight > 0 and $height > 0) {
                    $imc = round($weight / ($height * $height), 2);
                    $result['imc'] = $imc;

                    $result['BMIrange'] = match (true) {
                        $imc < 18.5 => 'Baixo peso',
                        $imc >= 18.5 and $imc < 25 => 'Peso normal',
                        $imc >= 25 and $imc < 30 => 'Sobrepeso',
                        $imc >= 30 and $imc < 35 => 'Obesidade grau I',
                        $imc >= 35 and $imc < 40 => 'Obesidade grau II',
                        default => 'Obesidade grau III'
                    };
                }
                else {
                    $result['BMIrange'] = "Por favor, insira valores positivos";
                }
            }
            else {
                $result['BMIrange'] = "Por favor, informe peso e altura";
            }

            return $result;
        }
        catch (Exception $error) {
            echo "Erro ao calcular o IMC: " . $error->getMessage();
            return false;
        }
    }

    // SALVAR IMC NA TABELA 'imcs'

    // PEGAR PESO, ALTURA E RESULTADO DO FRONT E ENVIAR PARA O BANCO DE DADOS
    public function saveIMC($weight, $height, $IMCresult) {
        return $this->ImcsModel->createImc($weight, $height, $IMCresult);
    }
}

?>