<?php
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;

class Controller
{
    public function view(string $view, array $data = []): void
    {
        // chuẩn hoá tên view
        $view = $this->normalizeViewName($view);

        $viewsPath = VIEW_PATH;
        $cachePath = BASE_PATH . '/storage/cache';

        // tạo thư mục cache if chưa tồn tại
        if (!is_dir($cachePath) && !mkdir($cachePath, 0775, true) && !is_dir($cachePath)) {
            throw new RuntimeException("Cannot create cache directory: {$cachePath}");
        }
        
        $filesystem = new Filesystem;
        $eventDispatcher = new Dispatcher(new Container);

        $resolver = new EngineResolver;

        $resolver->register('blade', function () use ($filesystem, $cachePath) {
            $compiler = new BladeCompiler($filesystem, $cachePath);
            return new CompilerEngine($compiler);
        });

        $resolver->register('php', function () use ($filesystem) {
            return new PhpEngine($filesystem);
        });

        $finder = new FileViewFinder($filesystem, [$viewsPath]);

        $factory = new Factory($resolver, $finder, $eventDispatcher);

        try {
            echo $factory->make($view, $data)->render();
        } catch (Exception $e) {
            echo "Lỗi Blade View: " . $e->getMessage();
        }
    }

    protected function normalizeViewName(string $view): string
    {
        $view = trim($view);
        $view = str_replace(['\\', '/'], '.', $view);
        $view = preg_replace('/\.+/', '.', $view);
        return trim($view, '.');
    }

    public function model($name)
    {
        $class = ucfirst($name);
        if (!class_exists($class)) {
             $classWithNamespace = "App\\Models\\" . $class;
             if(class_exists($classWithNamespace)) {
                 return new $classWithNamespace();
             }
            throw new Exception("Model class not found: $name");
        }
        return new $class();
    }

    public function redirect($path)
    {
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');
        $target = $base . '/' . ltrim($path, '/');
        header('Location: ' . $target);
        exit;
    }

    public function notFound($message): void
    {
        http_response_code(404);
        echo "<h1>Controller Not Found - " . htmlspecialchars($message) . "</h1>";
        exit;
    }
}