@extends('layouts.app')

@section('content')

    @if (!empty($freeze) && $freeze != auth()->user()->name)
            <script>
                let timerInterval
                Swal.fire({
                    icon: 'error',
                    title: 'Помилка',
                    html: '<p>Цю роботу редагує <b>{{$freeze}}</b></p><br>{{$job->updated_at}}',
                    timer: 2500,
                    timerProgressBar: false,
                    showConfirmButton: false,
                    didOpen: () => {

                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.history.back ();
                    }
                })
            </script>
    @else


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item"><a href="/">Робота</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Змінити</li>
                    </ol>
                </nav>
            <h1>Оновити: {{$id}}</h1>
            <div class="card" style="background-color: transparent;">

                <div class="card-body">
                    <div class="job-form">

                        <form action="{{route('edit_job')}}" method="post" enctype="multipart/form-data">
                            {{--<input type="hidden" name="_csrf" value="JHqK8d90WYuRtb6Mhc3N0X0hcEVwXuiZvobtgFmgBYxXO_-QrS1g4dqC7eHngIWDRBIyNzQssOuPwITtFM5NtQ==">--}}
                            @csrf
                            <input type="hidden" name="job_id" value="{{$id}}">
                            <div class="row client-info">
                                <div class="col-md-8">
                                    <div class="form-group field-client-full_name required">
                                        <label class="control-label" for="client-full_name">ПІБ Клієнта</label>
                                        <input class="form-control" type="text" disabled="true" value="{{$job->Client->name}}">

                                        <div class="help-block">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group field-client-phone_number required">
                                        <label class="control-label" for="client-phone_number">Телефон</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input class="form-control" type="text" disabled="true" value="{{$job->getClientPhoneNumber()}}">
                                        </div>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group field-vehicle-frame_number required">
                                        <label class="control-label" for="vehicle_frame_number">Номер рами</label>
                                        <input class="form-control" name="Vehicle[frame_number]" type="text" readonly value="{{$job->Vehicle->frame_number}}">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group field-brand-name required">
                                        <label class="control-label" for="brand-name">Бренд</label>
                                        <input class="form-control" type="text" disabled="true" value="{{$job->Vehicle->Moodel->Brand->name}}">

                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group field-model-name required">
                                        <label class="control-label" for="model-name">Модель</label>
                                        <input class="form-control" type="text" disabled="true" value="{{$job->Vehicle->Moodel->name}}">


                                        <div class="help-block"></div>
                                    </div>        </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group field-job_performer_id">
                                        <label class="control-label" for="job_performer_id">Обрати виконавця</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-plus"></i></span>
                                            </div>
                                            <select id="job_performer_id" class="form-control" name="job_performer_id">
                                                <option value=""></option>
                                                @foreach($users_all as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="help-block"></div>
                                    </div>        </div>
                                <div class="col-md-3">
                                    <div class="form-group field-vehicle-mileage">
                                        <label class="control-label" for="vehicle-mileage">Пробіг</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-route"></i></span>
                                            </div>
                                            <input type="text" id="vehicle-mileage" class="form-control" name="Vehicle[mileage]" value="{{$job->Vehicle->mileage}}">
                                        </div>
                                        <div class="help-block"></div>
                                    </div>        </div>
                                <div class="col-md-3">
                                    <div class="form-group field-vehicle_mileage_type">
                                        <label class="control-label" for="vehicle_mileage_type">Тип прібігу</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fas fa-exchange-alt"></i></span>
                                            </div>
                                            <select id="vehicle_mileage_type" class="form-control"
                                                    name="Vehicle[mileage_type]">
                                                <option value="1">Пробіг</option>
                                                <option value="2">Мотогодини</option>
                                            </select>
                                        </div>
                                        <div class="help-block"></div>
                                    </div>        </div>
                            </div>


                            <div class="task-wrapper">
                                <div class="task_line">
                                    <span class="line"></span>
                                    <span class="title">Робота</span>
                                </div>

                                <div class="list">
                                    <div class="form-group field-task-name required">

                                        {{--<form action="{{ route('create_job_input_fields') }}" method="POST">--}}


                                            <table class="table table-bordered" id="dynamicAddRemove">
                                                <tr>
                                                    <th>Код</th>
                                                    <th>Найменування</th>
                                                    <th>Норма годин</th>
                                                    <th>Відсоток виконавця</th>
                                                    <th>Сума</th>
                                                    <th>Дія</th>
                                                </tr>
                                                @if ($task_job->count() == 0)
                                                    <tr>
                                                        <td style="width: 90px;"><input id="code_task_0" type="text" name="taskFields[0][code]" class="task_inp form-control">
                                                        <td>
                                                            {{--<input type="text" required oninvalid="this.setCustomValidity('Заповніть це поле')" oninput="setCustomValidity('')" name="addMoreInputFields[0][subject]" placeholder="Введіть найменування" class="form-control " />--}}
                                                            <select id="task_0" class="task_inp task form-control" name="taskFields[0][name]">
                                                                <option value="0"></option>
                                                            </select>
                                                        </td>
                                                        <td style="width: 120px;"><input id="hour_task_0" type="number" name="taskFields[0][hourly_rate]" class="task_inp form-control">
                                                        <td style="width: 100px;"><input id="present_task_0" type="number" max="100" name="taskFields[0][present]" class="task_inp form-control">
                                                        <td style="width: 100px;"><input id="total_price_task_0" readonly type="text" name="taskFields[0][total_price_task]" class="total_summ_task task_inp form-control">
                                                        <td style="width: 65px;"><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary"><i class="fa fa-plus"></i></button></td>
                                                    </tr>
                                                @else
                                                @foreach($task_job as $i=>$task_j)
                                                <tr>
                                                    <td style="width: 90px;"><input id="code_task_{{$i}}" type="text" name="taskFields[{{$i}}][code]" class="task_inp form-control" value="{{$task_j->pivot->code}}">
                                                    <td>
                                                        <select id="task_{{$i}}" class="task_inp task form-control" name="taskFields[{{$i}}][name]">
                                                            <option value="{{$task_j->id}}">{{$task_j->name}}</option>
                                                        </select>
                                                    </td>
                                                    <td style="width: 120px;"><input id="hour_task_{{$i}}" type="number" name="taskFields[{{$i}}][hourly_rate]" class="task_inp form-control" value="{{$task_j->pivot->hourly_rate}}">
                                                    <td style="width: 100px;"><input id="present_task_{{$i}}" type="number" max="100" name="taskFields[{{$i}}][present]" class="task_inp form-control" value="{{$task_j->pivot->performer_percent}}">
                                                    <td style="width: 100px;"><input id="total_price_task_{{$i}}" readonly type="text" name="taskFields[{{$i}}][total_price_task]" class="total_summ_task task_inp form-control" value="{{$task_j->pivot->price}}">
                                                    @if ($i > 0)
                                                        <td style="width: 65px;"><button type="button" class="btn btn-outline-danger remove-input-field-parts"><i class="fas fa-trash-alt"></i></button></td>
                                                    @else
                                                        <td style="width: 65px;"><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary"><i class="fa fa-plus"></i></button></td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                                @endif
                                            </table>
                                            {{--<button type="submit" class="btn btn-outline-success btn-block">Save</button>--}}
                                        {{--</form>--}}
                                        <div class="total">
                                            <div class="price">
                                                <div id="performer_percent">Виконавець отримає: {{number_format($job->getPerformerPrice(),2,'.', ' ')}} грн.</div>
                                                <div id="total_task"><b>Робота: {{number_format($job->getTaskTotalPrice(),2,'.', ' ')}} грн.</b></div>
                                            </div>
                                        </div>
                                        <div class="help-block"></div>
                                    </div>        </div>
                                <div class="task_line">
                                    <span class="line"></span>
                                    <span class="title">Запчастини</span>
                                </div>
                                <table class="table table-bordered" id="dynamicAddRemoveParts">
                                    <tr>
                                        <th>Код</th>
                                        <th>Найменування</th>
                                        <th>Кількість</th>
                                        <th>Ціна</th>
                                        <th>Сума</th>
                                        <th>Дія</th>
                                    </tr>
                                    @if ($parts_job->count() == 0)
                                        <tr>
                                            <td style="width: 90px;"><input id="code0" type="text" name="PartsFields[0][code]" placeholder="" value="" class="form-control">
                                            <td>
                                                <select id="parts_0" class="article form-control" name="PartsFields[0][name]">
                                                    <option></option>
                                                </select>
                                            </td>
                                            <td style="width: 100px;"><input id="qty_0" type="number" name="PartsFields[0][qty]" class="form-control">
                                            <td style="width: 100px;"><input id="price0" type="number" name="PartsFields[0][price]" class="form-control">
                                            <td style="width: 100px;"><input id="total_0" readonly type="number" name="PartsFields[0][total_price]" class="form-control total_summ_parts">
                                            <td style="width: 65px;"><button type="button" name="addparts" id="dynamic-ar-parts" class="btn btn-outline-primary"><i class="fa fa-plus"></i></button></td>
                                        </tr>
                                    @else
                                        @foreach($parts_job as $i=>$part_j)
                                            <tr>
                                                <td style="width: 90px;"><input id="code{{$i}}" type="text" name="PartsFields[{{$i}}][code]" value="{{$part_j->code}}" class="form-control">
                                                {{--<td>
                                                    <input id="0" type="text" required oninvalid="this.setCustomValidity('Заповніть це поле')" oninput="setCustomValidity('')" name="addMoreInputFields[0][subject]" placeholder="Введіть найменування" value="{{$part_j->name}}" class="form-control " />
                                                </td>--}}
                                                <td>
                                                    <select id="parts_{{$i}}" class="article form-control" name="PartsFields[{{$i}}][name]">
                                                        <option value="{{$part_j->id}}">{{$part_j->name}}</option>
                                                    </select>
                                                </td>
                                                <td style="width: 100px;"><input id="qty_{{$i}}" type="number" name="PartsFields[{{$i}}][qty]" value="{{$part_j->pivot->quantity}}" class="form-control">
                                                <td style="width: 120px;"><input id="price{{$i}}" type="number" name="PartsFields[{{$i}}][price]" value="{{$part_j->pivot->sale_price}}" class="form-control">
                                                <td style="width: 100px;"><input id="total_{{$i}}" readonly type="text" name="PartsFields[{{$i}}][total_price]" value="{{$part_j->pivot->sale_price*$part_j->pivot->quantity}}" class="total_summ_parts form-control">
                                                @if ($i > 0)
                                                    <td style="width: 65px;"><button type="button" class="btn btn-outline-danger remove-input-field-parts"><i class="fas fa-trash-alt"></i></button></td>
                                                @else
                                                    <td style="width: 65px;"><button type="button" name="addparts" id="dynamic-ar-parts" class="btn btn-outline-primary"><i class="fa fa-plus"></i></button></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                                <div class="total">
                                    <div class="price">
                                        <div id="total_parts">Запчастини: {{number_format($job->getPartsTotalPrice(),2,'.', ' ')}} грн.</div>
                                        <div id="total_all"><b>Вcього: {{number_format($job->getTotalPrice(),2,'.', ' ')}} грн.</b></div>
                                    </div>
                                </div>
                                <div class="task_line">
                                    <span class="line"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group field-job-addition">
                                        <label class="control-label" for="job-addition"><i class="fas fa-car-crash"></i> Пошкодження та несправності (якщо такі присутні):</label>
                                        <textarea id="job-addition" class="form-control" name="Job[addition]" rows="6">{{$job->addition}}</textarea>

                                        <div class="help-block"></div>
                                    </div>        </div>
                                <div class="col-md-6">

                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success" id="save"><i class="far fa-save"></i> Зберегти</button>
                                <a href="{{route('job_print', $id)}}"><button type="button" class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> Друк накладної</button></a>
                                {{--<button id="formSubmit" type="button" class="btn btn-success"><i class="far fa-save"></i> Зберегти</button>--}}
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
            /*padding: 8px 15px;*/
            padding: 0;
            margin-bottom: 20px;
            list-style: none;
            background-color: #f5f5f5;
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
            icon: 'error',
            title: '@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach'
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
{{--робота--}}
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = @if($task_job->count() == 0) 0 @else{{$task_job->count()-1}}@endif;

    $("#dynamic-ar").click(function (){
        ++id;
        $("#dynamicAddRemove").append('<tr><td style="width: 90px;"><input id="code_task_'+id+'" type="text" name="taskFields['+ id +'][code]" class="task_inp form-control"><td><select id="task_' + id + '" class="task_inp task form-control" name="taskFields['+id+'][name]"><option></option></select></td><td style="width: 120px;"><input id="hour_task_'+id+'" type="number" name="taskFields['+id+'][hourly_rate]" class="task_inp form-control"><td style="width: 100px;"><input id="present_task_'+id+'" type="number" max="100" name="taskFields['+id+'][present]" class="task_inp form-control"><td style="width: 100px;"><input id="total_price_task_'+id+'" readonly type="text" name="taskFields['+id+'][total_price_task]" class="total_summ_task task_inp form-control"><td><button type="button" class="btn btn-outline-danger remove-input-field"><i class="fas fa-trash-alt"></i></button></td></tr>'
        );
        /* оновити пошук при додаванні */
        $('.task').select2({
            minimumInputLength: 3,
            maximumInputLength: 100,
            placeholder: "Оберіть послугу",
            ajax: {
                url: "{{route('find_jobs')}}",
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
                    //console.log(response)
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
        --id;
        total_sum();
    });

    /*$(document).on("select2:select","select[name='task']",function(e) {*/
    $(document).on("select2:select","select[name='task']",function(e) {
        var data = e.params.data;
        var attributs = $(this).attr('id');
        console.log(data)
        attributs = attributs.substring(5);

        document.querySelector('#code_task_'+attributs).value = data.code;
        document.querySelector('#hour_task_'+attributs).value = data.hourly_rate;
        document.querySelector('#present_task_'+attributs).value = data.performer_percent;
        document.querySelector('#total_price_task_'+attributs).value = data.price;
        total_sum();

    });

    /*$(document).on("change keyup input click", "input[name^='tasks']", function(){*/
    $(document).on("change keyup input click", ".task_inp", function(){
        let str = $(this).attr('id');
        var id = str.replace(/[^+\d]/g, '');
        hour_task = document.querySelector('#hour_task_'+id).value

        document.querySelector('#total_price_task_'+id).value = {{$norma_chas}}*hour_task;

        /*$('#performer_percent').html('Виконавець отримає: 0 грн.');*/


        total_sum();
    });

</script>

{{--товари--}}
<script type="text/javascript">
    /*var i = 0;*/
    var i = @if($parts_job->count() == 0) 0 @else{{$parts_job->count()-1}}@endif;

    $("#dynamic-ar-parts").click(function () {
        ++i;
        $("#dynamicAddRemoveParts").append('<tr><td style="width: 90px;"><input id="code'+ i +'" type="text" name="PartsFields['+ i +'][code]" class="form-control"><td><select id="parts_'+ i +'" class="article form-control" name="PartsFields['+i+'][name]"><option></option></select></td><td style="width: 100px;"><input id="qty_'+ i +'" type="number" name="PartsFields['+ i +'][qty]" class="form-control"></td><td style="width: 120px;"><input id="price'+ i +'" type="number" name="PartsFields['+ i +'][price]" class="form-control"><td style="width: 100px;"><input id="total_'+ i +'" readonly type="text" name="PartsFields['+ i +'][total_price]" placeholder="" class="total_summ_parts form-control"></td><td><button type="button" class="btn btn-outline-danger remove-input-field-parts"><i class="fas fa-trash-alt"></i></button></td></tr>'
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

    $(document).on("select2:select",".article",function(e) {
        var data = e.params.data;
        var attributs = $(this).attr('id');

        attributs = attributs.substring(6);

        document.querySelector('#code'+attributs).value = data.code;
        document.querySelector('#price'+attributs).value = data.price;
        document.querySelector('#qty_'+attributs).value = 1;
        document.querySelector('#total_'+attributs).value = data.price*document.querySelector('#qty_'+attributs).value;
        total_sum();
    });


    $(document).on("change keyup input click", "input[type='number']", function(){
        let str = $(this).attr('id');
        var id = str.replace(/[^+\d]/g, '');
        price = document.querySelector('#price'+id).value
        qty = document.querySelector('#qty_'+id).value

        document.querySelector('#total_'+id).value = price*qty;

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

            /*var total = $('input[name^="total_summ_parts"]');*/
            var total = $('.total_summ_parts');
            /*var total_task = $('input[name^="total_summ_task"]');*/
            var total_task = $('.total_summ_task');
            var suma = 0;
            var suma_task = 0;
            var performer_percent = 0;
            /*console.log(present_task.val())*/
            total.each(function () {
                if (this.value != "") {
                    suma += parseInt(this.value);
                }
            });

            total_task.each(function (key) {
                if (this.value != "") {
                    suma_task += parseInt(this.value);
                    performer_percent += parseInt(this.value) / 100 * parseInt($('#present_task_' + key).val());
                }
            });

            totals = suma + suma_task;

            $('#performer_percent').html('Виконавець отримає: ' + number_format(performer_percent, 2, '.', ' ') + '  грн.');
            $('#total_task').html('<b>Робота: ' + number_format(suma_task, 2, '.', ' ') + '  грн.</b>');
            $('#total_parts').html('Запчастини: ' + number_format(suma, 2, '.', ' ') + ' грн.');
            $('#total_all').html('<b>Вcього: ' + number_format(totals, 2, '.', ' ') + ' грн.</b>');

        }

        /*<div id="performer_percent">Виконавець отримає: number_format($job->getPerformerPrice(),2,'.', ' ') грн.</div>*/


</script>


<script src="{{asset('js/jquery.inputmask.min.js')}}"></script>


{{--select performer and mileage_type--}}
    <script>
        var select_performer_id = document.querySelector('#job_performer_id');
        var select_mileage_type = document.querySelector('#vehicle_mileage_type');
        select_performer_id.value = {{$job->creator_id}};
        select_mileage_type.value = {{$job->Vehicle->mileage_type}};
    </script>



<!-- Script -->
<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        $('#job_performer_id option[value={{$job->performer_id}}]').prop('selected', true);

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

    });

    $(document).ready(function(){

        /*$('[name=task]').select2({*/
        $('.task').select2({
            minimumInputLength: 3,
            maximumInputLength: 100,
            placeholder: "Оберіть товар",
            ajax: {
                url: "{{route('find_jobs')}}",
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

</script>

    <script>
        var auto_refresh = setInterval(
            function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{route('unfreeze')}}",
                    data: {
                        id: {{$job->id}},
                        type: 'updated_at'
                    },
                });
            },
            10000);

        setIdleTimeout(5000, function() {
            //$("#msg").text("Why you leave me?");
            Swal.fire({
                icon: 'warning',
                title: 'Сесія буде розірвана через',
                html: '<b></b> секунд.',
                showConfirmButton: false,
                timer: 10000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Math.round(Swal.getTimerLeft()/1000)
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "{{route('unfreeze')}}",
                        data: {
                            id: {{$job->id}},
                            type: 'updated_name',
                        },
                        success: function (response) {
                            window.location.assign("{{asset('')}}");
                        }
                    });
                }
            }).then(function () {
                //
            });
        }, function() {
            Swal.fire({
                icon: 'success',
                title: 'Сесія відновлена',
                showConfirmButton: false,
                timer: 2000
            })
        });



        function setIdleTimeout(millis, onIdle, onUnidle) {
            var timeout = 0;
            $(startTimer);

            function startTimer() {
                timeout = setTimeout(onExpires, millis);
                $(document).on("mousemove keypress", onActivity);
            }

            function onExpires() {
                timeout = 0;
                onIdle();
            }

            function onActivity() {
                if (timeout) clearTimeout(timeout);
                else onUnidle();
                //since the mouse is moving, we turn off our event hooks for 1 second
                $(document).off("mousemove keypress", onActivity);
                setTimeout(startTimer, 1000);
            }
        }
    </script>


<script>
    window.onbeforeunload = function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{route('unfreeze')}}",
            data: {
                id: {{$job->id}},
                type: 'updated_name',
            }
        });
    }
</script>
{{--<script>
    window.onblur = function (){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{route('unfreeze')}}",
            data: {
                id: {{$job->id}},
            }
        });
    }
</script>--}}
    @endif
@endsection
