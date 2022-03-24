<p class="lead">
    Listado de Clientes de MaxVitrinas.
</p>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
            <br><br>
            <div class="panel panel-info">
                <div class="panel-heading text-center"><h4>Clientes registrados</h4></div>
              	<div class="table-responsive">
                  <table class="table table-striped table-hover">
                      	<thead>
                          	<tr>
								<th class="text-center">#</th>
                              	<th class="text-center">NIT</th>
                              	<th class="text-center">Nombre</th>
                              	<th class="text-center">Apellido</th>
                              	<th class="text-center">Dirección</th>
                              	<th class="text-center">Telefono</th>
                              	<th class="text-center">Email</th>
                              	<th class="text-center">Actualizar</th>
                              	<th class="text-center">Eliminar</th>
                          	</tr>
                      	</thead>
                      	<tbody>
                          	<?php
								$mysqli = mysqli_connect(SERVER, USER, PASS, BD);
								mysqli_set_charset($mysqli, "utf8");

								$pagina = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;
								$regpagina = 30;
								$inicio = ($pagina > 1) ? (($pagina * $regpagina) - $regpagina) : 0;

								$clientes=mysqli_query($mysqli,"SELECT SQL_CALC_FOUND_ROWS * FROM cliente LIMIT $inicio, $regpagina");

								$totalregistros = mysqli_query($mysqli,"SELECT FOUND_ROWS()");
								$totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);

								$numeropaginas = ceil($totalregistros["FOUND_ROWS()"]/$regpagina);

								$cr=$inicio+1;
                                while($clie=mysqli_fetch_array($clientes, MYSQLI_ASSOC)){
                            ?>
							<tr>
								<td class="text-center"><?php echo $cr; ?></td>
								<td class="text-center"><?php echo $clie['clie_id']; ?></td>
								<td class="text-center"><?php echo $clie['clie_nomb']; ?></td>
								<td class="text-center"><?php echo $clie['clie_apel']; ?></td>
								<td class="text-center"><?php echo $clie['clie_tele']; ?></td>
								<td class="text-center"><?php echo $clie['clie_dire']; ?></td>
								<td class="text-center"><?php echo $clie['clie_email']; ?></td>
								<td class="text-center">
	                        		<a href="configAdmin.php?view=providerinfo&code=<?php echo $clie['clie_id']; ?>" class="btn btn-raised btn-xs btn-success">Actualizar</a>
	                        	</td>
	                        	<td class="text-center">
	                        		<form action="process/delprove.php" method="POST" class="FormCatElec" data-form="delete">
	                        			<input type="hidden" name="id-clie" value="<?php echo $clie['clie_id']; ?>">
	                        			<button type="submit" class="btn btn-raised btn-xs btn-danger">Eliminar</button>	
	                        		</form>
	                        	</td>
							</td>
                            <?php
                            	$cr++;
                                }
                            ?>
                      	</tbody>
                  </table>
              	</div>
                <?php if($numeropaginas>=1): ?>
              	<div class="text-center">
                  <ul class="pagination">
                    <?php if($pagina == 1): ?>
                        <li class="disabled">
                            <a>
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="configAdmin.php?view=providerlist&pag=<?php echo $pagina-1; ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>


                    <?php
                        for($i=1; $i <= $numeropaginas; $i++ ){
                            if($pagina == $i){
                                echo '<li class="active"><a href="configAdmin.php?view=providerlist&pag='.$i.'">'.$i.'</a></li>';
                            }else{
                                echo '<li><a href="configAdmin.php?view=providerlist&pag='.$i.'">'.$i.'</a></li>';
                            }
                        }
                    ?>
                    

                    <?php if($pagina == $numeropaginas): ?>
                        <li class="disabled">
                            <a>
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="configAdmin.php?view=providerlist&pag=<?php echo $pagina+1; ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                  </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
	</div>
</div>