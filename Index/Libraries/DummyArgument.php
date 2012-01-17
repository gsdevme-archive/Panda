<?php

	namespace Libraries;

	class DummyArgument
	{
		private $_data;
		
		public function __construct()
		{
			$this->_data = func_get_args();
		}

		public function test()
		{
			if(count($this->_data) <= 0){
				throw new \Exception('We have a problem !!, the arguments didn\'t pass correctly');
			}		
		}
	}