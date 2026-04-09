<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Blood Request Fulfilled' }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #0f0f0f;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(128, 0, 0, 0.2);
        }

        .header {
            background: linear-gradient(90deg, #800000, #b30000);
            color: #fff;
            text-align: center;
            padding: 20px 10px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .content {
            padding: 30px;
            line-height: 1.6;
        }

        .content h2 {
            color: #800000;
        }

        .content p {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th {
            background-color: #800000;
            color: #fff;
            padding: 12px;
        }

        td {
            border: 1px solid #d9a3a3;
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #fbeaea;
        }

        .footer {
            text-align: center;
            padding: 15px;
            font-size: 0.9rem;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="email-container">

        <div class="header">
            BloodConnect Notification
        </div>

        <div class="content">
            <h2>Hello, {{ $bloodRequest->confirmedBy->name }}!</h2>

            <p>
                You have successfully fulfilled a <strong>Blood Request</strong> for
                <strong>{{ $bloodRequest->hospital->name }}</strong>.
            </p>

            <p>
                Thank you for helping save lives through BloodConnect ❤️
            </p>

            <table>
                <thead>
                    <tr>
                        <th>Requesting Hospital</th>
                        <th>Blood Type</th>
                        <th>Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>{{ $bloodRequest->hospital->name }}</td>
                        <td>{{ $bloodRequest->blood_type }}</td>
                        <td>{{ $bloodRequest->quantity }}</td>
                        <td>{{ $bloodRequest->status }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} BloodConnect. All rights reserved.
        </div>

    </div>
</body>

</html>