<div class="d-flex align-items-center justify-content-between">
    @isset($withSearch)
        <div style="position:relative">
            <input id="searchDatatable" class="form-control search" placeholder="بحث" />
            <span class="icon-search"><i class="fa fa-search"></i></span>
        </div>
    @endisset
    <div class="menu-wrapper">
        <button class="ms-auto dropdown-menu-btn" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="fa fa-ellipsis"></i>
        </button>
        <ul class="list-unstyled action-menu dropdown-menu">
            @isset($withRestoreBtn)
                <li class="item">
                    <a href="" id="restoreAction">
                        <i class="fa fa-rotate icon"></i>
                        <span>استعادة</span>
                    </a>
                </li>
            @endisset
            <li class="item">
                <a href="" id="deleteAction">
                    <i class="fa fa-trash icon"></i>
                    <span>حذف</span>
                </a>
            </li>
        </ul>
    </div>

</div>
