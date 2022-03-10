<?php

namespace view\home;

// 引数でtopicの配列が渡ってくる
function index($topics)
{
    \partials\header();

    $topics = escape($topics);
?>
    <article class="topic" id="topic">
        <div class="topic-inner">
            <h2 class="topic-ttl">トピック一覧</h2>
            <ul class="topic-list">
                <?php
                foreach ($topics as $topic) {
                    // idをキーにしてtopicの編集画面に飛ぶようにする
                    // get_urlメソッドでフルパスを作成
                    // このURLを引数として渡す
                    $url = get_url('detail?topic_id=' . $topic->id);

                    // publishedが１のときは公開、０のときは非公開
                    $label = $topic->finish_flg ? '完了' : '未完了';

                    // ラベルのデザインを切り替える
                    $label_color = $topic->finish_flg ? 'completed' : 'incomplete';
                ?>
                    <li class="topic-item">
                        <a href="<?php echo $url; ?>">
                            <span class="topic-item-label <?php echo $label_color; ?>"><?php echo $label; ?></span>
                            <p class="topic-item-ttl"><?php echo $topic->title; ?></p>
                            <p class="topic-item-body"><?php echo $topic->body; ?></p>
                            <p class="topic-item-position"><?php echo $topic->position; ?></p>
                            <time datetime=""><?php echo $topic->created_at; ?></time>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </article>

<?php
    \partials\footer();
}
