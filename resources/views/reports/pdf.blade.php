<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reports</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Reports</h2>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Start Cash</th>
                <th>End Cash</th>
                <th>Currency</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td>{{ $report->date }}</td>
                <td>{{ $report->start_cash }}</td>
                <td>{{ $report->end_cash }}</td>
                <td>{{ $report->currency->code }}</td>
                <td>{{ $report->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>