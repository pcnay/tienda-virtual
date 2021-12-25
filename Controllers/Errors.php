<?php
	class Errors extends Controllers
	{
		public function __construct()
		{
			// Ejecuta el constructor padre (desde donde se hereda.)
			parent::__construct();
		}
		
		public function notFound()
		{
			$this->views->getView($this,"error");
		}
		
	} // classs Home

	$notFound = new Errors();
	$notFound->notFound();

?>
