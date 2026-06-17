<?php
    use Src\Controller\Mc2\Mc2Controller;

    require_once '../../../header.php';
    require_once '../menu.php';

    $controller = new Mc2Controller();
    $list  = [];
    $count = 0;
    $page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $dataCadastroInicial = isset($_GET['dataCadastroInicial']) ? $_GET['dataCadastroInicial'] : null;
    $dataCadastroFinal   = isset($_GET['dataCadastroFinal'])   ? $_GET['dataCadastroFinal']   : null;
    $perfilFilter        = isset($_GET['perfil'])              ? $_GET['perfil']              : null;
    $ativoFilter         = isset($_GET['ativo'])               ? $_GET['ativo']               : '';

    try {
        $list  = $controller->findAll($_GET, $page);
        $count = count($controller->findAll($_GET, null));
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $perfis = ['industria' => 'Indústria', 'distribuidor' => 'Distribuidor', 'varejo' => 'Varejo', 'prestador' => 'Prestador de Serviço'];
?>

<div class="container">
    <div class="card mt-5">
        <div class="card-header"> MC² — Lista de Registros </div>

        <div class="card-body">
            <form method="get" action="">
                <div class="row align-items-end">
                    <div class="col-sm-12 col-md-2 mb-3">
                        <label class="form-label"> Data inicial </label>
                        <input type="date" name="dataCadastroInicial" value="<?php echo $dataCadastroInicial; ?>" class="form-control form-control-sm"/>
                    </div>

                    <div class="col-sm-12 col-md-2 mb-3">
                        <label class="form-label"> Data final </label>
                        <input type="date" name="dataCadastroFinal" value="<?php echo $dataCadastroFinal; ?>" class="form-control form-control-sm"/>
                    </div>

                    <div class="col-sm-12 col-md-2 mb-3">
                        <label class="form-label"> Perfil </label>
                        <select name="perfil" class="form-select form-select-sm">
                            <option value="">- Todos -</option>
                            <?php foreach ($perfis as $k => $v): ?>
                                <option value="<?php echo $k; ?>" <?php echo $k == $perfilFilter ? 'selected' : ''; ?>>
                                    <?php echo $v; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-2 mb-3">
                        <label class="form-label"> Ativo </label>
                        <select name="ativo" class="form-select form-select-sm">
                            <option value="">- Todos -</option>
                            <option value="1" <?php echo $ativoFilter === '1' ? 'selected' : ''; ?>>Sim</option>
                            <option value="0" <?php echo $ativoFilter === '0' ? 'selected' : ''; ?>>Não</option>
                        </select>
                    </div>

                    <div class="col text-end mb-3">
                        <input type="submit" name="pesquisar" value="Pesquisar" class="btn btn-primary btn-sm">
                    </div>
                </div>
            </form>

            <div class="scroll-wrapper-top">
                <div class="scroll-indicator-top"></div>
            </div>

            <div class="table-responsive mb-1 table-scroll-bottom">
                <table class="table table-bordered table-sm table-mobile w-100" aria-describedby="MC2">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width:1%;white-space:nowrap;"></th>
                            <th style="width:5%">Código</th>
                            <th style="width:25%">Nome Fantasia</th>
                            <th style="width:14%">CNPJ</th>
                            <th style="width:12%">Perfil</th>
                            <th style="width:18%">Cidade/UF</th>
                            <th style="width:13%">Data</th>
                            <th style="width:7%">Ativo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list as $obj): ?>
                            <tr>
                                <td class="text-center">
                                    <a href="../cadastro?q=<?php echo $obj['id']; ?>" title="Editar" class="text-decoration-none">
                                        <em class="bi bi-pencil"></em>
                                    </a>
                                </td>
                                <td class="fs-7"><?php echo $obj['id']; ?></td>
                                <td class="fs-7"><?php echo htmlspecialchars($obj['nomeFantasia']); ?></td>
                                <td class="fs-7"><?php echo htmlspecialchars($obj['cnpj']); ?></td>
                                <td class="fs-7"><?php echo isset($perfis[$obj['perfil']]) ? $perfis[$obj['perfil']] : $obj['perfil']; ?></td>
                                <td class="fs-7"><?php echo htmlspecialchars($obj['nomeCidade'] . ($obj['uf'] ? '/' . $obj['uf'] : '')); ?></td>
                                <td class="fs-7"><?php echo $obj['data'] ? date('d/m/Y H:i', strtotime($obj['data'])) : ''; ?></td>
                                <td class="text-center">
                                    <?php if ($obj['ativo']): ?>
                                        <span class="badge bg-success">Sim</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Não</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col">
                    <ul class="pagination">
                        <?php if ($page == 1): ?>
                            <li><a class="btn btn-light rounded-0" href="#">&laquo; Anterior</a></li>
                        <?php else: $link_prev = ($page > 1) ? $page - 1 : 1; ?>
                            <li>
                                <a class="btn btn-light rounded-0" href="?page=<?php echo $link_prev; ?>&dataCadastroInicial=<?php echo $dataCadastroInicial; ?>&dataCadastroFinal=<?php echo $dataCadastroFinal; ?>&perfil=<?php echo $perfilFilter; ?>&ativo=<?php echo $ativoFilter; ?>">
                                    &laquo; Anterior
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php
                            $jumlah_page   = $count > 0 ? ceil($count / 25) : 1;
                            $jumlah_number = 1;
                            $start_number  = ($page > $jumlah_number) ? $page - $jumlah_number : 1;
                            if ($jumlah_page < 3) {
                                $end_number = $jumlah_page;
                            } elseif ($page == 1) {
                                $end_number = 3;
                            } else {
                                $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page;
                            }
                            for ($i = $start_number; $i <= $end_number; $i++):
                                $link_active = ($page == $i) ? 'class="active"' : '';
                        ?>
                            <li <?php echo $link_active; ?>>
                                <a class="btn btn-light rounded-0" href="?page=<?php echo $i; ?>&dataCadastroInicial=<?php echo $dataCadastroInicial; ?>&dataCadastroFinal=<?php echo $dataCadastroFinal; ?>&perfil=<?php echo $perfilFilter; ?>&ativo=<?php echo $ativoFilter; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page == $jumlah_page): ?>
                            <li><a class="btn btn-light rounded-0" href="#">Próximo &raquo;</a></li>
                        <?php else: $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page; ?>
                            <li>
                                <a class="btn btn-light rounded-0" href="?page=<?php echo $link_next; ?>&dataCadastroInicial=<?php echo $dataCadastroInicial; ?>&dataCadastroFinal=<?php echo $dataCadastroFinal; ?>&perfil=<?php echo $perfilFilter; ?>&ativo=<?php echo $ativoFilter; ?>">
                                    Próximo &raquo;
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col text-end">
                    <div class="form-text">Total de registros: <?php echo $count; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var $scrollWrapperTop    = $('.scroll-wrapper-top');
        var $scrollIndicatorTop  = $('.scroll-indicator-top');
        var $tableScrollBottom   = $('.table-scroll-bottom');
        var $table               = $tableScrollBottom.find('table');

        function setTopScrollWidth() {
            $scrollIndicatorTop.width($table.outerWidth());
        }

        $scrollWrapperTop.on('scroll', function() { $tableScrollBottom.scrollLeft($(this).scrollLeft()); });
        $tableScrollBottom.on('scroll', function() { $scrollWrapperTop.scrollLeft($(this).scrollLeft()); });
        setTopScrollWidth();
        $(window).on('resize', setTopScrollWidth);
    });
</script>

<?php require_once '../../../footer.php'; ?>
