<?php

    namespace Core;
    
    use Core\Exceptions\RouterException as RouterException;
    use \ReflectionException as ReflectionException;
    use \Exception as Exception;
    use \ReflectionClass as ReflectionClass;
    use \ReflectionMethod as ReflectionMethod;

    class Router
    {

        private $_panda, $_request, $_controller, $_method, $_args;

        /**
         * @param Request $request 
         */
        public function __construct(Request $request)
        {
            $this->_panda = Panda::getInstance();

            // Get App Name, i.e. Index
            $this->_panda->appName = $this->_getApp($request->getApp());
            $this->_panda->appRoot = $this->_panda->root . $this->_panda->appName . '/';

            $this->_request = \SplFixedArray::fromArray(($request->getRequest() !== null) ? explode('/', $request->getRequest()) : array($this->_panda->defaultController, $this->_panda->defaultMethod));

            if ($this->_request->valid()) {
                $controllerName = $this->_getController();
                $methodName = $this->_getMethod();
                
                $this->_method->invoke($this->_controller->newInstance());
                
                /* To Do List
                 * Handle args
                 * Double check code
                 */
            }
        }

        /**
         * Gets the app name or loads default
         * @param type $app 
         */
        private function _getApp($app, $recursive=true)
        {
            if (is_readable($this->_panda->root . $app . '/Config.php')) {
                require_once $this->_panda->root . $app . '/Config.php';
                $this->_panda->import($config);

                return $app;
            }

            if ($recursive === true) {
                return $this->_getApp($this->_panda->defaultApp, false);
            }

            throw new RouterException('Panda failed to find the application with the name: ' . $app . ', Please check you have a folder with a Config.php', 500, null);
        }

        /**
         * Gets the controller and returns the name
         * @return string 
         */
        private function _getController()
        {
            try {
                $this->_controller = new ReflectionClass('Controllers\\' . ucfirst($this->_request->current()));

                if ($this->_controller->isInstantiable()) {
                    return ucfirst($this->_request->current());
                }
            } catch (Exception $e) {
                
            }

            throw new RouterException('Panda failed the find the controller, this could simply just be a simple 404', 404, ifsetor($e, null));
        }

        /**
         * Gets the method and returns the name
         * @param string
         */
        private function _getMethod()
        {
            if (($this->_request->next()) && ($this->_request->valid())) {
                $method = $this->_request->current();
            }else{
                $method = $this->_panda->defaultMethod;
            }

            try {
                $this->_method = new ReflectionMethod($this->_controller->name, $method);

                if(($this->_method->isPublic()) && (!$this->_method->isConstructor())){
                    return $method;
                }
            } catch (ReflectionException $e) {
                
            }

            throw new RouterException('Panda failed to find the method with the name: ' . $method, 404, ifsetor($e, null));
        }

    }

    