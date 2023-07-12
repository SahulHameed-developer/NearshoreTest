<?php

// 検索結果は０件の場合。
$this->start('SEARCH_NOT_FOUND');
echo '検索条件に合致するデータがありません。';
$this->end();

//コードマスタテーブルの順序番号
$this->start('M_SOSIKI_VAL');
echo '2';
$this->end();
$this->start('M_KBUNRUI_VAL');
echo '3';
$this->end();
$this->start('M_IINKAI_VAL');
echo '5';
$this->end();
$this->start('M_KURABU_VAL');
echo '6';
$this->end();
$this->start('M_YKBUNRUI_VAL');
echo '10';
$this->end();
$this->start('M_KEIYAKU_VAL');
echo '16';
$this->end();
?>