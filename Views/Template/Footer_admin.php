    <script>
			// Genera una variable en JavaScript desde PHP.
			const base_url = "<?php echo base_url(); ?>";
		</script>

		<!-- Essential javascripts for application to work-->
    <script src="Assets/js/jquery-3.3.1.min.js"></script>
    <script src="Assets/js/popper.min.js"></script>
    <script src="Assets/js/bootstrap.min.js"></script>
    <script src="Assets/js/main.js"></script>
		<!-- Se agrega la nueva version del"fontawesome"-->
		<script src="Assets/js/fontawesome.js"></script>
		
    <!-- The javascript plugin to display page loading on top-->
    <script src="Assets/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
		<script type="text/javascript" src="Assets/js/plugins/sweetalert.min.js"></script>
    <!-- Data table plugin-->
    <script type="text/javascript" src="Assets/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="Assets/js/plugins/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript" src="Assets/js/plugins/bootstrap-select.min.js"></script>
    
		<!-- Estos script se utilizan para los botones que se agregan en el dataTable-->
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>		

		<script src="Assets/js/Functions_admin.js"></script>

		<script src="Assets/js/<?php echo $data['page_functions_js']; ?>"></script>

		
		<!-- Estos archivos tienen una función "openModal"  -->
		<?php //if ($data['page_name'] == "Roles"){ ?>
		<!-- <script src="Assets/js/Functions_roles.js"></script>-->
		<?php
			//}
		?>
		<?php //if ($data['page_name'] == "Usuarios"){ ?>
			<!-- <script src="Assets/js/Functions_usuarios.js"></script>-->
			<?php
			//}
		?>

  </body>
</html>