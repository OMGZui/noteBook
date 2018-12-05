# Facade 门面

<!-- TOC -->

- [Facade 门面](#facade-门面)
    - [一、问题](#一问题)
    - [二、原理](#二原理)
    - [三、别名Aliases](#三别名aliases)
    - [四、启动Aliases](#四启动aliases)

<!-- /TOC -->

前言：Facade到底是如何实现的

## 一、问题

我们经常看到

```php
Route::get('/', function () {
    return view('welcome');
});
```

其实就是等价于

```php
app('router')->get('/', function () {
    return view('welcome');
});
// 本质
\Illuminate\Container\Container::getInstance()->make('router')->get('/', function () {
    return view('welcome');
});
```

## 二、原理

比如Route

```php
// vendor/laravel/framework/src/Illuminate/Support/Facades/Route.php
class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'router';
    }
}

// vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php
abstract class Facade
{
    // 在容器中解析出'router'实例
    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        return static::$resolvedInstance[$name] = static::$app[$name];
    }

    // 拿到门面'router'
    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    // 魔术方法返回
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }
}

```

我们为什么可以直接`Route::get()`呢，是因为Facade里的魔术方法`__callStatic()`，可以动态的处理一系列静态函数。

## 三、别名Aliases

主要是用了函数`class_alias()(为一个类创建别名)`

```php
// config/app.php
'aliases' => [
    'Route' => Illuminate\Support\Facades\Route::class,
]
```

## 四、启动Aliases

```php
// public/index.php
// composer自动加载
require __DIR__.'/../vendor/autoload.php';
// 获取IOC容器
$app = require_once __DIR__.'/../bootstrap/app.php';
// 制造出http请求内核
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
// laravel里面所有功能服务的注册加载，乃至Http请求的构造与传递都是这一句的功劳。
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php
class Kernel implements KernelContract
{
    protected $bootstrappers = [
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
    ];

    // 处理http请求
    public function handle($request)
    {
        $response = $this->sendRequestThroughRouter($request);
    }

    protected function sendRequestThroughRouter($request)
    {
        $this->app->instance('request', $request);

        Facade::clearResolvedInstance('request');

        $this->bootstrap();

        return (new Pipeline($this->app))
                    ->send($request)
                    ->through($this->app->shouldSkipMiddleware() ? [] : $this->middleware)
                    ->then($this->dispatchToRouter());
    }

    public function bootstrap()
    {
        if (! $this->app->hasBeenBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrappers());
        }
    }
}

// vendor/laravel/framework/src/Illuminate/Foundation/Application.php
class Application extends Container implements ApplicationContract, HttpKernelInterface
{
    // 利用组件进行启动服务
    public function bootstrapWith(array $bootstrappers)
    {
        $this->hasBeenBootstrapped = true;

        foreach ($bootstrappers as $bootstrapper) {
            $this['events']->dispatch('bootstrapping: '.$bootstrapper, [$this]);

            $this->make($bootstrapper)->bootstrap($this);

            $this['events']->dispatch('bootstrapped: '.$bootstrapper, [$this]);
        }
    }
}
// vendor/laravel/framework/src/Illuminate/Foundation/Bootstrap/RegisterFacades.php
class RegisterFacades
{
    public function bootstrap(Application $app)
    {
        // 清除Facade缓存实例
        Facade::clearResolvedInstances();
        // 设置Facade的IOC容器
        Facade::setFacadeApplication($app);
        // 注册aliases
        AliasLoader::getInstance(array_merge(
            $app->make('config')->get('app.aliases', []),
            $app->make(PackageManifest::class)->aliases()
        ))->register();
    }
}
// vendor/laravel/framework/src/Illuminate/Foundation/AliasLoader.php
class AliasLoader
{
    public function register()
    {
        if (! $this->registered) {
            $this->prependToLoaderStack();

            $this->registered = true;
        }
    }

    protected function prependToLoaderStack()
    {
        // 在自动加载中这个函数用于解析命名空间，在这里用于解析别名的真正类名。
        spl_autoload_register([$this, 'load'], true, true);
    }

    public function load($alias)
    {
        if (static::$facadeNamespace && strpos($alias, static::$facadeNamespace) === 0) {
            $this->loadFacade($alias);

            return true;
        }

        // 最终的落实处
        if (isset($this->aliases[$alias])) {
            return class_alias($this->aliases[$alias], $alias);
        }
    }

}
```