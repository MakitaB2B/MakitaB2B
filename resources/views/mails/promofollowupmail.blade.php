<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f9f9f9;
            padding: 20px;
        }
        p {
            font-size: 16px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
            color: #555;
        }
        td {
            background-color: #fafafa;
        }
        .table-heading {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #444;
        }
    </style>
</head>
<body>
      @if(!app()->environment('production'))
      <p><b>Note - This is a test mail</b></p>
      @endif

    <p>List of Dealers to be followed up for today - {{date('d-m-Y')}}.</p>
   
    <h3 class="table-heading">Follow Up List.</h3>
    <table>
      <thead>
        <tr>
          <th>Transaction ID</th>
          <th>Promo Code</th>
          <th>Date</th>
          <th>Cancelling In Day(s)</th>
          <th>RM Name</th>
          <th>Dealer Code</th>
          <th>Dealer Name</th>
          <th>Dealer Email</th>
        </tr>
      </thead>
      <tbody>
        {{-- @foreach($details['focproduct'] as $offer)
        <tr>
          <td>{{ $offer->model_no }}</td>
          <td>{{ $offer->mrp }}</td>
          <td>{{ $offer->dlp }}</td>
          <td>{{ $offer->best }}</td>
        </tr>
        @endforeach --}}
      </tbody>
    </table>

</body>
</html>