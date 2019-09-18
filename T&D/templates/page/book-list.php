<?php
$args = [
  "taxonomy"   => "question_category",
  "orderby"    => "slug",
  "hide_empty" => 0,
  "parent"     => 0,
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

<div class="book-list-block">
  <?php if ( $terms ): ?>
    <ul class="book-list">
      <?php foreach ( $terms as $term ): ?>
        <li class="book-list__item">
          <div class="book">
            <a class="book__name" href=<?php echo esc_url( home_url() . "/chapter/?term_id=" . $term -> term_id ); ?>><?php echo esc_html( $term -> name ); ?></a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="error-message">書籍がありません。</p>
  <?php endif; ?>
</div>
