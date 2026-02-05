<?php 
    declare(strict_types = 1);

    namespace SimpleApi;

    class Api{
        // protected $router; 
         private array $routes = [
            'GET'  => [],
            'POST' => [],
            'PUT'  => [],
            'PATCH'=> [],
            'DELETE'=> [],
        ];

        public function get(string $pattern, callable $handler): void
        {
            $this->add('GET', $pattern, $handler);
        }

        public function post(string $pattern, callable $handler): void
        {
            $this->add('POST', $pattern, $handler);
        }

        public function add(string $method, string $pattern, callable $handler): void
        {
     
            $method = strtoupper($method);
            $routes = $this->routes[$method][] = [
                'pattern' => $pattern,
                'regex'   => $this->patternToRegex($pattern),
                'handler' => $handler,
            ];
         
        }

        public function dispatch(?string $method = null, ?string $uri = null): void
        {
            $method = strtoupper($method ?? ($_SERVER['REQUEST_METHOD'] ?? 'GET'));

            $uri = $uri ?? ($_SERVER['REQUEST_URI'] ?? '/');

            $path  = parse_url($uri, PHP_URL_PATH) ?? '/';
            $query = parse_url($uri, PHP_URL_QUERY); 

            $path = '/' . trim($path, '/');
            if ($path === '/') $path = '/';
        
           

            foreach ($this->routes[$method] ?? [] as $route) {
                
                if ($_GET){
                    call_user_func($route['handler'], ["params" => $_GET]);
                    return ; 
                }
           
                if (preg_match($route['regex'], $path, $matches)) {
                    
                    $params = array_filter($matches, fn($k) => !is_int($k), ARRAY_FILTER_USE_KEY);
                    call_user_func($route['handler'], $params);
                    return;
                }

                if (preg_match('#^(.*)/\{([a-zA-Z_][a-zA-Z0-9_]*)\}$#', $route['pattern'], $m)) {
                    $base   = rtrim('/' . trim($m[1], '/'), '/'); 
                    $paramName = $m[2];
                    if ($base === '') $base = '/';
                  
                    if ($path === $base) {
                     
                        if (!empty($query)) {
                            continue;
                        }
                        call_user_func($route['handler'], [$paramName => null]);
                        return;
                    }
                }
            }
            call_user_func($route['handler'], ["404" => "Page $uri not found"]);
            http_response_code(404);
        }

        private function patternToRegex(string $pattern): string
        {
            // Normalize: "/users/{id}" => "/users/{id}"
            $pattern = '/' . trim($pattern, '/');
            if ($pattern === '/') $pattern = '/';

            // Convert {param} to named regex group
            $regex = preg_replace_callback('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', function ($m) {
                $name = $m[1];
                return '(?P<' . $name . '>[^/]+)';
            }, $pattern);
            return '#^' . $regex . '$#';
        }
    }
?>