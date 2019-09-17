<?php
$term_id = get_query_var( "term_id" );

$args = [
  "author"         => wp_get_current_user() -> ID,
  "post_type"      => "question",
  "order"          => "ASC",
  "posts_per_page" => -1,
  "tax_query"      => [
    [
      "taxonomy" => "question_category",
      "field"    => "term_id",
      "terms"    => $term_id,
    ],
  ],
];

$query = new WP_Query( $args );
?>

<div class="question-list-block">
  <?php if ( $query -> have_posts() ): ?>
    <ul class="question-list">
      <?php while( $query -> have_posts() ): $query -> the_post(); ?>
        <li class="question-list__item">
          <div class="question">
            <div class="question-content">
              <p class="question-content_title">問題</p>
              <p class="question-content_body"><?php echo nl2br( esc_html( get_post_meta( get_the_ID(), "_lb_question_content", true ) ) ); ?></p>
            </div>
            <div class="question-answer">
              <p class="question-answer__title">解答</p>
              <p class="question-answer__body"><?php echo nl2br( esc_html( get_post_meta( get_the_ID(), "_lb_question_answer", true ) ) ); ?></p>
            </div>
          </div>
        </li>
      <?php endwhile; wp_reset_postdata(); ?>
    </ul>
  <?php else: ?>
    <p class="error-message">問題がありません。</p>
  <?php endif; ?>
</div>
