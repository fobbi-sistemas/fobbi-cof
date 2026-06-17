<?php
    use Src\Controller\Mc2\Mc2Controller;

    require_once '../../../header.php';
    require_once '../menu.php';

    $controller = new Mc2Controller();
    $id  = isset($_GET['q']) ? (int)$_GET['q'] : null;
    $obj = [];

    if (isset($_POST['save'])) {
        try {
            $controller->save($id, $_POST);
            header('location: ?q=' . $id);
            exit;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    if (!empty($id)) {
        try {
            $obj = $controller->findById($id);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    $perfis = ['industria' => 'Indústria', 'distribuidor' => 'Distribuidor', 'varejo' => 'Varejo', 'prestador' => 'Prestador de Serviço'];
    $motivacoes = [
        'mc1' => 'Reduzir custos e aumentar a rentabilidade',
        'mc2' => 'Acesso a novos fornecedores',
        'mc3' => 'Atualização sobre mercado/segmento',
        'mc4' => 'Capacitar equipe e modernizar loja',
        'mc5' => 'Fortalecer representatividade do varejo',
        'mc6' => 'Outro',
    ];
?>

<style>
    .field-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6c757d;
        margin-bottom: 0.15rem;
    }
    .field-value {
        font-size: 0.95rem;
        color: #212529;
        padding: 0.25rem 0;
        border-bottom: 1px solid #e9ecef;
        min-height: 1.8rem;
    }
    .section-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
        padding-bottom: 0.25rem;
        margin-bottom: 1rem;
    }
</style>

<div class="container">
    <div class="card mt-5">
        <div class="card-header"> MC² — Cadastro #<?php echo $id; ?> </div>

        <div class="card-body">
            <?php if (empty($obj)): ?>
                <div class="alert alert-warning">Registro não encontrado.</div>
            <?php else: ?>

            <form method="post">

                <!-- Negócio -->
                <p class="section-title">Negócio</p>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="field-label">Nome Fantasia</div>
                        <div class="field-value"><?php echo htmlspecialchars($obj['nomeFantasia']); ?></div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="field-label">CNPJ</div>
                        <div class="field-value"><?php echo htmlspecialchars($obj['cnpj']); ?></div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="field-label">Perfil</div>
                        <div class="field-value"><?php echo isset($perfis[$obj['perfil']]) ? $perfis[$obj['perfil']] : htmlspecialchars($obj['perfil']); ?></div>
                    </div>
                </div>

                <!-- Contato -->
                <p class="section-title">Contato</p>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="field-label">Responsável</div>
                        <div class="field-value"><?php echo htmlspecialchars($obj['nomeResponsavel']); ?></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="field-label">Telefone</div>
                        <div class="field-value"><?php echo htmlspecialchars($obj['telefone']); ?></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="field-label">E-mail</div>
                        <div class="field-value"><?php echo htmlspecialchars($obj['email']); ?></div>
                    </div>
                </div>

                <!-- Localização -->
                <p class="section-title">Localização</p>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="field-label">Estado</div>
                        <div class="field-value"><?php echo htmlspecialchars($obj['nomeEstado'] . ($obj['uf'] ? ' (' . $obj['uf'] . ')' : '')); ?></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="field-label">Cidade</div>
                        <div class="field-value"><?php echo htmlspecialchars($obj['nomeCidade']); ?></div>
                    </div>
                </div>

                <!-- Objetivos -->
                <p class="section-title">O que busca no MC²</p>
                <div class="mb-4">
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($motivacoes as $key => $label): ?>
                            <?php if (!empty($obj[$key])): ?>
                                <span class="badge bg-primary fs-7"><?php echo $label; ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Logo -->
                <?php if (!empty($obj['logo'])): ?>
                <p class="section-title">Logo</p>
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <em class="bi bi-image fs-4 text-secondary"></em>
                        <div>
                            <div class="field-label mb-1">Arquivo</div>
                            <div><?php echo htmlspecialchars($obj['logo']); ?></div>
                        </div>
                        <div class="ms-auto d-flex gap-2">
                            <a href="../../../../../files/mc2/<?php echo urlencode($obj['logo']); ?>"
                               target="_blank"
                               class="btn btn-sm btn-outline-secondary">
                                <em class="bi bi-eye"></em> Visualizar
                            </a>
                            <a href="../../../../../files/mc2/<?php echo urlencode($obj['logo']); ?>"
                               download="<?php echo htmlspecialchars($obj['logo']); ?>"
                               class="btn btn-sm btn-outline-primary">
                                <em class="bi bi-download"></em> Baixar
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Info de cadastro -->
                <p class="section-title">Registro</p>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="field-label">Data de Cadastro</div>
                        <div class="field-value"><?php echo $obj['data'] ? date('d/m/Y H:i', strtotime($obj['data'])) : '—'; ?></div>
                    </div>
                </div>

                <hr>

                <!-- Campos editáveis -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label class="field-label d-block mb-2">Ativo</label>
                        <div class="form-check mt-1">
                            <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1"
                                   <?php echo !empty($obj['ativo']) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="ativo">Participante ativo</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="field-label" for="observacao">Observação</label>
                    <textarea class="form-control mt-1" id="observacao" name="observacao" rows="4"><?php echo htmlspecialchars($obj['observacao'] ?? ''); ?></textarea>
                </div>

                <div class="text-end">
                    <a href="../lista" class="btn btn-light btn-sm">Voltar à lista</a>
					<input type="submit" value="Salvar" name="save" class="btn btn-success btn-sm">
                </div>
            </form>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../../../footer.php'; ?>
