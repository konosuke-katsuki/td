<?php
$args = [
  "author"         => wp_get_current_user() -> ID,
  "post_type"      => "task",
  "posts_per_page" => -1,
];

$query = new WP_Query( $args );
?>

<div class="task-list-block">
  <?php if ( $query -> have_posts() ): ?>
    <ul class="task-list">
      <?php while( $query -> have_posts() ): $query -> the_post() ?>

        <?php
        $content = get_post_meta( get_the_ID(), "_lb_task_content", true );
        $status  = get_post_meta( get_the_ID(), "_lb_task_status" , true );
        ?>

        <li class="task-list__item">
          <?php if ( $status === "0" ): ?>
            <div class="task task--bg-red">
              <form class="task-form" action="" method="post">
                <div class="task__upper">
                  <p class="task-content"><?php echo nl2br( esc_html( $content ) ); ?></p>
                </div>
                <div class="task__lower">
                  <select class="task-status" name="status">
                    <option value="0" selected>未完了</option>
                    <option value="1">完了</option>
                  </select>
                  <button class="primary-button" type="submit" name="update-button">更新</button>
                  <button class="primary-button" type="submit" name="trash-button">ゴミ箱</button>
                </div>
                <input type="hidden" name="post-id" value="<?php echo esc_attr( get_the_ID() ); ?>">
              </form>
            </div>
          <?php else: ?>
            <div class="task task--bg-blue">
              <form class="task-form" action="" method="post">
                <div class="task__upper">
                  <p class="task-content"><?php echo nl2br( esc_html( $content ) ); ?></p>
                </div>
                <div class="task__lower">
                  <select class="task-status" name="status">
                    <option value="0">未完了</option>
                    <option value="1" selected>完了</option>
                  </select>
                  <button class="primary-button" type="submit" name="update-button">更新</button>
                  <button class="primary-button" type="submit" name="trash-button">ゴミ箱</button>
                </div>
                <input type="hidden" name="post-id" value="<?php echo esc_attr( get_the_ID() ); ?>">
              </form>
            </div>
          <?php endif; ?>
        </li>

      <?php endwhile; wp_reset_postdata(); ?>
    </ul>
  <?php else: ?>
    <p class="error-message">タスクがありません。</p>
  <?php endif; ?>
</div>
