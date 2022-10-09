@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <nav class="breadcrumbs">
                    <ol class="breadcrumb" style="--bs-breadcrumb-margin-bottom: 0;">
                        <li class="breadcrumb-item navbar-right"><a href="/">Головна</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            <h1>Dashboard</h1>
            <div class="card">
                <div class="card-header">

                </div>

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="sticky-top mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Події</h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- the events -->
                                            <div id="external-events">

                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                    <div class="card">
                                        <div class="card-header bg-warning">
                                            <div class="clock">
                                                <div id="Date"></div>
                                            </div>
                                        </div>
                                        <div class="card-body bg-gradient-warning">
                                                <div class="clock">
                                                        {{--<li class="clock" id="hours"> </li>--}}
                                                        <div class="clock" id="hours"> </div>
                                                        <div class="clock" id="point">:</div>
                                                        {{--<li class="clock" id="point">:</li>--}}
                                                        <div class="clock" id="min"> </div>
                                                        {{--<li class="clock" id="min"> </li>--}}
                                                        <div class="clock" id="point">:</div>
                                                        {{--<li class="clock" id="point">:</li>--}}
                                                        <div class="clock" id="sec"></div>
                                                        {{--<li class="clock" id="sec"> </li>--}}

                                                </div>

                                            <div class="input-group">

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="card card-primary">
                                    <div class="card-body p-0">
                                        <!-- THE CALENDAR -->
                                        <div id="calendar"></div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('js/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/moment/moment.min.js')}}"></script>
<script src="{{asset('js/fullcalendar/main.js')}}"></script>
<link rel="stylesheet" href="{{asset('js/fullcalendar/main.css')}}">


<script>
    $(function () {

        var Calendar = FullCalendar.Calendar;
        var calendarEl = document.getElementById('calendar');

        var SITEURL = "{{ url('/') }}";

        /*CSRF Token Setup*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });


        var calendar = new Calendar(calendarEl, {
            locale: 'uk',
            headerToolbar: {
                left  : 'prev,next today',
                center: 'title',
                right : 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'bootstrap',

            //Random default events
            events : SITEURL + "/fullcalender",
            editable  : true,
            droppable : true, // this allows things to be dropped onto the calendar !!!


            eventDrop: function (event, delta) {
                console.log(event)
                $.ajax({
                    url: SITEURL + '/fullcalenderAjax',
                    type: "POST",
                    data: {
                        type: 'update',
                        id: event.event.id,
                        title: event.event.title,
                        start: moment(event.event.start).format('Y-MM-DD HH:mm:ss'),
                        end: moment(event.event.end).format('Y-MM-DD HH:mm:ss'),
                        //url: event.event.url,
                        backgroundColor : event.event.backgroundColor,
                        borderColor : event.event.borderColor,

                    },

                    success: function (response) {
                        //console.log("Event Updated Successfully")
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Подію '+event.event.title+' оновлено!'
                        })
                    },

                });
            },

            select: function(event, end, jsEvent, view ) {
                //console.log(start.start)

                //moment(event.event.start).format('Y-MM-DD HH:mm:ss')
                // set values in inputs
                $('#event-modal').find('input[name=start]').val(
                    //start.start.format('YYYY-MM-DD HH:mm:ss')
                    moment(event.start).format('Y-MM-DD HH:mm:ss')
                );
                $('#event-modal').find('input[name=end]').val(
                    //end.format('YYYY-MM-DD HH:mm:ss')
                    moment(event.end).format('Y-MM-DD HH:mm:ss')
                );

                // show modal dialog
                $('#event-modal').modal('show');

            },

            eventClick: function (event) {
                Swal.fire({
                    title: 'Ви впевнені?',
                    text: "Видалити подію "+event.event.title+"?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Ні',
                    confirmButtonText: 'Так, видалити!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: SITEURL + '/fullcalenderAjax',
                            data: {
                                id: event.event.id,
                                type: 'delete'
                            },
                            success: function (response) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                })

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Подію '+event.event.title+' видалено!'
                                }).then(function () {
                                    location.reload();
                                });
                            }
                        });
                    }
                })
            },

            selectable: true,
            selectHelper: true,

            drop      : function(info) {

                // is the "remove after drop" checkbox checked?
                if (checkbox.checked) {
                    // if so, remove the element from the "Draggable Events" list
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                }
            },



        });


        calendar.render();
        // $('#calendar').fullCalendar()

        var btnColor = '#3c8dbc' //Red by default
        // Color chooser button
        $('.event-tag > label').click(function (e) {

            //e.preventDefault()
            // Save color
            btnColor = $(this).css('background-color')
            //console.log(btnColor)
            $('.event-tag > label.active').removeClass('active');
            $(this).addClass('active');
            $('#add-new-event-m').css({
                'background-color': btnColor,
                'border-color'    : btnColor
            })
        })

    })
</script>

@if (Session::has('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
        })

        Toast.fire({
            icon: 'success',
            title: '{{ Session::get("success") }}'
        })
    </script>
@endif


<div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Нова подія</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/fullcalenderAjax" name="save-event" method="post">
                <div class="modal-body">

                    @csrf
                    <input type="hidden" name="type" value="add">
                    <div class="form-group">
                        <label>Назва</label>
                        <input type="text" name="title" id="event_title" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Початок</label>
                        <input type="text" name="start" class="form-control col-xs-3"/>
                    </div>
                    <div class="form-group">
                        <label>Закінчення</label>
                        <input type="text" name="end" class="form-control col-xs-3"/>
                    </div>
                    <div class="btn-group btn-group-toggle btn-group-colors event-tag" data-bs-toggle="buttons">
                        <label class="btn bg-info active"><input type="radio" name="event_tag" value="#117a8b"
                                                                 autocomplete="off" checked=""></label>
                        <label class="btn bg-warning"><input type="radio" name="event_tag" value="#ffc107"
                                                             autocomplete="off"></label>
                        <label class="btn bg-danger"><input type="radio" name="event_tag" value="#dc3545"
                                                            autocomplete="off"></label>
                        <label class="btn bg-success"><input type="radio" name="event_tag" value="#28a745"
                                                             autocomplete="off"></label>
                        <label class="btn bg-primary"><input type="radio" name="event_tag" value="#007bff"
                                                             autocomplete="off"></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відміна</button>
                    <button type="submit" id="add-new-event-m" class="btn btn-primary">Зберегти</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Создаем две переменные с названиями месяцев и названиями дней.
        var monthNames = [ "Січня", "Лютого", "Березня", "Квітня", "Травня", "Червня", "Липня", "Серпня", "Вересеня", "Жовтня", "Листопада", "Грудня" ];
        var dayNames= ["Неділя","Понеділок","Вівторок","Середа","Четвер","П'ятниця","Субота"]

        // Создаем объект newDate()
        var newDate = new Date();
        // "Достаем" текущую дату из объекта Date
        newDate.setDate(newDate.getDate());
        // Получаем день недели, день, месяц и год
        $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

        setInterval( function() {
            // Создаем объект newDate() и показывает секунды
            var seconds = new Date().getSeconds();
            // Добавляем ноль в начало цифры, которые до 10
            $("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
        },1000);

        setInterval( function() {
            // Создаем объект newDate() и показывает минуты
            var minutes = new Date().getMinutes();
            // Добавляем ноль в начало цифры, которые до 10
            $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
        },1000);

        setInterval( function() {
            // Создаем объект newDate() и показывает часы
            var hours = new Date().getHours();
            // Добавляем ноль в начало цифры, которые до 10
            $("#hours").html(( hours < 10 ? "0" : "" ) + hours);
        }, 1000);
    });
</script>


<style>

    .clock {
        text-align:center;
        font-size:26px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        align-content: center;

    }

    #Date {
        font-size:20px;
        text-align:center;
        color: #0b1526;
        /*text-shadow:0 0 5px #00c6ff;*/
        border: none;
    }

    #point {
        position:relative;
        display: inline-block;
        -moz-animation:mymove 1s ease infinite;
        -webkit-animation:mymove 1s ease infinite;
        padding-left:10px;
        padding-right:10px;
    }

    @-webkit-keyframes mymove
    {
        0% {
            opacity:1.0;
            text-shadow:0 0 20px #00c6ff;
        }

        50% {
            opacity:0;
            text-shadow:none;
        }

        100% {
            opacity:1.0;
            text-shadow:0 0 20px #00c6ff;
        }
    }


    @-moz-keyframes mymove
    {
        0% {
            opacity:1.0;
            text-shadow:0 0 20px #00c6ff;
        }

        50% {
            opacity:0;
            text-shadow:none;
        }

        100% {
            opacity:1.0;
            text-shadow:0 0 20px #00c6ff;
        }
    }
