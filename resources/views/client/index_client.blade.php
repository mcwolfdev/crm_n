@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item navbar-right"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Клієнти</li>
                    </ol>
                </nav>
            <h1>Клієнти</h1>

            <span>Всього: <b>{{$clients_all_count}}</b> @if($clients_all_count == 0)записів.@endif @if($clients_all_count==1)запис.@endif @if($clients_all_count==2)записи.@endif @if($clients_all_count==3)записи.@endif @if($clients_all_count==4)записи.@endif @if($clients_all_count>4)записів.@endif</span>
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="#"><i class="fa fa-plus"></i> Додати клієнта</a>
                </div>

                <div class="card-body">
                    <table id="clients" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-danger_edit alert-dismissible">
                                <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Помилка',
                                    showConfirmButton: false,
                                    timer: 2500
                                })
                            </script>
                        @endif
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ПІБ</th>
                            <th>Телефон</th>
                            <th>Вього на суму</th>
                            <th>Борг</th>
                            <th>Кількість робіт</th>
                            <th>Дія</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients_all as $kay=>$client)
                            <tr @if($client->id ==7) style="background-color: #f0ad4e" @endif>
                                <th>{{$client->id}}</th>
                                <td>{{$client->name}}</td>
                                <td>{{$client->phone}}</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                                <td>
                                    <a href="#"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                        {{--<table class="table table-hover text-nowrap" style="font-size: 12px;">
                            <thead>
                            <tr>
                                <th scope="col" style="width: 20px;">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">ПІБ</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">Дія</th>
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"><input id="id" class="form-control" style="width: 60px; height: 30px; font-size: 12px;" name="id"></th>
                                <th scope="col"><input id="id" class="form-control" style="width: 160px; height: 30px; font-size: 12px;"></th>
                                <th scope="col"><input id="id" class="form-control" style="width: 160px; height: 30px; font-size: 12px;" name="id"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clients_all as $kay=>$client)
                            <tr>
                                <th scope="row">{{$kay+1}}</th>
                                <th>{{$client->id}}</th>
                                <td>{{$client->name}}</td>
                                <td>{{$client->phone}}</td>
                                <td>
                                    <a href="#"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>--}}
                    <br>
                    <div style="padding-left: 1em;">
                        {{ $clients_all->links() }}
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

