<div class="task-entry-block">
  <?php wp_nonce_field( "task-entry-action", "task-entry-nonce" ); ?>
  <div class="task-entry-block__line">
    <div class="task-content-entry-field">
      <p class="task-content-entry-field__title">タスク内容</p>
      <textarea class="task-content-entry-field__body" name="task[content]" rows="4"><?php echo esc_html( $content ); ?></textarea>
    </div>
  </div>
  <div class="task-entry-block__line">
    <div class="task-status-entry-field">
      <p class="task-statsu-entry-field__title">タスクの状態</p>
      <select class="task-status-entry-field__body" name="task[status]">
        <?php if ( $status === "0" ): ?>
          <option value="0" selected>未完了</option>
          <option value="1">完了</option>
        <?php elseif ( $status === "1" ): ?>
          <option value="0">未完了</option>
          <option value="1" selected>完了</option>
        <?php else: ?>
          <option value="0">未完了</option>
          <option value="1">完了</option>
        <?php endif; ?>
      </select>
    </div>
  </div>
</div>
