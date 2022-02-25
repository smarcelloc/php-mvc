<?php

namespace App\Middleware;

use App\Http\Request;
use App\Http\Response;
use Closure;
use Exception;
use Throwable;
use TypeError;

class Queue
{
    private static array $middlewareMap = [];
    private static array $middlewareDefault = [];

    public function __construct(
        private Closure $controller,
        private array $controllerParams = [],
        private array $middleware = []
    ) {
        $this->middleware = array_merge(self::$middlewareDefault, $middleware);
    }

    public function next(Request $request): Response
    {
        if (empty($this->middleware)) {
            return $this->executeController();
        }

        $middleware = array_shift($this->middleware);

        if (!isset(self::$middlewareMap[$middleware])) {
            throw new Exception("Error processing middleware", 500);
        }

        $queue = $this;
        $next = function (Request $request) use ($queue) {
            return $queue->next($request);
        };

        return (new self::$middlewareMap[$middleware])->handle($request, $next);
    }

    public static function setMap(array $middlewareMap)
    {
        self::$middlewareMap = $middlewareMap;
    }

    public static function setDefault(array $middlewareDefault = [])
    {
        self::$middlewareDefault = $middlewareDefault;
    }

    private function executeController()
    {
        try {
            return call_user_func_array($this->controller, $this->controllerParams);
        } catch (TypeError $ex) {
            throw new Exception("URL not found", 404, $ex);
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
