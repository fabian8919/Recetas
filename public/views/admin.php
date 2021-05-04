<?php
session_start();

if (!isset($_SESSION["authExito"]) && $_SESSION["authExito"] !== true){
	header("Location: ../index.html");
}
$time= time();
?>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>HelpmeCook</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../img/logorecetasico.ico" type="image/x-icon"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<script src="../assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
    
    <!-- <link rel="stylesheet" href="../assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../assets/bootstrap4/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/atlantis.min.css">
	<link href="../assets/styles.css" rel="stylesheet" />
	<link href="../assets/prism.css" rel="stylesheet" />

    <link rel="stylesheet" href="../assets/js/plugin/datatables/select.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/js/plugin/sweetalert2/dist/sweetalert2.min.css">
</head>
<body>
	<div class="wrapper">

        <div class="main-header">
            <div class="logo-header" data-background-color="light-blue2">
                <a href="admin.php" class="logo" style="color: white;">HelpmeCook</a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="light-blue2">
                <div class="container-fluid">
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item">
                            <a href="#" id="logout" class="nav-link">
                                Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

            <!-- Sidebar #fa5e56 -->
            <?php include_once ('plantilla/menuLat1.php'); ?>
            <!-- End Sidebar -->
            <div class="main-panel">
                <div class="content">
                    <div class="page-inner" >
                        <div class="panel-header">
                            <h4 class="page-title page_title_modulo" ></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div id="mD_principal">  

                            </div>	
                        </div>
                    </div>
                </div>

            

                <div class="modal fade" tabindex="-1" role="dialog" id="modalLoader" style="margin-top: 2%; width: 100%; height: 90%; z-index: 1100;" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content" style="background-color: transparent !important;">
                            <div class="modal-body">
                                <div id="loadAllWindow"><div id="loader"></div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Cerrar Sesión -->
                <div class="modal fade" tabindex="-1" id="modalSalir" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h4 class="modal-title">Confirmación</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <p>Esta seguro que desea salir?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
                                <button type="button" id="confirmSalir" onclick="logout()" class="btn btn-info btn-sm">Aceptar</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div><!-- /.main panel -->

        </div>	


</body>
<script src="../assets/js/core/jquery.3.2.1.min.js"></script>
<script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="../assets/js/core/popper.min.js"></script>
<!-- <script src="../assets/js/core/bootstrap.min.js"></script> -->
<script src="../assets/bootstrap4/js/bootstrap.min.js"></script>
<script src="../assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="../assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="../assets/js/atlantis.min.js"></script>
<script src="gestorDeModulos.js?v=<?= $time; ?>" type="text/javascript"></script>
<script src="app.js?v=<?= $time; ?>"></script>

<!-- ADICIONALES -->
<!-- <script src="../assets/js/plugin/datatables/datatables.min.js"></script> -->
<script src="../assets/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/js/plugin/datatables/dataTables.select.min.js"></script>
<script src="../assets/js/plugin/datatables/dataTables.bootstrap4.min.js"></script>


<script src="../assets/js/plugin/select2/select2.full.min.js?v=<?= $time; ?>" type="text/javascript"></script>
<!-- <script type="text/javascript" src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> -->
<script type="text/javascript" src="../assets/js/plugin/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="../assets/js/plugin/awesome/awesome.min.js"></script>


</html>