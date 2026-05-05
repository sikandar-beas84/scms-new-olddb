<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- Include DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: "Search user...",
            allowClear: true
        });
    });
</script>

<!-- Page header -->
<div class="page-header page-header-primary shadow">
    
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="javascript:;" class="breadcrumb-item"><?= $title ?></a>
                <!-- <span class="breadcrumb-item active">Validation styles</span> -->
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <!-- Custom styles -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?= $title ?></h5>
                </div>
                <form id="permissionForm">
                    <div class="card-body">
                        <div id="showMsg"></div>
                        <div class="row mb-3">
                            <label class="col-form-label col-lg-4">User ID <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <select id="user_id" class="form-control mb-3">
                                    <option value="">Select User</option>
                                    <?php foreach ($users as $u): ?>
                                        <option value="<?= $u['id'] ?>"><?= $u['first_name'].' '.$u['last_name'] ?> (<?= $u['dept_name'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div id="menuTree">
                            <?php foreach ($menus as $parent): ?>
                                <div>
                                    <label>
                                        <input type="checkbox" class="parent" value="<?= $parent['id'] ?>">
                                        <strong><?= $parent['title'] ?></strong>
                                    </label>

                                    <?php foreach ($parent['children'] as $child): ?>
                                        <div style="margin-left:25px">
                                            <label>
                                                <input type="checkbox" class="child"
                                                       data-parent="<?= $parent['id'] ?>"
                                                       value="<?= $child['id'] ?>">
                                                <?= $child['title'] ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Menu Permission Lists</h5>
                </div>

                <table id="menuPermissionLists" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Menu Title</th>
                            <th>Can View</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                </table>
                

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // Datatable ajax call
        var table = $('#menuPermissionLists').DataTable({
            ajax: {
                url: "<?= base_url('admin/menu-permission/fetch') ?>",
                dataSrc: 'permissions',
                type: 'POST',
                dataType: 'json',
            },
            columns: [
                { data: 'id' },
                { 
                    data: null,
                    render: function(data, type, row) {
                        let fname = row.first_name ? row.first_name : '';
                        let lname = row.last_name ? row.last_name : '';
                        return fname + ' ' + lname;
                    },
                    defaultContent: ''
                },
                { data: 'menu_title' },
                {
                    data: 'can_view',
                    render: function(data, type, row) {
                        let checked = (data === 't' || data === true || data === 1 || data === '1' || data === 'true') ? 'checked' : '';
                        return `
                        <div class="form-check-horizontal">
                            <label class="form-check form-switch mb-0">
                                <input type="checkbox" class="menu-can-view form-check-input" data-id="${row.id}" ${checked} />
                            </label>
                        </div>                          
                        `;
                    },
                }
                // {
                //     data: null,
                //     render: function(data, type, row) {
                //         return `
                //             <span class="editBtn" data-id="${row.id}" title="Edit"><i class="ph-note-pencil"></i></span> | <span class="deleteBtn" data-id="${row.id}" title="Delete"><i class="ph-trash"></i></span>
                //         `;
                //     }
                // }
            ],

            columnDefs: [
                { targets: 0, visible: false, searchable: false, orderable: true }
            ],
            order: [[0, 'desc']],
        });

        $(document).on('change', '.menu-can-view', function(){
            let checkbox = $(this);
            let id = checkbox.data('id');
            let isChecked = checkbox.prop('checked') ? 1 : 0;

            $.ajax({
                url: "<?= base_url('admin/menu-permission/set-menu-view') ?>",
                type: "POST",
                data: {
                    id: id,
                    is_checked: isChecked,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                success: function(res) {
                    // Reload DataTable to update toggles
                    table.ajax.reload(null, false);
                },
                error: function() {
                    console.log("Failed to update menu permission");
                    checkbox.prop('checked', false)
                }
            });
        }); 
        
        $('#user_id').change(function () {
            let userId = $(this).val();
            $('input[type=checkbox]').prop('checked', false);

            if (!userId) return;

            $.post('<?= site_url("admin/menu-permission/get") ?>', {user_id: userId}, function (res) {
                $.each(res, function (menuId) {
                    $('input[value="'+menuId+'"]').prop('checked', true);
                });
            });
        });

        $(document).on('change', '.child', function () {
            if ($(this).is(':checked')) {
                let parent = $(this).data('parent');
                $('input[value="'+parent+'"]').prop('checked', true);
            }
        });

        $(document).on('change', '.parent', function () {
            let pid = $(this).val();
            $('input[data-parent="'+pid+'"]').prop('checked', $(this).is(':checked'));
        });

        $('#permissionForm').submit(function (e) {
            e.preventDefault();

            let menus = [];
            $('input[type=checkbox]:checked').each(function () {
                menus.push($(this).val());
            });

            $.post('<?= site_url("admin/menu-permission/new-save") ?>', {
                user_id: $('#user_id').val(),
                menus: menus
            }, function (res) {
                alert(res.message);
                table.ajax.reload(null, false);
            }, 'json');
        });
    });
</script>


