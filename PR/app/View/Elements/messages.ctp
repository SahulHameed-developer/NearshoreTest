<?php

// 検索結果は０件の場合。
$this->start('SEARCH_NOT_FOUND');
echo '検索条件に合致するデータがありません。';
$this->end();

$this->start('DATA_NOT_FOUND');
echo 'データがありません。';
$this->end();

?>