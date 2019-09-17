<?php

class Lb_Custom_Taxonomy_Question_Category {

  private $taxonomy = "question_category";

  public function __construct() {
    add_action( "init", [ $this, "create_taxonomy" ], 100 );
  }

  public function create_taxonomy() {
    $labels = [
      "all_items"                  => "練習問題カテゴリー一覧",
      "edit_item"                  => "練習問題カテゴリーを編集",
      "view_item"                  => "練習問題カテゴリーを表示",
      "update_item"                => "練習問題カテゴリーを更新",
      "add_new_item"               => "新規練習問題カテゴリーを追加",
      "new_item_name"              => "新規練習問題カテゴリーの名前",
      "parent_item"                => "親の練習問題カテゴリー",
      "parent_item_colon"          => "親の練習問題カテゴリー：",
      "search_items"               => "練習問題カテゴリーを検索",
      "popular_items"              => "人気の練習問題カテゴリー",
      "separate_items_with_commas" => "練習問題カテゴリーをコンマで区切ってください",
      "add_or_remove_items"        => "練習問題カテゴリーの追加または削除",
      "choose_from_most_used"      => "よく使われている練習問題カテゴリーから選択",
      "not_found"                  => "練習問題カテゴリーが見つかりません",
    ];

    $args = [
      "label"             => "練習問題カテゴリー",
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

    register_taxonomy( $this -> taxonomy, "question", $args );
  }
}
