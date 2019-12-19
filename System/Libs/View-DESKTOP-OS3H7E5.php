<?php 

namespace System\Libs;



class View{

    public static function renderTemplate($template, $args = []){

        $loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__DIR__)) . "/App/Views");
        $twig = new \Twig\Environment($loader);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('isloggedin', \System\Libs\Auth::isloggedin());
        
        $twig->addFunction(new \Twig\TwigFunction('asset', function ($asset) {

            return sprintf(dirname(__DIR__) .  '/App/Views/%s', ltrim($asset, '/'));}));
        
        echo $twig->render($template, $args);

    }

}


?>