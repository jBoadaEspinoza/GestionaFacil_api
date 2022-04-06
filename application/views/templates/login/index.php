<div class="d-none d-lg-block d-xl-none d-xl-block">
    <br><br>
    <div class="full-container mt-auto">
      <div class="container">
            <br>
        <div class="row justify-content-center">
          <div class="col-4">
                  <div class="row">
                      <form class="col bg-danger border border-danger rounded p-4 m-2" method="POST"  action="<?php echo $url_action;?>" autocomplete="off">
                            <h1 class="font-lobster text-white text-center text-40x">Antojos<span class="font-roboto mt-n2 ml-4 d-block text-n6x text-white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Business</span></h1>
                            <!--<h5 class="text-center text-black text-muted text-n5x">(Sistema Integral Para Operadores Turisticos - Islas Ballestas)</h4>-->
                            <p>&nbsp;</p>
                            
                            <div class="form-group">
                                <label class="text-font-weight text-white">RUC del establecimiento:</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-light" id="basic-addon1"><i class="fas fa-building"></i></span>
                                  </div>
                                  <input type="text" class="form-control form-control" name="userbusinessid" <?php echo $input["user"]["business_id"]["value"];?> <?php echo $input["user"]["business_id"]["autofocus"];?>/>
                                </div>
                                <p class="text-warning mt-n1"><?php echo $input["user"]["business_id"]["msg"]; ?></p>
                            </div>
                            <div class="form-group">
                                <label class="text-weight text-white">Correo electrónico ó nombre de usuario:</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-light" id="basic-addon1"><i class="fas fa-user"></i></span>
                                  </div>
                                  <input type="text" class="form-control form-control" name="username" <?php echo $input["user"]["name"]["value"];?> <?php echo $input["user"]["name"]["autofocus"];?>/>
                                </div>
                                <p class="text-warning mt-n1"><?php echo $input["user"]["name"]["msg"]; ?></p>
                            </div>
                            <div class="form-group">
                                <label class="text-weight text-white">Contraseña de acceso:</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-light" id="basic-addon1"><i class="fas fa-key"></i></span>
                                  </div>
                                  <input type="password" class="form-control" name="userpassword" <?php echo $input["user"]["password"]["value"];?> <?php echo $input["user"]["password"]["autofocus"];?> />
                                </div>
                                <p class="text-warning mt-n1"><?php echo $input["user"]["password"]["msg"]; ?></p>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-light btn-sm form-control">Iniciar sesi&oacute;n</button>
                            </div>
                      </form>
                  </div>
          </div>
        </div>
            <br>
      </div>
    </div>
    <br>
</div>