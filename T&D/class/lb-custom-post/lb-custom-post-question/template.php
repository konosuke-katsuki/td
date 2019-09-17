<div class="question-entry-block">
  <?php wp_nonce_field( "question-entry-action", "question-entry-nonce" ); ?>
  <div class="question-entry-block__line">
    <div class="content-entry-field">
      <p class="content-entry-field__title">問題内容</p>
      <textarea class="content-entry-field__body" name="question[content]" rows="4"><?php echo esc_html( $content ); ?></textarea>
    </div>
  </div>
  <div class="question-entry-block__line">
    <div class="answer-entry-field">
      <p class="answer-entry-field__title">解答</p>
      <textarea class="answer-entry-field__body" name="question[answer]" rows="4"><?php echo esc_html( $answer ); ?></textarea>
    </div>
  </div>
</div>
