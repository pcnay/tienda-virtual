<?php
	class Controllers
	{
		public function __construct()
		{		
			$this->loadModel();	
			$this->views = new Views();
		}
		
		public function loadModel()
		{
			// Se esta instanciando la clase Models.

			$model = get_class($this)."Model";
			$routClass = "Models/".$model.".php";
			if (file_exists($routClass))
			{
				require_once($routClass);
				$this->model = new $model();
			}

		} // public function loadModel()

	}
?>
