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
            $HTMLOutput = '<h2>Panda Error</h2>';
            $HTMLOutput .= '<h3>' . $e->getMessage() . '</h3>';
            return $HTMLOutput;
        }
        
        private function _CLIOutput($e){
            $CLIOutput = "\n#--- Panda Error -------------------------#\n";
            $CLIOutput .= "- " . $e->getMessage() . " \n";
            $CLIOutput .= "#-----------------------------------------#\n";
            
            return $CLIOutput;
        }

        private function _getTrace($e, $callback)
        {

            /* if (($trace = $e->getTrace())) {
              echo '<table width="100%" border="1" cellpadding="5px"><tr><td>File</td><td>Line</td></tr>';

              foreach ($trace as $error) {
              if (isset($error['file'], $error['line'])) {
              echo '<tr><td>' . $error['file'] . '</td><td>' . $error['line'] . '</td></tr>';
              }
              }

              echo '</table>';
              } */
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