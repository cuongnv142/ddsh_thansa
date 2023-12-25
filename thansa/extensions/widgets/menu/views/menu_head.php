<?php
if ($data) {
    ?>
    <div class="menu-items">
        <?php
        $url_current = Yii::$app->request->url;
        foreach ($data as $key => $menu) {
            $class = '';
            if ($url_current == $menu['gen_url']) {
                $class = 'active';
            }
            ?>
            <div class="menu-links">
                <div class="menu-parent <?= $class ?>">
                    <a href="<?= $menu['gen_url']; ?>" title="<?= $menu['name']; ?>"><?= $menu['name']; ?></a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
<?php } ?>