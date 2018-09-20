<?php

use backend\assets\AppAsset;
use yii\helpers\Html;

$this->title = "后台管理";
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<html>
<head>
    <title><?= Html::encode($this->title) ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php $this->head(); ?>

<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
