<?php

namespace App\Buscador;

class TextoFormatado
{

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function exibindoArray(BuscadorGeral $buscador, string $path, string $filtro)
    {
        $conteudo = $buscador->buscarArray($path, $filtro);
        self::printArray($conteudo);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function exibindoString(BuscadorGeral $buscador, string $path, string $filtro)
    {
        $conteudo = $buscador->buscarString($path, $filtro);
        echo self::tratarTexto($conteudo) . PHP_EOL;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Tratamento de texto para identificar pontuacao e quebrar linhas
     * @param string $texto eh o texto no qual sera quebrado em paragrafos pela pontuacao
     */
    public function tratarTexto(string $texto): string
    {
        // efinir pontuacao normal e pontuacao com caracteres especiais
        // caracteres especiais estes que fazem a quebra de linha
        $pontuacao = ["...", ".", "?", "!", ";"];
        $pontuacaoTratada = [
            "...@@" . PHP_EOL,
            ".@@" . PHP_EOL,
            "?@@" . PHP_EOL,
            "!@@" . PHP_EOL,
            ";@@" . PHP_EOL
        ];

        // subistituir pontuacao normal pela com pontuacao especial em forma de vetor
        $texto = str_replace($pontuacao, $pontuacaoTratada, $texto);
        $textoFinal = explode("@@", $texto);

        // remover espacos vazios
        foreach ($textoFinal as $i => $paragrafo) {
            $textoFinal[$i] = trim($paragrafo);
        }

        // retornar vetor concatenado em string
        return implode(PHP_EOL, $textoFinal);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function printArray(array $texto): void
    {
        foreach ($texto as $i => $paragrafo) {
            if (!empty($paragrafo)) {
                echo trim($paragrafo) . PHP_EOL;
            }
        }
    }
}
