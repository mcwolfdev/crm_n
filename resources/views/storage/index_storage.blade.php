@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item navbar-right"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Товари (склад)</li>
                    </ol>
                </nav>
            <h1>Товари (склад)</h1>


            <div class="card">
                <div class="card-header">
                    <a class="btn btn-info" href="#"><i class="fa fa-plus"></i> Додати товар</a>
                    <a class="btn btn-success" href="#"><i class="fa fa-plus"></i> Прихід товару</a>
                    <a class="btn btn-warning" href="#"><i class="fa fa-minus"></i> Повернення товару</a>
                    <a class="btn btn-warning" href="#"><i class="fa fa-minus"></i> Списання товару</a>
                </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Код</th>
                        <th>Назва</th>
                        <th>Вхідна цна</th>
                        <th>Роздрібна ціна</th>
                        <th>Кількість</th>
                        <th>Один.вим.</th>
                        <th>Дія</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($parts as $part)
                    <tr>
                        <td>{{$part->code}}</td>
                        <td>{{$part->name}}</td>
                        <td>{{$part->purchase_price}}</td>
                        <td>{{$part->retail_price}}</td>
                        <td>{{$part->quantity}}</td>
                        <td>{{$part->unit}}</td>
                        <td>
                            <a href="{{$part->id}}"><i class="fas fa-pencil-alt"></i></a>
                            <a href="{{$part->id}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    {{--<tfoot>
                    <tr>
                        <th>Rendering engine</th>
                        <th>Browser</th>
                        <th>Platform(s)</th>
                        <th>Engine version</th>
                        <th>CSS grade</th>
                    </tr>
                    </tfoot>--}}
                </table>
            </div>
            </div>


        </div>
    </div>
</div>



{{--<script>

    // Eseguo le istruzioni da : https://datatables.net/blog/2019-01-11

    var fatherEditor; // use a global for the submit and return data rendering in the examples

    $(document).ready(function() {

        fatherEditor = new $.fn.dataTable.Editor( {
            "serverSide": true,
            ajax: {
                url: "dist/cont/tpl_lista_location/location.php",
                type: 'POST',
                data: function ( d ) {
                    d.csrf_token = "C30ACFF5E3D34421E96D5FED43C03BABA5DC9A8A55A254FFA042882C16581366";
                }
            },

            "table": "#example1",
            "fields": [
                {
                    label:  "ID:",
                    name:   "location.location_id",
                    type:   "readonly"
                },
                {
                    label: "ID:",
                    name: "location.group_of_id",
                    type:  "hidden",
                    def: 2                  },
                {
                    label: "Name:",
                    name: "location.name",
                },
                /*{
                    label: "Group:",
                    type: "select",
                    name: "location.group_of_id"
                },*/
                {
                    label: "Clients:",
                    type: "select",
                    name: "location.clients_id"
                },
                {
                    label: "FullAddress:",
                    name: "location.fulladdress",
                    type: "textarea"
                },
                {
                    label: "CAP:",
                    name: "location.cap"
                },

            ]
        });

        // Activate an inline edit on click of a table cell
        /*$('#example').on( 'click', 'tbody td:not(:first-child)', function (e) {
            fatherEditor.inline( this, {
                buttons: { label: '&gt;', fn: function () { this.submit(); } }
            } );
        });*/


        var fatherTable = $('#example1').DataTable({
            "serverSide": true,
            ajax: {
                url: "dist/cont/tpl_lista_location/location.php",
                type: 'POST',
                data: function ( d ) {
                    d.csrf_token = "C30ACFF5E3D34421E96D5FED43C03BABA5DC9A8A55A254FFA042882C16581366";
                }
            },
            paging:                     false,
            columns: [
                {
                    "class":            "dtr-control",
                    "width":            '5px',
                    "data":             "location.location_id",
                    render:             simple_null,
                    "defaultContent":   ""
                },
                { title:                'Name',
                    "data":               "location.name",
                    "width":              '150px'
                },
                { title:                'CAP',
                    "data":               "location.cap",
                    "width":              '150px'
                },
                {
                    title:                'Clients',
                    "data":               "clients.name",
                    "width":              '200px'
                },
                {
                    title:                'Group',
                    "data":               "group_of.name",
                    "width":              '200px'
                },
                {
                    title:                'View',
                    class:                'dt-center',
                    data:                 'clients.uuid_min',
                    width:                '2.5em',
                    render: function ( data, type, row ) {
                        return '<a href="machines.php?search=@' + row.clients.uuid_min + '#' + row.location.name +'"><i class="fas fa-binoculars"></i></a>';
                    }
                }
            ],
            columnDefs: [
                { targets: 0, responsivePriority: 1, orderable: false},
                { targets: 1, responsivePriority: 3},
                { targets: 5, responsivePriority: 8},
                { targets: 2, responsivePriority: 20},
                { targets: 4, responsivePriority: 200}
            ],
            buttons: [
                { extend: "create", editor: fatherEditor },
                { extend: "edit",   editor: fatherEditor },
                /*{ extend: 'remove', editor: fatherEditor },*/
                'print', 'copy', 'excel', 'pdf', 'csv'
            ],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/it_it.json"},
        });


        $(window).on('resize', function () {
            fatherTable.columns.adjust();
        });

    });

</script>--}}

{{--
language: {
url: '{{asset('js/datatables/uk.json')}}',
},
--}}

<script>
    $(function () {
        $("#example1").DataTable({
            /*language: {
                url: '{{asset('js/datatables/uk.json')}}',
            },*/
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "searching": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#example1 tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
            console.log((this).toggleClass('selected'))
        });

        $('#button').click(function () {
            alert(table.rows('.selected').data().length + ' row(s) selected');
        });
    });
</script>



<!-- DataTables  & Plugins -->
<script src="{{asset('js/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/jszip/jszip.min.js')}}"></script>
<script src="{{asset('js/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('js/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('js/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('js/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('js/datatables-buttons/js/buttons.colVis.min.js')}}"></script>


    <style>
        .breadcrumbs {
            padding: 55px 0px;
            margin-bottom: -30px;
            list-style: none;
            border-radius: 4px;
        }

        .job-status {
            padding: 0.2em 0.6em 0.3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25em;
        }

    </style>
    <script>
        $(document).ready(function () {
            $('[name=id]').bind('change keyup input click', function () {
                if (this.value.match(/[^0-9]/g)) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                }
            });
        });

        $("#id").keyup(function(event){
            if(event.keyCode == 13){
                $("#id").click();
                $(this).val('');
            }
        });
    </script>
@endsection
