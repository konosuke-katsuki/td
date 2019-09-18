<?php
$term_id = get_query_var( "term_id" );
// $child_term_ids = get_term_children( $term_id, "question_category" );
//
// $child_terms = [];
// foreach ( $child_term_ids as $child_term_id ) {
//   $child_terms[] = get_term_by( "id", $child_term_id, "question_category" );
// }

$args = [
  "taxonomy"   => "question_category",
  "orderby"    => "slug",
  "hide_empty" => 0,
  "parent"     => $term_id,
  "childless"  => false,
  "meta_query" => [
    [
      "key"   => "_term_author",
      "value" => strval( wp_get_current_user() -> ID ),
    ],
  ],
];
$term_query = new WP_Term_Query( $args );
$terms      = $term_query -> get_terms();
?>

<div class="chapter-list-block">
  <?php if ( $terms ): ?>
    <ul class="chapter-list">
      <?php foreach ( $terms as $term ): ?>
        <li class="chapter-list__item">
          <div class="chapter">
            <p class="chapter__icon"></p>
            <a class="chapter__name" href="<?php echo esc_url( home_url() . "/question-list/?term_id=" . $term -> term_id ); ?>"><?php echo esc_html( $term -> name ); ?></a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="error-message">章がありません。</p>
  <?php endif; ?>
</div>
