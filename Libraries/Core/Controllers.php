<?php
	
	class Controllers
	{
		// Es el primer método que se ejecuta cuando se instancia la clase "Controllers"
		public function __construct()
		{	
			// Se esta comunicando del "Controlador" a la "Vista"
			// No se requiere "require", ya que esta clase se agrega en el "Index.php" a través de la "autoload"
			$this->views = new Views();	
			$this->loadModel();				
		}
		
		
		// Se esta comunicando del "Controlador" al "Modelo", "homeModel"
		public function loadModel()
		{
			// Se esta instanciando la clase Models.
			// Esta obteniendo las clases de la forma "NombreModel"
			// Estas clases se cargan de forma automatica por el "autoload" del archivo index.php
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
