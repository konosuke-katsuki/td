<?php
include get_template_directory() . "/templates/logic/daily-task/get-daily-task.php";
include get_template_directory() . "/templates/logic/daily-task/get-daily-task-items.php";
include get_template_directory() . "/templates/logic/daily-task/is_completed.php";
include get_template_directory() . "/templates/logic/daily-task/display-background-color.php";
include get_template_directory() . "/templates/logic/daily-task/display-select-attribute.php";

if (
  isset( $_POST[ "daily-task-item-status" ] ) &&
  isset( $_POST[ "daily-task-item-id" ] ) &&
  isset( $_POST[ "daily-task-id" ] )
) {
  update_post_meta( $_POST[ "daily-task-id" ], "_daily_task_item_" . $_POST[ "daily-task-item-id" ] . "_status", $_POST[ "daily-task-item-status" ] );
}

$daily_task               = $get_daily_task();
$daily_task_items_morning = $get_daily_task_items( "morning" );
$daily_task_items_night   = $get_daily_task_items( "night" );
$today                    = new DateTime( "now", new DateTimeZone( "Asia/Tokyo" ) );
?>

<div class="daily-task-block">

  <p class="daily-task-block__date"><?php echo esc_html( $today -> format( "Y-m-d" ) ); ?></p>

  <div class="daliy-task-item-list-block">
    <?php if ( $daily_task_items_morning ): ?>
      <p class="daliy-task-item-list-block__heading">朝</p>
      <div class="daily-task-item-list-block__body">
        <ul class="daily-task-item-list">
          <?php foreach ( $daily_task_items_morning as $key => $item ): ?>
            <li class="daily-task-itam-list__item">
              <?php $daily_task_item_status = $is_completed( $daily_task -> ID, $item -> ID ); ?>
              <div class="daily-task-item<?php echo esc_attr( $display_background_color( $daily_task_item_status ) ); ?>">
                <form action="" method="post">
                  <p class="daily-task-item__heading"><?php echo esc_html( $item -> post_content ); ?></p>
                  <div class="daily-task-item__body">
                    <select class="daily-task-item-status" name="daily-task-item-status">
                      <option value="0" <?php echo esc_attr( $display_select_attribute( $daily_task_item_status, "0" ) ); ?>>未完了</option>
                      <option value="1" <?php echo esc_attr( $display_select_attribute( $daily_task_item_status, "1" ) ); ?>>完了</option>
                    </select>
                    <button class="daily-task-item-button" type="submit">更新</button>
                  </div>
                  <input type="hidden" name="daily-task-item-id" value="<?php echo esc_attr( $item -> ID ); ?>">
                  <input type="hidden" name="daily-task-id" value="<?php echo esc_attr( $daily_task -> ID ); ?>">
                </form>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php else: ?>
      <p class="daily-task-block_error_message">朝のデイリータスク項目が登録されていません。</p>
    <?php endif; ?>
  </div>

  <div class="daliy-task-item-list-block">
    <?php if ( $daily_task_items_night ): ?>
      <p class="daliy-task-item-list-block__heading">夜</p>
      <div class="daily-task-item-list-block__body">
        <ul class="daily-task-item-list">
          <?php foreach ( $daily_task_items_night as $key => $item ): ?>
            <li class="daily-task-itam-list__item">
              <?php $daily_task_item_status = $is_completed( $daily_task -> ID, $item -> ID ); ?>
              <div class="daily-task-item<?php echo esc_attr( $display_background_color( $daily_task_item_status ) ); ?>">
                <form action="" method="post">
                  <p class="daily-task-item__heading"><?php echo esc_html( $item -> post_content ); ?></p>
                  <div class="daily-task-item__body">
                    <select class="daily-task-item-status" name="daily-task-item-status">
                      <option value="0" <?php echo esc_attr( $display_select_attribute( $daily_task_item_status, "0" ) ); ?>>未完了</option>
                      <option value="1" <?php echo esc_attr( $display_select_attribute( $daily_task_item_status, "1" ) ); ?>>完了</option>
                    </select>
                    <button class="daily-task-item-button" type="submit">更新</button>
                  </div>
                  <input type="hidden" name="daily-task-item-id" value="<?php echo esc_attr( $item -> ID ); ?>">
                  <input type="hidden" name="daily-task-id" value="<?php echo esc_attr( $daily_task -> ID ); ?>">
                </form>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php else: ?>
      <p class="daily-task-block_error_message">夜のデイリータスク項目が登録されていません。</p>
    <?php endif; ?>
  </div>

</div>

<div class="cover">
  <img class="covar__img" src="<?php echo esc_url( get_template_directory_uri() . "/img/loading.gif" ); ?>" alt="ロード中">
</div>
