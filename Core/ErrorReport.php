<?php

    namespace Core;

use \Exception as Exception;

    class ErrorReport
    {

        private $mode, $CLIOutput, $HTMLOutput;

        public function __construct(Exception $e)
        {
            $this->mode = Panda::getInstance()->mode;

            $this->HTMLOutput = $this->_HTMLOutput($e);
            $this->CLIOutput = $this->_CLIOutput($e);
        }

        private function _HTMLOutput($e)
        {
            if (is_object($e)) {
                $HTMLOutput = '<div style="border:1px solid red;padding:5px 10px;margin:5px 0;"><h3>Panda Error</h3>';
                $HTMLOutput .= '<h4 style="font-weight:400;">' . $e->getMessage() . '</h4>';                
                $HTMLOutput .= '<h4 style="font-weight:400;">' . $e->getPrevious()->getMessage() . '</h4></div>';

                $HTMLOutput .= $this->_getTrace($e);
                return $HTMLOutput;
            }
        }

        private function _CLIOutput($e)
        {
            $CLIOutput = "\n#--- Panda Error -------------------------#\n";
            $CLIOutput .= "- " . $e->getMessage() . " \n";
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
            switch ($this->mode) {
                case 'CLI':
                    return $this->CLIOutput;
                case 'HTTP':
                    return $this->HTMLOutput;
                case 'Email':
                    break;
            }
        }

    }