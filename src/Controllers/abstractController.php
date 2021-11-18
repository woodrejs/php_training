<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exception\ConfigurationException;
use App\Request;
use App\View;
use App\Database;


abstract class AbstractController
{
    protected const DEFAULT_ACTION = 'list';

    private static array $config = [];

    protected Request $request;
    protected View $view;
    protected Database $db;

    public static function initConfiguration($config): void
    {
        self::$config = $config;
    }
    public function __construct(Request $request)
    {

        $this->request = $request;
        $this->view = new View();

        if (empty(self::$config['db'])) {
            throw new ConfigurationException('Configuration error');
        }

        $this->db = new Database(self::$config['db']);
    }
    public function run(): void
    {
        $action = $this->getAction() . 'Action';

        if (!method_exists($this, $action)) {
            $action = self::DEFAULT_ACTION . 'Action';
        }

        $this->$action();
    }
    protected function redirect(string $path, array $params): void
    {

        $redirectParams = [];

        foreach ($params as $key => $value) {
            $redirectParams[] = urlencode($key) . '=' . urlencode($value);
        };

        $redirectParams = implode('&', $redirectParams);
        $location = $path . '?' . $redirectParams;


        header("Location: $location");
        exit;
    }

    private function getAction(): string
    {
        return $this->request->getPara('action', self::DEFAULT_ACTION);
    }
}