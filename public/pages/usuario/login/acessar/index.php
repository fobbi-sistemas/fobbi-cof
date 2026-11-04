<?php
    require_once __DIR__ . '/../../../../../src/bootstrap-public.php';

    $loginErro = isset($_GET['valid']) && $_GET['valid'] == "false";
    $loginUsuario = isset($_GET['user']) ? htmlspecialchars($_GET['user'], ENT_QUOTES, 'UTF-8') : '';

    $pageTitle = 'Login - Fobbi COF';
    $pageCss = array('pages/login.css');
    require_once '../../../layout/head.php';
?>
<div class="login">

    <section class="login__brand">
        <div class="login__glow login__glow--top"></div>
        <div class="login__glow login__glow--bottom"></div>

        <img class="login__logo" src="../../../../assets/images/Logo_Light_Fobbi.png" alt="Fobbi"/>

        <div class="login__headline">
            <span class="fb-badge fb-badge--tag">COF • Centro de Oportunidades Fobbi</span>
            <h1 class="login__title">Painel Estratégico da Indústria Parceira</h1>
            <p class="login__lead">
                Acompanhe em tempo real todas as oportunidades de mercado endereçadas e a taxa de conversão em vendas do varejo da construção civil.
            </p>
        </div>

        <div class="login__foot">
            <div><strong>Fobbi</strong> • Simplificar para fazer acontecer.</div>
            <div><i class="bi bi-shield-check"></i> Ambiente seguro</div>
        </div>
    </section>

    <section class="login__panel">
        <div class="fb-card fb-card--light login__card">
            <div class="login__head">
                <img class="login__card-logo" src="../../../../assets/images/Logo_Fobbi.png" alt="Fobbi"/>
                <h2 class="login__card-title">Acessar o COF</h2>
                <p class="login__card-sub">Entre com as suas credenciais</p>
            </div>

            <?php if ($loginErro) { ?>
                <div class="fb-alert fb-alert--warning" role="alert" aria-live="polite">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Login ou senha incorretos.</span>
                </div>
            <?php } ?>

            <form method="post" action="../controle/realizaLogin.php" id="form-login">
                <?= csrf_field() ?>

                <div class="fb-field">
                    <label class="fb-label" for="login">Usuário</label>
                    <div class="fb-input-wrap">
                        <span class="fb-input-icon"><i class="bi bi-person"></i></span>
                        <input type="text" id="login" name="login" value="<?= $loginUsuario ?>" class="fb-input"
                               placeholder="Seu usuário" autocomplete="username" required <?= $loginUsuario === '' ? 'autofocus' : '' ?>/>
                    </div>
                </div>

                <div class="fb-field">
                    <label class="fb-label" for="senha">Senha</label>
                    <div class="fb-input-wrap">
                        <span class="fb-input-icon"><i class="bi bi-lock"></i></span>
                        <input type="password" id="senha" name="senha" class="fb-input fb-input--toggle"
                               placeholder="Sua senha" autocomplete="current-password" required <?= $loginUsuario !== '' ? 'autofocus' : '' ?>/>
                        <button type="button" class="fb-input-toggle" id="toggle-senha" aria-label="Mostrar senha">
                            <i class="bi bi-eye" id="toggle-senha-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" name="entrar" value="Entrar" id="btn-entrar" class="fb-btn fb-btn--primary fb-btn--center">
                    <span>Entrar no painel</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <p class="login__secure"><i class="bi bi-lock-fill"></i> Acesso restrito a usuários autorizados</p>
        </div>
    </section>

</div>
<script src="js/login.js?v=1"></script>
<?php require_once '../../../layout/foot.php'; ?>
