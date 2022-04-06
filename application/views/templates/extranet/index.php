<div class="m-0 p-0 w-100 bg-color-primary">
	<div class="into">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 position-relative d-block d-flex justify-content-between">
					<a href="<?php echo base_url();?>extranet/administracion/dashboard" class="text-white logo">
								Maa<span class="text-warning">bi</span><span class="version text-warning text-n1x">&nbsp;v1.0</span>&nbsp;<span class="text-n5x">(<?php echo $logo;?>)</span>
					</a>
					<div class="icons d-block d-sm-none d-none d-sm-block d-md-none  d-md-block d-lg-none ">
						<button class="btn btn-outline-secundary mt-1 text-white" onclick="openMenuForMobile(this,event)"><i class="fas fa-bars"></i></button>
					</div>
					<div class="d-none d-lg-block d-xl-none d-xl-block"> 
						<a class="btn btn-outline-secundary mt-1 text-white" href="<?php echo base_url();?>extranet/administracion/dashboard_signout"><i class="fas fa-sign-out-alt"></i>&nbsp;Cerrar sesión</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="d-none d-lg-block d-xl-none d-xl-block">
	<div class="m-0 p-0 w-100 dashboard">
		<div class="d-flex justify-content-start flex-wrap text-helvetica text-n5x menu">
			<?php echo $menu;?>
		</div>
	</div>
</div>
<div id="content2">
	<?php echo $content;?>
</div>