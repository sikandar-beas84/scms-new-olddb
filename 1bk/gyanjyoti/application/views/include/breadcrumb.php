<div class="page-header d-xl-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title">
            <button type="button" class="btn btn-danger me-2" onclick="history.back();">
                <i class="fa fa-arrow-left"></i>
            </button>
            <span class="font-weight-normal text-muted ms-2"> <?=$page_title;?></span>
        </h4>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-flex breadcrumb-res">
                <div class="header-datepicker me-3">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="feather feather-calendar"></i>
                        </div>
                        <input class="form-control fc-datepicker pb-0 pt-0" value="<?= date('M d,Y') ?>" type="text" disabled>
                    </div>
                </div>
                <div class="header-datepicker picker2 me-3">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="feather feather-clock"></i>
                        </div>
                        <input id="tpBasic" type="text" placeholder="<?= date('h:i A') ?>" class="form-control input-small pb-0 pt-0" disabled>
                    </div>
                </div><!-- wd-150 -->
            </div>
        </div>
    </div>
</div>