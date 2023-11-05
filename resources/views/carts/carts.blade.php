<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
    <link href="{{ asset('/css/cart.css') }}" rel="stylesheet">
</head>
<body>
<div id="w">
    <header id="title">
        <h1>Ваша корзина</h1>
    </header>
    <div id="page">
        <table id="cart">
            <thead>
            <tr>
                <th class="first">Фото</th>
                <th class="second">Кол-во</th>
                <th class="third">Product</th>
                <th class="fourth">Цена</th>
                <th class="fifth">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <!-- shopping cart contents -->
            <tr class="productitm">
                <!-- http://www.inkydeals.com/deal/ginormous-bundle/ -->
                <td><img src="https://i.imgur.com/8goC6r6.png" class="thumb"></td>
                <td><input type="number" value="1" min="0" max="99" class="qtyinput"></td>
                <td>Design Bundle Package</td>
                <td>$79.00</td>
                <td><span class="remove"><img src="https://i.imgur.com/h1ldGRr.png" alt="X"></span></td>
            </tr>

            <!-- tax + subtotal -->
            <tr class="totalprice">
                <td class="light">Общая сумма:</td>
                <td colspan="2">&nbsp;</td>
                <td colspan="2"><span class="thick">$225.45</span></td>
            </tr>

            <!-- checkout btn -->
            <tr class="checkoutrow">
                <td colspan="5" class="checkout"><button id="submitbtn">Офорить заказ!</button></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