<script>
    $(function () {
        $("#clients").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "searching": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "language": {
                "lengthMenu": "Показати _MENU_ записів",
                "infoFiltered": "(відфільтровано з _MAX_ записів)",
                "search": "Пошук:",
                "paginate": {
                    "first": "Перша",
                    "previous": "Попередня",
                    "next": "Наступна",
                    "last": "Остання"
                },
                "aria": {
                    "sortAscending": ": активуйте, щоб сортувати колонку за зростанням",
                    "sortDescending": ": активуйте, щоб сортувати колонку за спаданням"
                },
                "autoFill": {
                    "cancel": "Відміна",
                    "fill": "Заповнити всі клітинки з <i>%d<\/i>",
                    "fillHorizontal": "Заповнити клітинки горизонтально",
                    "fillVertical": "Заповнити клітинки вертикально"
                },
                "buttons": {
                    "collection": "Список <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                    "colvis": "Видимість колонки",
                    "colvisRestore": "Відновити видимість",
                    "copy": "Копіювати",
                    "copyKeys": "Нажміть ctrl або u2318 + C щоб копіювати інформацію з таблиці до вашого буферу обміну.<br \/><br \/>Щоб відмінити нажміть на це повідомлення або Esc",
                    "copySuccess": {
                        "1": "Скопійовано 1 рядок в буфер обміну",
                        "_": "Скопійовано %d рядків в буфер обміну"
                    },
                    "copyTitle": "Копіювати в буфер обміну",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Показати усі рядки",
                        "_": "Показати %d рядки"
                    },
                    "pdf": "PDF",
                    "print": "Друкувати"
                },
                "emptyTable": "Ця таблиця не містить даних",
                "info": "Показано від _START_ по _END_ з _TOTAL_ записів",
                "infoEmpty": "Показано від 0 по 0 з 0 записів",
                "infoThousands": ",",
                "loadingRecords": "Завантаження",
                "processing": "Опрацювання...",
                "searchBuilder": {
                    "add": "Додати умову",
                    "button": {
                        "0": "Розширений пошук",
                        "_": "Розширений пошук (%d)"
                    },
                    "clearAll": "Очистити все",
                    "condition": "Умова",
                    "conditions": {
                        "date": {
                            "after": "Після",
                            "before": "До",
                            "between": "Між",
                            "empty": "Пусто",
                            "equals": "Дорівнює",
                            "not": "Не",
                            "notBetween": "Не між",
                            "notEmpty": "Не пусто"
                        },
                        "number": {
                            "between": "Між",
                            "empty": "Пусто",
                            "equals": "Дорівнює",
                            "gt": "Більше ніж",
                            "gte": "Більше або дорівнює",
                            "lt": "Менше ніж",
                            "lte": "Менше або дорівнює",
                            "not": "Не",
                            "notBetween": "Не між",
                            "notEmpty": "Не пусто"
                        },
                        "string": {
                            "contains": "Містить",
                            "empty": "Пусто",
                            "endsWith": "Закінчується з",
                            "equals": "Дорівнює",
                            "not": "Не",
                            "notEmpty": "Не пусто",
                            "startsWith": "Починається з"
                        }
                    },
                    "data": "Дата",
                    "deleteTitle": "Видалити правило фільтрування",
                    "leftTitle": "Відступні критерії",
                    "logicAnd": "I",
                    "logicOr": "Або",
                    "rightTitle": "Відступні критерії",
                    "title": {
                        "0": "Розширений пошук",
                        "_": "Розширений пошук (%d)"
                    },
                    "value": "Значення"
                },
                "searchPanes": {
                    "clearMessage": "Очистити все",
                    "collapse": {
                        "0": "Пошукові Панелі",
                        "_": "Пошукові Панелі (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Немає Пошукових Панелей",
                    "loadMessage": "Завантаження Пошукових Панелей",
                    "title": "Активній фільтри - %d"
                },
                "select": {
                    "cells": {
                        "1": "1 клітинку вибрано",
                        "_": "%d клітинок вибрано"
                    },
                    "columns": {
                        "1": "1 колонку вибрано",
                        "_": "%d колонок вибрано"
                    }
                },
                "thousands": ",",
                "zeroRecords": "Не знайдено жодних записів",
                "editor": {
                    "close": "Закрити",
                    "create": {
                        "button": "Cтворити нову",
                        "title": "Cтворити новий запис",
                        "submit": "Cтворити"
                    },
                    "edit": {
                        "button": "Редагувати",
                        "title": "Редагувати запис",
                        "submit": "Оновити"
                    },
                    "remove": {
                        "button": "Видалити",
                        "title": "Видалити",
                        "submit": "Видалити"
                    }
                },
                "datetime": {
                    "minutes": "Хвилина",
                    "months": {
                        "0": "Січень",
                        "1": "Лютий",
                        "10": "Листопад",
                        "11": "Грудень",
                        "2": "Березень",
                        "3": "Квітень",
                        "4": "Травень",
                        "5": "Червень",
                        "6": "Липень",
                        "7": "Серпень",
                        "8": "Вересень",
                        "9": "Жовтень"
                    },
                    "next": "Наступні",
                    "previous": "Попередні",
                    "seconds": "Секунда",
                    "unknown": "-",
                    "weekdays": [
                        "Неділя",
                        "Понеділок",
                        "Вівторок",
                        "Середа",
                        "Четверг",
                        "П'ятниця",
                        "Субота"
                    ]
                }
            }
        }).buttons().container().appendTo('#clients_wrapper .col-md-6:eq(0)');

        $('#button').click(function () {
            alert(table.rows('.selected').data().length + ' row(s) selected');
        });
    });
</script>

<link rel="stylesheet" href="{{asset('js/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('js/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('js/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
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
@endsection
