<?php
if ($data) {
    ?>
    <div class="col-lg-4 col-12 col-md-6 mt-md-4 mt-lg-0 mt-4 pl-xl-5">
        <div class="col-center">
            <div class="list-category">
                <?php
                foreach ($data as $key => $menu) {
                    ?>
                    <a href="<?= $menu['gen_url']; ?>" title="<?= $menu['name']; ?>"><?= $menu['name']; ?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>