<?php

class Lb_Custom_Taxonomy_Daily_Task_Item_Category {

  private $taxonomy = "daily_task_item_category";

  public function __construct() {
    add_action( "init", [ $this, "create_taxonomy" ], 100 );
  }

  public function create_taxonomy() {
    $labels = [
      "all_items"                  => "デイリータスクカテゴリー一覧",
      "edit_item"                  => "デイリータスクカテゴリーを編集",
      "view_item"                  => "デイリータスクカテゴリーを表示",
      "update_item"                => "デイリータスクカテゴリーを更新",
      "add_new_item"               => "新規デイリータスクカテゴリーを追加",
      "new_item_name"              => "新規デイリータスクカテゴリーの名前",
      "parent_item"                => "親のデイリータスクカテゴリー",
      "parent_item_colon"          => "親のデイリータスクカテゴリー：",
      "search_items"               => "デイリータスクカテゴリーを検索",
      "popular_items"              => "人気のデイリータスクカテゴリー",
      "separate_items_with_commas" => "デイリータスクカテゴリーをコンマで区切ってください",
      "add_or_remove_items"        => "デイリータスクカテゴリーの追加または削除",
      "choose_from_most_used"      => "よく使われているデイリータスクカテゴリーから選択",
      "not_found"                  => "デイリータスクカテゴリーが見つかりません",
    ];

    $args = [
      "label"             => "デイリータスクカテゴリー",
      "labels"            => $labels,
      "public"            => true,
      "show_admin_column" => true,
      "hierarchical"      => true,
      "capabilities"      => [
        "manage_terms",
        "edit_terms",
        "delete_terms",
        "assign_terms",
      ],
    ];

    register_taxonomy( $this -> taxonomy, "daily_task_item", $args );
  }
}
