@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       <h1>Dashboard</h1>
       <div id="order-status" style="width: 900px; height: 500px;"></div>
       <div id="test" style="width: 900px; height: 500px;"></div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection

@section('my-script')
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(@json($data));

        var options = {
          title: 'Order Status Summary',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('order-status'));

        chart.draw(data, options);
      }
    </script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(@json($dataCategory));

        var options = {
          title: 'Product Category Summary',
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('test'));

        chart.draw(data, options);
      }
    </script>
@endsection