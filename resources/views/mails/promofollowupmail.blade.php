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
        /* Sub-table styling */
        .sub-table {
            margin-top: 10px;
            width: 100%;
            border-collapse: collapse;
        }
        .sub-table th, .sub-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .sub-table th {
            background-color: #e8e8e8;
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
          <th>Order Date</th>
          <th>Order Status</th>
          <th>Cancelling By</th>
          <th>RM Name</th>
          <th>Dealer Code</th>
          <th>Dealer Name</th>
          <th>Dealer Email</th>
          <th>Order Details</th>
        </tr>
      </thead>
      <tbody>
      
        @foreach($details as $offer)
        <tr>
          <td>{{ $offer->order_id }}</td>
          <td>{{ $offer->promo_code }}</td>
          <td>{{ $offer->order_date }}</td>
          <td>{{ $offer->status }}</td>
          <td>{{ \Carbon\Carbon::parse($offer->order_date)->addDays(3)->format('d-m-Y') }}</td>
          <td>{{ $offer->full_name }}</td>
          <td>{{ $offer->dealer_code }}</td>
          <td>{{ $offer->dealer_name }}</td>
          <td>{{ $offer->dealer_email }}</td>
          <td>
            @php
              $merged_data = json_decode($offer->merged_data, true);
            @endphp
            <table class="sub-table">
              <thead>
                <tr>
                  <th>Model No</th>
                  <th>Order Qty</th>
                  <th>Billed Qty</th>
                  <th>Product Type</th>
                </tr>
              </thead>
              <tbody>
                @foreach($merged_data as $item)
                <tr>
                  <td>{{ $item['model_no'] }}</td>
                  <td>{{ $item['order_qty'] }}</td>
                  <td>{{ $item['billed_qty'] ?? 'N/A' }}</td>
                  <td>{{ $item['product_type'] }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

</body>
</html>
