<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= lang('main.notifications') ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?= lang('main.home') ?></a></li>
                        <li class="breadcrumb-item active"><?= lang('main.notifications') ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">
                                <i class="fas fa-sitemap mx-2"></i><?= lang('main.listNotifications') ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="toolbar">
                                <input type="text" id="search" name="search" class="mb-2 form-control" placeholder="Search">
                            </div>
                            <table
                                id="table"
                                class="table table-sm table-striped"
                                data-toolbar="#toolbar"
                                data-show-refresh="true"
                                data-show-toggle="true"
                                data-show-columns="true"
                                data-show-columns-toggle-all="true"
                                data-detail-view="true"
                                data-show-export="true"
                                data-click-to-select="true"
                                data-detail-formatter="detailFormatter"
                                data-minimum-count-columns="2"
                                data-show-pagination-switch="false"
                                data-pagination="true"
                                data-id-field="id"
                                data-page-list="[10, 25, 50, 100, all]"
                                data-show-footer="false"
                                data-side-pagination="server"
                                data-query-params="queryParams"
                                data-url="<?= base_url("{$module}/{$class}/datatable") ?>"
                                data-response-handler="responseHandler">
                            </table>


                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    var $table = $('#table')
    var selections = []

    function getIdSelections() {
        return $.map($table.bootstrapTable('getSelections'), function(row) {
            return row.id
        })
    }

    function responseHandler(res) {
        $.each(res.rows, function(i, row) {
            row.state = $.inArray(row.id, selections) !== -1
        })
        return res
    }

    function detailFormatter(index, row) {
        var html = []
        $.each(row, function(key, value) {
            html.push('<p><b>' + key + ':</b> ' + value + '</p>')
        })
        return html.join('')
    }

    function operateFormatter(value, row, index) {
        var html = `<div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-sm btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false" data-container="body">
                            <span class="sr-only">Toggle Dropdown</span>
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" href="javascript:void(0)" title="<?= lang('main.details') ?>"><i class="far fa-list-alt mx-2"></i><?= lang('main.details') ?></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)" title="<?= lang('main.resend') ?>"><i class="fas fa-redo mx-2"></i><?= lang('main.resend') ?></a>
                        </div>
                    </div>`;
        return html;
    }

    window.operateEvents = {
        'click .resend': function(e, value, row, index) {
            alert("resending the notification ..");
        },
        'click .details': function(e, value, row, index) {
            alert("details of the notification ..");
        }
    }

    function totalTextFormatter(data) {
        return 'Total'
    }

    function totalNameFormatter(data) {
        return data.length
    }

    function totalPriceFormatter(data) {
        var field = this.field
        return '$' + data.map(function(row) {
            return +row[field].substring(1)
        }).reduce(function(sum, i) {
            return sum + i
        }, 0)
    }

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable({
            //height: 550,
            //locale: $('#locale').val(),
            locale: 'en-us',
            columns: [{
                    field: 'sn',
                    title: '#',
                    sortable: false,
                    align: 'center',
                },
                {
                    field: 'created_at',
                    title: '<?= lang('main.createdAt') ?>',
                    sortable: true,
                    align: 'center'
                },
                {
                    field: 'description',
                    title: '<?= lang('main.description') ?>',
                    sortable: true,
                    align: 'center'
                },
                {
                    field: 'type',
                    title: '<?= lang('main.type') ?>',
                    sortable: true,
                    align: 'center'
                },
                {
                    field: 'sentIcon',
                    title: '<?= lang('main.sent') ?>',
                    sortable: true,
                    align: 'center'
                },
                {
                    field: 'operate',
                    title: '<?= lang('main.actions') ?>',
                    align: 'center',
                    clickToSelect: false,
                    events: window.operateEvents,
                    formatter: operateFormatter,
                    visible: true
                }
            ]
        })

        $table.on('all.bs.table', function(e, name, args) {
            //console.log(name, args)
        })

    }

    $(function() {
        initTable()

    })

    $('#search').on('keyup', function() {
        $table.bootstrapTable('refresh');
    });

    function queryParams(params) {
        params.search = $('#search').val();
        return params
    }

    function load_form(url, title) {
        $('#form_title').html('');
        $('#form_fields').html('');
        $.ajax({
            url: url,
            method: 'get',
            success: function(response) {
                $('#form_title').html(title);
                $('#form_fields').html(response);
            }
        });
    }
</script>