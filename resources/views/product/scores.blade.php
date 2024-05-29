<h1>Scores Blade Template</h1>

@php 
$scores = [3, 5, 6, 7, 1, 2, 9, 10]; 
// $scores = [];
@endphp

<table border="1">
    <tr>
        <th>STT</th>
        <th>Score</th>
        <th>Note</th>
    </tr>

    @forelse ($scores as $score)
        <tr style="background-color: {{ $loop->odd ? 'grey' : '' }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $score }}</td>
            <td>{{ $score > 5 ? 'Dat' : 'Khong dat' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3">No Data</td>
        </tr>
    @endforelse
</table>