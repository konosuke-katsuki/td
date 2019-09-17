<?php get_header(); ?>

<div class="user-register-area">
  <form action="<?php echo esc_url( home_url() . "/user/register" ); ?>" method="post">
    <div class="user-register-block">

      <?php if ( isset( $success_message ) ): ?>
        <div class="user-register-block__line">
          <p><?php echo esc_html( $success_message ); ?></p>
        </div>
      <?php endif; ?>

      <?php if ( $errors ): ?>
        <div class="user-register-block__line">
          <?php foreach ( $errors as $error ): ?>
            <p><?php echo esc_html( $error ); ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="user-register-block__line">
        <div class="user-name-input-field">
          <p class="user-name-input-field__heading">ユーザー名</p>
          <input class="user-name-input-field__body" type="text" name="user-name" value="">
        </div>
      </div>

      <div class="user-register-block__line">
        <div class="password-input-field">
          <p class="password-input-field__heading">パスワード</p>
          <input class="password-input-field__body" type="text" name="password" value="">
        </div>
      </div>

      <div class="user-register-block__line">
        <div class="email-input-field">
          <p class="email-input-field__heading">Eメール</p>
          <input class="email-input-field__body" type="text" name="email" value="">
        </div>
      </div>

      <div class="user-register-block__line">
        <button class="register-button" type="submit">登録</button>
      </div>

      <div class="user-register-block__line">
        <a href="<?php echo esc_url( home_url() . "/wp-login.php" ); ?>">ログインページへ</a>
      </div>

    </div>
  </form>
</div>

<?php get_footer(); ?>
