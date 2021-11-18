<?php

declare(strict_types=1);

namespace App;


class Request
{
    private array $get = [];
    private array $post = [];
    private array $server = [];


    public function __construct(array $get, array $post, array $server)
    {
        $this->server = $server;
        $this->get = $get;
        $this->post = $post;
    }

    public function getPara(string $name, $default = [])
    {
        return $this->get[$name] ?? $default;
    }
    public function postPara(string $name, $default = [])
    {
        return $this->post[$name] ?? $default;
    }
    public function hasPost()
    {
        return !empty($this->post);
    }
    public function isPost(): bool
    {
        return $this->server['REQUEST_METHOD'] === 'POST';
    }
    public function isGet(): bool
    {
        return $this->server['REQUEST_METHOD'] === 'GET';
    }
}