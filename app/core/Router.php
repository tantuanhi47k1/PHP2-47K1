<?php
class Router
{
    public function dispatch(string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '';
        $path = trim($path, '/');

        $basePath = $this->basePath();
        if ($basePath !== '' && str_starts_with($path, $basePath)) {
            $path = trim(substr($path, strlen($basePath)), '/');
        }

        $segments = $path === '' ? [] : explode('/', $path);

        $controllerName = ucfirst($segments[0] ?? 'home') . 'Controller';
        $action = $segments[1] ?? 'index';
        $params = array_slice($segments, 2);

        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            $this->notFound("Controller '$controllerName' not found");
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            $this->notFound("Class '$controllerName' does not exist");
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            $this->notFound("Method '$action' not found in '$controllerName'");
            return;
        }

        call_user_func_array([$controller, $action], $params);
    }

    public function basePath(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $dir = trim(dirname($scriptName), '/');
        return $dir;
    }

    public function notFound($message): void
    {
        http_response_code(404);
        echo "<div style='text-align: center; margin-top: 50px;'>";
        echo "<h1 style='color: red; font-size: 3em;'>404 Not Found</h1>";
        echo "<p style='font-size: 1.5em; color: #555;'>" . htmlspecialchars($message) . "</p>";
        echo "<a href='/' style='text-decoration: none; background: #007bff; color: white; padding: 10px 20px; border-radius: 5px;'>Về trang chủ</a>";
        echo "</div>";
    }
}