<p class="lead">
    Listado de Reportes.
</p>
<ul class="breadcrumb" style="margin-bottom: 5px;">
    <li>
        <a href="configAdmin.php?view=reportSells">
            <i class="fa fa-usd" aria-hidden="true"></i> &nbsp; Reporte Ventas
        </a>
    </li>
    <li>
        <a href="configAdmin.php?view=reportClie"><i class="fa fa-address-book" aria-hidden="true"></i> &nbsp; Reporte Clientes</a>
    </li>
</ul>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <br><br>
            <div class="panel panel-info">
                <script>
                    function generar() {
                        $.ajax({
                            url: "process/genRepClie.php",
                            success: function(result) {
                                swal({
                                        title: "Reporte generado",
                                        text: "El Reporte se generó con éxito",
                                        type: "success",
                                        // showCancelButton: false,
                                        confirmButtonClass: "btn-danger",
                                        confirmButtonText: "Aceptar",
                                        // cancelButtonText: "Cancelar",
                                        // closeOnConfirm: false,
                                        // closeOnCancel: false
                                    },
                                    function(isConfirm) {
                                        if (isConfirm) {
                                            location.reload();
                                        } else {
                                            location.reload();
                                        }
                                    });
                            }
                        });
                    }
                </script>
                <center><a onclick="generar()" class="btn btn-raised btn-success">Generar Reporte</a></center>
                <div class="panel-heading text-center">
                    <h4>Reportes clientes de la tienda</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $mysqli = mysqli_connect(SERVER, USER, PASS, BD);
                            mysqli_set_charset($mysqli, "utf8");

                            $pagina = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;
                            $regpagina = 30;
                            $inicio = ($pagina > 1) ? (($pagina * $regpagina) - $regpagina) : 0;

                            $reportes = mysqli_query($mysqli, "SELECT SQL_CALC_FOUND_ROWS * FROM reporte WHERE tipo LIKE  '%cliente%' LIMIT $inicio, $regpagina");

                            $totalregistros = mysqli_query($mysqli, "SELECT FOUND_ROWS()");
                            $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);

                            $numeropaginas = ceil($totalregistros["FOUND_ROWS()"] / $regpagina);

                            $cr = $inicio + 1;
                            while ($repo = mysqli_fetch_array($reportes, MYSQLI_ASSOC)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $cr; ?></td>
                                    <td class="text-center"><?php echo $repo['fecha']; ?></td>
                                    <td class="text-center">
                                        <a href="./report/reporteClie.php?id=<?php echo $repo['id']; ?>" class="btn btn-raised btn-xs btn-primary" target="_blank">Imprimir</a>
                                    </td>
                                </tr>
                            <?php
                                $cr++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($numeropaginas >= 1) : ?>
                    <div class="text-center">
                        <ul class="pagination">
                            <?php if ($pagina == 1) : ?>
                                <li class="disabled">
                                    <a>
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li>
                                    <a href="configAdmin.php?view=repo&pag=<?php echo $pagina - 1; ?>">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>


                            <?php
                            for ($i = 1; $i <= $numeropaginas; $i++) {
                                if ($pagina == $i) {
                                    echo '<li class="active"><a href="configAdmin.php?view=repo&pag=' . $i . '">' . $i . '</a></li>';
                                } else {
                                    echo '<li><a href="configAdmin.php?view=repo&pag=' . $i . '">' . $i . '</a></li>';
                                }
                            }
                            ?>


                            <?php if ($pagina == $numeropaginas) : ?>
                                <li class="disabled">
                                    <a>
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li>
                                    <a href="configAdmin.php?view=repo&pag=<?php echo $pagina + 1; ?>">
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