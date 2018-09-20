<?php
use frontend\assets\AppAsset;
use frontend\components\HeadWidget;
use frontend\components\NavWidget;
use frontend\components\FooterWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?= HeadWidget::widget() ?>

<?php $this->head() ?>

<body>
<?php $this->beginBody() ?>

<?= NavWidget::widget() ?>

<?= $content ?>

<?= FooterWidget::widget() ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
