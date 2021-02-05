#!/usr/bin/env php
<?php

namespace App\Buscador;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;

class BuscadorGeral
{

    private $cliente;
    private $navegador;
    private string $html;

    //CRIANDO CLIENTE HTML E ACESSANDO URL /////////////////////////////////////////////////////////////////
    /* definindo url e caminho
     * definindo cliente
     * base url de acesso
     * desativando verificador SSL (?)
     * tratando requisição: método de acesso e complementando url
     * pegar corpo do site
     * criando navegador
     * adicionando o corpo do site ao navegador
     * definindo filtro para coleta
    */
    public function __construct(string $url)
    {
        $this->cliente = new Client([
            "base_uri" => $url,
            'verify' => false
        ]);
        $this->navegador = new Crawler();
    }

    /*
     * public function __construct(string $url, string $path, int $method) {
        $resposta = null;
        $this->cliente = new Client([
            "base_uri" => $url,
            'verify' => false
        ]);
        $this->navegador = new Crawler();
        $method = $method !== 0 ?  'GET' : 'POST';
        try {
            $resposta = $this->cliente->request($method, $path);
        }
        catch (GuzzleException $e) {
            throwException($e);
        }
        $this->html = $resposta->getBody();
        $this->navegador->addHtmlContent($this->html);
            }
     */

    public function setHttpClient(ClientInterface $client): void
    {
        $this->cliente = $client;
    }

    public function buscarArray(string $path, string $tag)
    {
        try {
            $resposta = $this->cliente->request('GET', $path);
            $this->html = $resposta->getBody();
            $this->navegador->addHtmlContent($this->html);
            $bodyTag = $this->navegador->filter($tag);
            $itens = [];
            foreach ($bodyTag as $elemento) {
                $itens[] = $elemento->textContent;
            }
            return $itens;
        } catch (GuzzleException $e) {
            return new Exception($e);
        }
    }

    public function buscarString(string $path, string $tag): string
    {
        try {
            $resposta = $this->cliente->request('GET', $path);
            $this->html = $resposta->getBody();
            $this->navegador->addHtmlContent($this->html);
            $bodyTag = $this->navegador->filter($tag)->text();
            return $bodyTag;
        } catch (Throwable $e) {
            echo $e->getMessage() . PHP_EOL;
            echo $e->getTraceAsString() . PHP_EOL;
            return "";
        }
    }

    /**
     * @return Client
     */
    public function getCliente(): Client
    {
        return $this->cliente;
    }

    /**
     * @param Client $cliente
     */
    public function setCliente(Client $cliente): void
    {
        $this->cliente = $cliente;
    }

    /**
     * @return Crawler
     */
    public function getNavegador(): Crawler
    {
        return $this->navegador;
    }

    /**
     * @param Crawler $navegador
     */
    public function setNavegador(Crawler $navegador): void
    {
        $this->navegador = $navegador;
    }

    /**
     * @return \Psr\Http\Message\StreamInterface|string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @param \Psr\Http\Message\StreamInterface|string $html
     */
    public function setHtml($html): void
    {
        $this->html = $html;
    }
}
