<?php

    namespace Core\Panda;

use \Exception as Exception;

    class ErrorReport
    {

        private $_mode, $CLIOutput, $HTMLOutput;

        public function __construct(Exception $e)
        {            
            $this->_mode = Panda::getInstance()->mode;

            if (Panda::getInstance()->debug === false) {                
                switch ($e->getCode()) {
                    case 404:
                        include Panda::getInstance()->appRoot . 'Errors/404.html';
                        exit;
                    default:
                        include Panda::getInstance()->appRoot . 'Errors/500.html';
                        exit;
                }
            }
            
            $this->_HTMLOutput = $this->_HTMLOutput($e);
            $this->_CLIOutput = $this->_CLIOutput($e);
        }

        private function _HTMLOutput($e)
        {
            if (is_object($e)) {
                $HTMLOutput = '<div style="border:1px solid red;padding:5px 10px;margin:5px 0;"><h3>Panda Error</h3>';
                $HTMLOutput .= '<h4 style="font-weight:400;"><b>' . get_class($e) . '</b>: ' . $e->getMessage() . '</h4>';

                if ($e->getPrevious() instanceof Exception) {
                    $HTMLOutput .= '<h4 style="font-weight:400;"><b>' . get_class($e->getPrevious()) . '</b>: ' . $e->getPrevious()->getMessage() . '</h4></div>';
                }

                $HTMLOutput .= $this->_getTrace($e);
                return $HTMLOutput;
            }
        }

        private function _CLIOutput($e)
        {
            $CLIOutput = "\n#--- Panda Error -------------------------#\n";
            $CLIOutput .= "- " . get_class($e) . ": " . $e->getMessage() . " \n";

            if ($e->getPrevious() instanceof Exception) {
                $CLIOutput .= "- " . get_class($e->getPrevious()) . ": " . $e->getPrevious()->getMessage() . " \n";
            }

            $CLIOutput .= "#-----------------------------------------#\n";

            return $CLIOutput;
        }

        private function _getTrace($e)
        {
            if (($trace = $e->getTrace())) {
                $traceOutput = '<table width="100%" border="1" cellpadding="5px"><tr><td>File</td><td>Line</td></tr>';

                foreach ($trace as $error) {
                    if (isset($error['file'], $error['line'])) {
                        $traceOutput .= '<tr><td>' . $error['file'] . '</td><td>' . $error['line'] . '</td></tr>';
                    }
                }

                $traceOutput .= '</table>';

                return $traceOutput;
            }
        }

        public function getOutput()
        {
            switch ($this->_mode) {
                case 'CLI':
                    return $this->_CLIOutput;
                case 'HTTP':
                    return $this->_HTMLOutput;
            }
        }

    }