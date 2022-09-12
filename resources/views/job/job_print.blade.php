 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Акт про приймання виконаних робіт № {{$id}}</title>
    <style>
        table.info {
            margin-top: 40px;
        }
        table.info td {
            padding: 5px;
        }

        table.work-data {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
            font-size: 13px;
        }
        table.work-data tbody > tr > th {
            font-weight: bold;
            font-size: 16px;
        }
        table.work-data th {
            font-weight: normal;
        }
        table.work-data td {
            text-align: center;
        }
        table.work-data th,
        table.work-data td {
            border: 1px solid #000;
        }
        table.work-data td.work-name {
            text-align: left;
        }
        table.work-data td.total-price-name {
            border: none;
            text-align: right;
            padding-right: 5px;
            font-weight: bold;
            font-size: 16px;
        }

        .total-price-value {
            font-weight: bold;
            font-size: 13px;
        }

        .total-price-by-string {
            margin-top: 40px;
        }

        table.confirm {
            margin-top: 40px;
            width: 100%;
        }
        table.confirm td.name {
            width: 10%;
        }
        table.confirm td.signature {
            border-bottom: 1px solid #000;
            width: 30%;
        }
        ul.rules {
            margin-top: 40px;
            list-style: none;
            padding: 0;
            font-size: 11px;
        }
        ul.rules li {
            text-align: justify;
        }
    </style>
</head>
<body>
<div class="header">
    <div style="text-align: center">
        <h3>Акт про приймання виконаних робіт № {{$id}}</h3>
    </div>
    <div style="text-align: center">
        від {{$job->created_at->format('d-M-Y')}}
    </div>
</div>

<table width="100%" class="info">
    <tr>
        <td width="20%">
            Виконавець
        </td>
        <td width="80%" colspan="3">
            Moto-Moto.kiev.ua
        </td>
    </tr>
    <tr>
        <td width="20%">
            Замовник
        </td>
        <td width="30%">
            {{$job->getClientFullName()}}
        </td>
        <td width="10%">
            тел.
        </td>
        <td width="40%">
            {{$job->getClientPhoneNumber()}}
        </td>
    </tr>
    <tr>
        <td width="20%">
            Назва техніки
        </td>
        <td width="30%">
            {{$job->getBrandName()}}
        </td>
        <td width="10%">
            Модель
        </td>
        <td width="40%">
            {{$job->getModelName()}}
        </td>
    </tr>
    <tr>
        <td width="20%">
            Номер шасі
        </td>
        <td width="80%" colspan="3">
            {{$job->getVehicleFrameNumber()}}
        </td>
    </tr>
</table>

<table class="work-data">
    <tr>
        <th>
            №
        </th>
        <th width="45px">
            Код
        </th>
        <th>
            Найменування роботи (послуги)
        </th>
        <th>
            Од. вим.
        </th>
        <th>
            Кількість
        </th>
        <th>
            Нормагодин
        </th>
        <th>
            Сума (грн.)
        </th>
    </tr>

    @foreach ($task_job as $task)
    <tr>
        <td>
            {{++$number}}
        </td>
        <td>
            {{$task->code}}
        </td>
        <td class="work-name">
            {{$task->getTaskCatalogue->name}}
        </td>
        <td>
            посл.
        </td>
        <td>
            1
        </td>
        <td>
            {{$task->hourly_rate}} год.
        </td>
        <td>
            {{number_format($task->price,2,'.', ' ')}}
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="6" class="total-price-name">
            Всього послуги:
        </td>
        <td class="total-price-value">
            {{number_format($job->getTaskTotalPrice(),2,'.', ' ')}}
        </td>
    </tr>
</table>
<br>

<table class="work-data">
    <tr>
        <th>
            №
        </th>
        <th width="45px">
            Код
        </th>
        <th>
            Найменування товари (запчастини)
        </th>
        <th>
            Од. вим.
        </th>
        <th>
            Кількість
        </th>
        <th>
            Ціна (грн)
        </th>
        <th>
            Сума (грн.)
        </th>
    </tr>

    <input type="hidden" value="{{$number=0}}" >
    @foreach ($parts_job as $part)
    <tr>
        <td>
            {{++$number}}
        </td>
        <td>
            {{$part->code}}
        </td>
        <td class="work-name">
            {{$part->getPartsStorages->name}}
        </td>
        <td>
            1
        </td>
        <td>
            {{$part->quantity}}
        </td>
        <td>
            {{number_format($part->price, 2, '.', ' ')}}
        </td>
        <td>
            {{number_format($part->price * $part->quantity, 2, '.', ' ')}}
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="6" class="total-price-name">
            Всього запчастини:
        </td>
        <td class="total-price-value">
            {{number_format($job->getPartsTotalPrice(),2,'.', ' ')}}
        </td>
    </tr>
    <tr>
        <td colspan="6" class="total-price-name">
            Зашальна сума:
        </td>
        <td class="total-price-value">
            {{number_format($job->getTotalPrice(),2,'.', ' ')}}
        </td>
    </tr>
</table>

<div class="total-price-by-string">
    Всього надано послуг, товарів на суму: (сума прописом)
</div>
<div style="margin-top: 15px">
    Перераховані вище роботи (послуги) виконані повністю і в строк. Замовник за обсягом, якостю і термінам надання послуг претензій не має.
</div>

<table class="confirm">
    <tr>
        <td class="name">
            Виконавець
        </td>
        <td width="40%">
            {{$job->Creator->name}}
        </td>
        <td class="name">
            Замовник
        </td>
        <td class="signature">

        </td>
        <td width="10%">

        </td>
    </tr>
</table>

<ul class="rules">
    <li>
        - Притензії щодо виконаних робіт приймаються протягом 7 календарних днів з моменту видачі техніки!
    </li>
    <li>
        - СТО залишае за собою право не розглядати притензії після закінчення 7-денного терміну;
    </li>
    <li>
        - Після отримання інформації про готовність техніки через 2 доби нараховується плата за стоянку в розмірі:
    </li>
    <li>
        Мотоцикл - 50 грн./доба**, моторолер, скутер – 25грн./доба**, квароцикл – 100грн./доба**
        ** - у разі, якщо техніка не забрана протягом 1 (одного) місяця, СТО залишає за собою право вилучення техніки та/або її комплектації для погашення боргу за стоянку;
    </li>
    <li>
        - Обов’язковим є дотримання правил експлуатації ремонтної техніки, для уникнення непорозумінь,
        зверніться будь ласка, до механіка для проведення роз’яснювальної роботи щодо експлуатації Вашої техніки!
    </li>
    <li>
        Дякуємо за вибір нашої майстерні.
    </li>
</ul>

</body>
</html>
<script type="text/javascript">window.print();</script>
