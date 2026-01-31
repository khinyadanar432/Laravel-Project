protected $routeMiddleware = [
    // ... other middlewares
    'student' => \App\Http\Middleware\StudentMiddleware::class,
    'faculty' => \App\Http\Middleware\FacultyMiddleware::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];