<!--
<div class="container text-center cr">
  <form class="form-signin" onsubmit="return false;">
    <i class="fas fa-cube fa-4x"></i> <br><br>
    <h1 class="h3 mb-3 font-weight-normal">Для получения напишите в нашу группу вконтакте</h1>
    <p>Доступ к консоли имеют только игроки с донатом выше чем "Глава"</p> <br>
    <button class="btn btn-primary btn-block" onClick="vkAuthByButton()">Войти через <i class="fab fa-vk"></i></button>
    <p class="mt-5 mb-3 text-muted"></p>
  </form>
</div>
-->
<?php

if(!$_SESSION['login']){
    $config = require '../config.php';
    die($config['hackerman_msg']);
}
?>
<script src="../authMeLogin/jquery-3.4.1.js"></script>
<script>
    $(document).on('click','#auth_message',function() {
        $('#auth_message').remove();
    });
</script>
<main class="auth_main">
    <div class="auth_wrapper">
        <section class="auth_section">
            <div class="auth_wrapper">
                <h1 class="auth_h1">Вход</h1>
                <?
                //disabled
                if(!$config["enabled"] or $_SESSION['error'] == 'disabled'){
                    echo '<p id="auth_message" class="auth_message auth_error">' . $config['error']['disabled'] . '</p>';
                }
                //enabled
                else {
                    if(isset($_SESSION['error'])){
                        echo '<p id="auth_message" class="auth_message auth_error">' . $config['error'][$_SESSION['error']] . '</p>';
                        unset($_SESSION['error']);
                    }
                    echo "
                <form class='auth_form' action='../authMeLogin/authme.php' method='POST'>
                    <input required class='auth_input' type='text' name='username' placeholder='Ваш ник' value='{$_SESSION['username']}'>
                    <input required class='auth_input' type='password' name='password' placeholder='Пароль'>
                    <button class='auth_button' type='submit' name='submit'>Войти</button>
                </form>
                ";}?>
            </div>
        </section>
    </div>
</main>