</style>

{{--<link rel="stylesheet" href="/css/docs-db.css">--}}
<style>
    .breadcrumbs {
        padding: 55px 0px;
        margin-bottom: -30px;
        list-style: none;
        border-radius: 4px;
    }

    [data-bs-toggle=buttons]:not(.btn-group-colors) > .btn {
        background-color: #f6f9fc;
        cursor: pointer;
        box-shadow: none;
        border: 0;
        margin: 0
    }

    [data-bs-toggle=buttons]:not(.btn-group-colors) > .btn:not(.active) {
        color: #525f7f
    }

    [data-bs-toggle=buttons]:not(.btn-group-colors) > .btn.active {
        background-color: #0a48b3;
        color: #fff
    }

    .btn-group-colors > .btn {
        box-shadow: none;
        border-radius: 50% !important;
        width: 30px;
        height: 30px;
        padding: 0;
        margin-right: .5rem;
        margin-bottom: .25rem;
        position: relative
    }

    .btn-group-colors > .btn:not([class*=bg-]) {
        border-color: #f6f9fc !important
    }

    .btn-group-colors > .btn:before {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        line-height: 28px;
        color: #fff;
        transform: scale(0);
        opacity: 0;
        content: "\2713";
        font-family: NucleoIcons, sans-serif;
        font-size: 14px;
        transition: transform 200ms, opacity 200ms
    }

    @media (prefers-reduced-motion: reduce) {
        .btn-group-colors > .btn:before {
            transition: none
        }
    }

    .btn-group-colors > .btn.btn:not([class*=bg-]) {
        border: 1px solid #cfd5db
    }

    .btn-group-colors > .btn.btn:not([class*=bg-]):before {
        color: #525f7f
    }

    .btn-group-colors > .btn.active:before {
        transform: scale(1);
        opacity: 1
    }
</style>

@endsection
