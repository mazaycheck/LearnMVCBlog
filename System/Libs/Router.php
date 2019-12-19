<?php 

namespace System\Libs;

class Router{

    public function __construct()
    {
        //echo "Route object created <br>";
        
    }

    public function dispatchUrl($url){
        $url = explode('&', $url, 2)[0];        
        $url = rtrim($url, '/');

        $route_table = [

            '/^$/' => array('controller' => 'Home', 'action' => 'index'),
            '/^index$/' => array('controller' => 'Home', 'action' => 'index'),


            //admin root
            '/^(?P<rootpath>admin\/)(?P<controller>[a-z]+)$/i' => array('action' => 'index'),
            '/^(?P<rootpath>admin\/)(?P<controller>[a-z]+)\/(?P<action>[a-z]+)$/i' => array(),
            '/^(?P<rootpath>admin\/)(?P<controller>[a-z]+)\/(?P<action>[a-z]+)\/(?P<param>\d+)$/i' => array(),            
            // root
            '/^(?P<controller>[a-z]+)$/i' => array('action' => 'index'),
            '/^(?P<controller>[a-z]+)\/(?P<action>[a-z]+)$/i' => array(),
            '/^(?P<controller>[a-z]+)\/(?P<action>[a-z]+)\/(?P<param>\d+)$/i' => array(),

                  

            
            
        ];

        foreach ($route_table as $regexurl => $route) {
            if(preg_match($regexurl, $url, $matches)){
                
                $params = ['controller', 'action' , 'param', 'rootpath'];

                foreach ($params as $par) {
                    $route[$par] = $matches[$par] ?? $route[$par] ?? '';
                }


                return $route;
            }
        }

        return False;


    }

    public function executeUrl($url){

        $params = $this->dispatchUrl($url);

        if($params){
            // echo '<pre>';
            // print_r($params);
            // echo '</pre>';
            
        $controller = $params['controller'];
        $action = $params['action'];
        $param = $params['param'];
        $rootpath = $params['rootpath'];
        

        $rootpath = ucwords(str_replace('/' , "\\", $rootpath), "\\");
            
        $className = "\App\Controllers\\" . $rootpath . ucfirst($controller);


        if(class_exists($className)){
                call_user_func_array(array(new $className, $action), array($param)); 
            }else echo "Wrong URL";
        }

    }
}

?>