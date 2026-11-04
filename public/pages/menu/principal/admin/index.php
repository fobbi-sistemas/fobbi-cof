<?php
    require_once __DIR__ . '/../../../../../src/bootstrap-page.php';

    $pageTitle = 'Painel de Controle - Fobbi COF';
    $pageCss = array('pages/menu-admin.css');
    $bodyClass = 'menu-admin';
    require_once '../../../layout/head.php';
?>
    <div class="menu-admin__glow menu-admin__glow--top"></div>
    <div class="menu-admin__glow menu-admin__glow--bottom"></div>

    <main class="menu-admin__main">
        <div class="fb-card">
            <div class="menu-admin__brand">
                <img class="menu-admin__logo" src="../../../../assets/images/Logo_Fobbi.png" alt="Fobbi"/>
                <h1 class="menu-admin__title">Painel de Controle</h1>
                <p class="menu-admin__subtitle">Conectando Varejo e Indústria da Construção Civil</p>
            </div>

            <div class="menu-admin__divider"></div>

            <nav class="menu-admin__actions">
                <a href="../../../landing-page/oportunidade/lista" class="fb-btn fb-btn--primary">
                    <span class="fb-btn__main">
                        <span class="fb-btn__icon"><i class="bi bi-briefcase-fill"></i></span>
                        <span>
                            <span class="fb-btn__title">Oportunidades comerciais cadastradas</span>
                            <span class="fb-btn__hint">Gestão de ofertas e negociações</span>
                        </span>
                    </span>
                    <i class="bi bi-chevron-right fb-btn__chevron"></i>
                </a>

                <a href="../../../campo-dados/dados/cadastro" class="fb-btn fb-btn--dark">
                    <span class="fb-btn__main">
                        <span class="fb-btn__icon"><i class="bi bi-sliders"></i></span>
                        <span>
                            <span class="fb-btn__title">Acrescentar e alterar parâmetros</span>
                            <span class="fb-btn__hint">Configuração de campos de dados</span>
                        </span>
                    </span>
                    <i class="bi bi-chevron-right fb-btn__chevron"></i>
                </a>

                <form method="post" action="../../../usuario/login/controle/realizaLogout.php">
                    <?= csrf_field() ?>
                    <button type="submit" class="fb-btn fb-btn--muted">
                        <span class="fb-btn__main">
                            <span class="fb-btn__icon"><i class="bi bi-box-arrow-right"></i></span>
                            <span class="fb-btn__title">Sair</span>
                        </span>
                        <span class="fb-btn__aside">Encerrar sessão</span>
                    </button>
                </form>
            </nav>
        </div>
    </main>

    <footer class="menu-admin__copy">
        <p>© <?= date('Y') ?> Fobbi Plataforma Digital. Todos os direitos reservados.</p>
        <p>Simplificar para fazer acontecer • Aproximar para gerar oportunidades</p>
    </footer>
<?php require_once '../../../layout/foot.php'; ?>
