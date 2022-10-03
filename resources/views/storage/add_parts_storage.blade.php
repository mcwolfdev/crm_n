@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item"><a href="{{asset('settings/storage')}}">Товари (склад)</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Прихід товарів</li>
                    </ol>
                </nav>
            <h1>Прихід товарів</h1>
            <div class="card" style="background-color: transparent;">

                <div class="card-body">
                    <div class="job-form">

                        <form action="{{route('add_arrival_spare_parts')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row client-info">
                                <div class="col-md-8">
                                    <div class="form-group field-client-full_name required">
                                        <label class="control-label" for="provisioner">Постачальник</label>

                                        <select id="provisioner" class="provisioner form-control" name="Provisioner">
                                            <option></option>
                                        </select>

                                        <div class="help-block">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label class="control-label" for="client-phone_number">На склад</label>
                                        <select id="storage" class="storage form-control" name="storage">
                                            <option></option>
                                            @foreach($storage_all as $storage)
                                                <option value="{{$storage->id}}">{{$storage->name}} [{{$storage->address}}]</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="task-wrapper">
                                <div class="task_line">
                                    <span class="line"></span>
                                    <span class="title">Товари</span>
                                </div>

                                <div class="list">
                                    <div class="form-group field-task-name required">

                                            <table class="table table-bordered" id="dynamicAddRemoveParts">
                                                <tr>
                                                    <th>Код</th>
                                                    <th>Найменування</th>
                                                    <th>Кількість</th>
                                                    <th>Вхід</th>
                                                    <th>Всього</th>
                                                    <th>Роздріб</th>
                                                    <th>Дія</th>
                                                </tr>
                                                <tr>
                                                    <td style="width: 90px;"><input id="code0" type="text" name="PartsFields[0][code]" placeholder="..." value="" class="form-control">
                                                    <td>
                                                        <select id="parts_0" class="article form-control" name="PartsFields[0][name]">
                                                            <option></option>
                                                        </select>
                                                    </td>
                                                    <td style="width: 100px;"><input id="qty_0" type="number" name="PartsFields[0][qty]" class="form-control">
                                                    <td style="width: 100px;"><input id="price0" type="number" name="PartsFields[0][price]" class="form-control">
                                                    <td style="width: 100px;"><input id="total_summ_parts_0" name="total_summ_parts_0" class="form-control total_summ_parts" readonly>
                                                    <td style="width: 100px;"><input id="retail_price_0" type="number" name="PartsFields[0][retail_price]" class="form-control">
                                                    <td style="width: 65px;"><button type="button" name="addparts" id="dynamic-ar-parts" class="btn btn-outline-primary"><i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            </table>

                                        <div class="total">
                                            <div class="price">
                                                <div id="total_parts"><b>Робота: --- грн.</b></div>
                                            </div>
                                        </div>
                                        <div class="help-block"></div>
                                    </div>
                                </div>

                                <div class="task_line">
                                    <span class="line"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Зберегти</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <style>
        .breadcrumbs {
            padding: 55px 0px;
            margin-bottom: -30px;
            list-style: none;
            border-radius: 4px;
        }

        .task-wrapper > .task_line > .title {
            position: relative;
            z-index: 2;
            font-size: 25px;
            background: url(/img/bg.png);
            text-shadow: 1px 1px 0 #fff;
            padding: 0 12px 0 10px;
        }

        .task-wrapper > .task_line > .line {
            display: inline-block;
            border-top: 2px dashed rgba(0,0,0,0.24);
            height: 2px;
            width: 100%;
            position: absolute;
            left: 0;
            top: 17px;
        }

        .task-wrapper > .task_line {
            text-align: center;
            position: relative;
            height: 30px;
            margin-bottom: 5px;
        }

        .total {
            margin-top: 20px;
        }

        .total .price {
            font-size: 12px;
            text-align: right;
        }
    </style>

{{--помилка або оновлено--}}
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })

        Toast.fire({
            icon: 'success',
            title: '{{ Session::get("success") }}'
        })
    </script>
@endif
@if (Session::has('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })

        Toast.fire({
            icon: 'success',
            title: '{{ Session::get("success") }}'
        })
    </script>
@endif



{{--multiinput--}}
{{--товари--}}
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var i = 0;

    $(document).ready(function(){
        $('.article').select2({
            minimumInputLength: 3,
            maximumInputLength: 100,
            placeholder: "Оберіть товар",
            ajax: {
                url: "{{route('find_parts')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

        $('.storage').select2({
            maximumInputLength: 100,
            placeholder: "Оберіть склад",
            allowClear: true
        });

        //спилок постачальників
        $('.provisioner').select2({
            minimumInputLength: 3,
            maximumInputLength: 100,
            placeholder: "Оберіть постачальника",
            ajax: {
                url: "{{route('find_provisioner')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

    });

    $("#dynamic-ar-parts").click(function () {
        ++i;
        $("#dynamicAddRemoveParts").append('<tr><td style="width: 90px;"><input id="code'+ i +'" type="text" name="PartsFields['+ i +'][code]" class="form-control"><td><select id="parts_'+ i +'" class="article form-control" name="PartsFields['+i+'][name]"><option></option></select></td><td style="width: 100px;"><input id="qty_'+ i +'" type="number" name="PartsFields['+ i +'][qty]" class="form-control"></td><td style="width: 120px;"><input id="price'+ i +'" type="number" name="PartsFields['+ i +'][price]" class="form-control"><td style="width: 100px;"><input id="total_summ_parts_'+ i +'" name="total_summ_parts_'+ i +'" class="form-control total_summ_parts" readonly><td style="width: 100px;"><input id="retail_price_'+ i +'" type="text" name="PartsFields['+ i +'][retail_price]" placeholder="" class="form-control"></td><td><button type="button" class="btn btn-outline-danger remove-input-field-parts"><i class="fas fa-trash-alt"></i></button></td></tr>'
        );
        /* оновити пошук при додаванні */
        $('.article').select2({
            minimumInputLength: 3,
            maximumInputLength: 100,
            placeholder: "Оберіть товар",
            ajax: {
                url: "{{route('find_parts')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        total_sum();
    });

    $(document).on('click', '.remove-input-field-parts', function () {
        $(this).parents('tr').remove();
        --i;
        total_sum();
    });

/*    $('.article').on('select2:select', function (e) {*/
    $(document).on("select2:select",".article",function(e) {
        var data = e.params.data;
        var attributs = $(this).attr('id');

        attributs = attributs.substring(6);

        document.querySelector('#code'+attributs).value = data.code;
        document.querySelector('#price'+attributs).value = data.price;
        document.querySelector('#qty_'+attributs).value = 1;
        document.querySelector('#total_summ_parts_'+attributs).value = document.querySelector('#price'+attributs).value*document.querySelector('#qty_'+attributs).value;
        document.querySelector('#retail_price_'+attributs).value = data.price;
        total_sum();
    });



    $(document).on("change keyup input click", "input[type='number']", function(){
        let str = $(this).attr('id');
        var id = str.replace(/[^+\d]/g, '');
        price = document.querySelector('#price'+id).value
        qty = document.querySelector('#qty_'+id).value

        document.querySelector('#total_summ_parts_'+id).value = price*qty;

        total_sum();
    });


    number_format = function (number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);

        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

        return x1 + x2;
    }

        function total_sum() {
            var total = $('.total_summ_parts');
            var suma = 0;
            total.each(function () {
                if (this.value != "") {
                    suma += parseInt(this.value);
                }
            });

            $('#total_parts').html('<b>Вcього: ' + number_format(suma, 2, '.', ' ') + ' грн.</b>');

        }
</script>

@endsection
