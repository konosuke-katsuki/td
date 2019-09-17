<?php
$term_id        = get_query_var( "term_id" );
$child_term_ids = get_term_children( $term_id, "question_category" );

$child_terms = [];
foreach ( $child_term_ids as $child_term_id ) {
  $child_terms[] = get_term_by( "id", $child_term_id, "question_category" );
}
?>

<div class="chapter-list-block">
  <?php if ( $child_terms ): ?>
    <ul class="chapter-list">
      <?php foreach ( $child_terms as $child_term ): ?>
        <li class="chapter-list__item">
          <div class="chapter">
            <p class="chapter__icon"></p>
            <a class="chapter__name" href="<?php echo esc_url( home_url() . "/question-list/?term_id=" . $child_term -> term_id ); ?>"><?php echo esc_html( $child_term -> name ); ?></a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="error-message">章がありません。</p>
  <?php endif; ?>
</div>
