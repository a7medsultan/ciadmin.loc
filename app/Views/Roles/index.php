<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Roles</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Roles</li>
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
                            <h5 class="m-0"><i class="fas fa-user-check mx-2"></i>List Roles</h5>
                        </div>
                        <div class="card-body">
                            <div id="toolbar">
                            </div>
                            <table
                                id="table"
                                class="table table-sm table-striped"
                                data-toolbar="#toolbar"
                                data-search="true"
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
                                data-url="<?= base_url('roles/datatable') ?>"
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
        return $.map($table.bootstrapTable('getSelections'), function (row) {
            return row.id
        })
    }

    function responseHandler(res) {
        $.each(res.rows, function (i, row) {
            row.state = $.inArray(row.id, selections) !== -1
        })
        return res
    }

    function detailFormatter(index, row) {
        var html = []
        $.each(row, function (key, value) {
            html.push('<p><b>' + key + ':</b> ' + value + '</p>')
        })
        return html.join('')
    }

    function operateFormatter(value, row, index) {
        var html = `<div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-sm btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item edit" href="javascript:void(0)" title="Like"><i class="fa fa-edit mx-2"></i>Edit</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item delete" href="javascript:void(0)" title="Remove"><i class="fa fa-trash mx-2"></i>Delete</a>
                        </div>
                    </div>`;
        return html;
    }

    window.operateEvents = {
        'click .edit': function (e, value, row, index) {
            alert('You click edit action, row: ' + JSON.stringify(row))
        },
        'click .delete': function (e, value, row, index) {
            $table.bootstrapTable('remove', {
                field: 'id',
                values: [row.id]
            })
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
        return '$' + data.map(function (row) {
            return +row[field].substring(1)
        }).reduce(function (sum, i) {
            return sum + i
        }, 0)
    }

    function initTable() {
        $table.bootstrapTable('destroy').bootstrapTable({
            //height: 550,
            //locale: $('#locale').val(),
            locale: 'en-us',
            columns: [
                {
                    field: 'id',
                    title: '#',
                    sortable: true,
                    align: 'center',
                },
                {
                    field: 'name',
                    title: 'Role Name',
                    sortable: true,
                    align: 'center'
                },

                {
                    field: 'operate',
                    title: 'Actions',
                    align: 'center',
                    clickToSelect: false,
                    events: window.operateEvents,
                    formatter: operateFormatter
                }
            ]
        })
        
        $table.on('all.bs.table', function (e, name, args) {
            console.log(name, args)
        })
        
    }

    $(function () {
        initTable()
    })
</script>