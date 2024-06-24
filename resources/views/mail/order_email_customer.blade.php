<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>STT</th>
            <th>Name</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
        @php $totalPrice = 0 @endphp 
        @foreach ($order->orderItems as $item)            
            @php $totalPrice += $item->qty * $item->price @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ number_format($item->qty * $item->price, 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Total : </td>
            <td colspan="3">{{ $totalPrice }}</td>
        </tr>
    </table>
</body>
</html>