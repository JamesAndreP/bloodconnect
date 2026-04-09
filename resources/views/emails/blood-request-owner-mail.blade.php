<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Notification' }}</title>

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
            box-shadow: 0 0 20px rgba(128, 0, 0, 0.25);
        }

        .header {
            background: linear-gradient(90deg, #800000, #b30000);
            color: #fff;
            text-align: center;
            padding: 20px 10px;
            font-size: 1.5rem;
            letter-spacing: 1px;
            font-weight: bold;
        }

        .content {
            padding: 30px;
            line-height: 1.6;
        }

        .content h2 {
            color: #800000;
            margin-bottom: 10px;
        }

        .content p {
            color: #0f0f0f;
            margin: 10px 0;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(90deg, #800000, #b30000);
            color: #ffffff !important;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #a00000;
        }

        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f8f8f8;
            color: #555;
            font-size: 0.9rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            text-align: center;
        }

        th {
            background-color: #800000;
            color: #fff;
            padding: 12px;
            font-weight: bold;
        }

        td {
            border: 1px solid #d9a3a3;
            padding: 10px;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #fbeaea;
        }

        tr:nth-child(odd) {
            background-color: #fff;
        }
    </style>
</head>

<body>
    <div class="email-container">

        <div class="header">
            {{ $header ?? 'BloodConnect Notification' }}
        </div>

        <div class="content">

            <h2>Hello, {{ $bloodRequest->hospital->user->name ?? 'User' }}!</h2>

            <p>
                Great news! Your <strong>Blood Request</strong> has been successfully submitted to our hospital network.
            </p>

            <p>
                Our system has forwarded your request to all available hospitals that may be able to supply the needed blood units.
                You will be notified as soon as any hospital responds or commits to fulfilling your request.
            </p>

            <p>
                Thank you for acting promptly to support patients in critical need.
                Your commitment to providing immediate care plays a vital role in saving lives and strengthening our healthcare community.
            </p>

            <p>
                We appreciate your continued collaboration and trust in our system. ❤️
            </p>

            <table>
                <thead>
                    <tr>
                        <th>Blood Type</th>
                        <th>Quantity</th>
                        <th>Urgency Level</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>{{ $bloodRequest->blood_type }}</td>
                        <td>{{ $bloodRequest->quantity ?? now()->format('Y-m-d') }}</td>
                        <td>{{ $bloodRequest->urgency_lvl ?? 'Pending' }}</td>
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