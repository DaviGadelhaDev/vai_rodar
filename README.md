Configurar E-mail recuperar senha
-> php artisan vendor:publish --tag=laravel-mail

colocar no arquivo env 
-> http://127.0.0.1:8000/reset-password/d149dea32b8c52e9ea2a81aa90da4d69cb79939fc03c6b2cd69009125704286e&email=davi%40teste.com
AuthServiceProvider.php
->public function boot():void
{
    ResetPassword::createUrlUsing(function(User $user, string $token){
        return env('APP_URL') . "/reset-password/$token";
    })
}