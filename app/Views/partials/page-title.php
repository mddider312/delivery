<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18"><?= $title ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active"><?= $li_1 ?></li>
                    <?php if(isset($li_2)):  ?>
                        <li class="breadcrumb-item active"><?= $li_2 ?></li>
                    <?php endif ?>
                    
                    <?php if(isset($li_3)):  ?>
                        <li class="breadcrumb-item active"><?= $li_3 ?></li>
                    <?php endif ?>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->