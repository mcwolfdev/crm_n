@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item navbar-right"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Постачальники</li>
                    </ol>
                </nav>
            <h1>Постачальники</h1>

            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#Modal_Add"><i class="fa fa-plus"></i> Додати постачальника</a>
                </div>

                <div class="card-body">

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
                                title: 'Помилка @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        </script>
                    @endif

                    <table id="provisioner" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                        <thead>
                        <tr>
                            <th>Код</th>
                            <th>Назва</th>
                            <th>Контракт</th>
                            <th>Реквізити</th>
                            <th>Загальна сума</th>
                            <th>Коментар</th>
                            <th>Дія</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($provisioner_all as $kay=>$provisioner)
                            <tr>
                                <td>{{$provisioner->code}}</td>
                                <td>{{$provisioner->name}}</td>
                                <td>{{$provisioner->contract}}</td>
                                <td>{{$provisioner->provisioner_property}}</td>
                                <td>---</td>
                                <td>{{$provisioner->description}}</td>
                                <td>
                                    <a href="#" class="btn btn-default btn-sm" data-bs-toggle="modal" data-bs-target="#Modal_{{$provisioner->id}}"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="btn btn-default btn-sm"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit provisioner -->
@foreach($provisioner_all as $kay=>$prov)
    <div class="modal fade" id="Modal_{{$prov->id}}" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Редагування [{{$prov->name}}]</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-danger_edit alert-dismissible" style="display:none">
                    </div>

                    <form action="{{route('provisioner_edit')}}" method="post" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="id" value="{{$prov->id}}">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            </div>
                            <input type="text" name="code" class="form-control" placeholder="Код" value="{{$prov->code}}" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-building"></i></span>
                            </div>
                            <input type="text" name="name" class="form-control" placeholder="Назва" value="{{$prov->name}}" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-address-card"></i></span>
                            </div>
                            <input type="text" name="contract" class="form-control" placeholder="Контракт" value="{{$prov->contract}}" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                            </div>
                            <input type="text" name="property" class="form-control" placeholder="Реквізити" value="{{$prov->provisioner_property}}" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" name="contacts" class="form-control" placeholder="Контакти" value="{{$prov->contacts}}" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-comment"></i></span>
                            </div>
                            <input type="text" name="description" class="form-control" placeholder="Коментар" value="{{$prov->description}}" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>
                            <button type="submit" class="btn btn-primary">Зберегти</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Modal add provisioner -->
    <div class="modal fade" id="Modal_Add" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Створення нового постачальника</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-danger_edit alert-dismissible" style="display:none">
                    </div>

                    <form action="{{route('provisioner_new')}}" method="post" class="needs-validation" novalidate>
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            </div>
                            <input type="text" name="code" class="form-control" placeholder="Код" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-building"></i></span>
                            </div>
                            <input type="text" name="name" class="form-control" placeholder="Назва" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-address-card"></i></span>
                            </div>
                            <input type="text" name="contract" class="form-control" placeholder="Контракт" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                            </div>
                            <input type="text" name="property" class="form-control" placeholder="Реквізити" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" name="contacts" class="form-control" placeholder="Контакти" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-comment"></i></span>
                            </div>
                            <input type="text" name="description" class="form-control" placeholder="Коментар" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>
                            <button type="submit" class="btn btn-primary">Створити</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@if(Session()->get('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{Session()->get('success')}}',
            showConfirmButton: false,
            timer: 2000
        })
    </script>
@endif

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
    $(function () {
        $("#provisioner").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "searching": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"],
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
        }).buttons().container().appendTo('#provisioner_wrapper .col-md-6:eq(0)');

        /*$('#example1 tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
            console.log((this).toggleClass('selected'))
        });*/

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

{{--validation--}}
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection
