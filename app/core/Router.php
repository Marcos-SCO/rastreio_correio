<?php

namespace App\Core;

class Router
{
    private $routes;

    public function __construct(array $routes)
    {
        $this->setRoutes($routes);
        $this->run();
    }

    private function setRoutes($routes)
    {
        foreach ($routes as $route) {
            // $route[1] : obj / method
            $explode = explode('@', $route[1]);

            // $r = route / obj / method
            $r = [$route[0], $explode[0], $explode[1]];

            $newRoutes[] = $r;
        }

        $this->routes = $newRoutes;
    }

    private function getUrl()
    {
        $uri = isset($_GET['route']) ? $_GET['route'] : '/';

        // Get url path
        return filter_var($uri, FILTER_SANITIZE_URL);
    }

    public function run()
    {
        $url = $this->getUrl();
        $urlArray = explode('/', $url);

        foreach ($this->routes as $route) {
            // $route[0] : /routeName/{param?}

            $routeArray = explode('/', $route[0]);
            $params = [];

            for ($i = 0; $i < count($routeArray); $i++) {
                if ((strpos($routeArray[$i], "{") !== false) && (count($urlArray) == count($routeArray))) {
                    // $routeArray[{param}] = paramValue
                    $routeArray[$i] = $urlArray[$i];
                    $params[] = $urlArray[$i];
                }
                // routeName/params
                $route[0] = implode('/', $routeArray);
            }

            // Verifies browser url with the formed one 
            if ($url == $route[0]) {
                $found = true;
                $controller = $route[1];
                $action = $route[2];

                break;
            }
        }

        if (isset($found)) {
            $controller = $this->newController($controller);

            /*switch (count($param)) {
                case 1:
                    $controller->$action($param[0], $this->getRequest());
                    break;
                case 2:
                    $controller->$action($param[0], $param[1], $this->getRequest());
                    break;
                case 3:
                    $controller->$action($param[0], $param[1], $param[2], $this->getRequest());
                    break;
                default:
                    $controller->$action($this->getRequest());
            }*/

            // Call obj and method with params
            call_user_func_array([$controller, $action], $params);
        } else {
            throw new \Exception("Não encontrado!");
        }
    }

    public function newController($controller)
    {
        $objController = "App\\Controllers\\" . $controller;

        return new $objController;
    }

    /* public function getModel($model)
    {
        $objModel = "\\App\\Models\\" . $model;
        return new $objModel(DataBase::getDatabase());
    } */

    /* private function getRequest()
    {
        $obj = new \stdClass;

        foreach ($_GET as $key => $value) {
            @$obj->get->$key = $value;
        }

        foreach ($_POST as $key => $value) {
            @$obj->post->$key = $value;
        }

        return $obj;
    }*/
}
