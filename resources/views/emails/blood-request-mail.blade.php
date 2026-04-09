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
            background-color: #f8f8f8;
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
            color: #f8f8f8 !important;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
            transition: background-color 0.2s ease-in-out;
        }

        .btn:hover {
            background-color: #a00000;
        }

        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f8f8f8;
            color: #0f0f0f;
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
            <h2>Hello, {{ $hospital->user->name ?? 'User' }}!</h2>
                <p>
                    A new <strong>Blood Request</strong> has been submitted by a partner hospital in our network.
                </p>

                <p>
                    They are seeking available blood units to help support a patient in urgent need of treatment.
                    Your hospital may be able to assist in fulfilling this request and providing the necessary support.
                </p>

                <p>
                    Please review the details of the request as soon as possible and respond accordingly.
                    Your quick action could play a critical role in saving a life and providing essential care.
                </p>

                <p>
                    Thank you for your continued collaboration and dedication to our shared mission of saving lives within our healthcare community. ❤️
                </p>

            <table>
                <thead>
                    <tr>
                        <th>Hospital Name</th>
                        <th>Blood Type</th>
                        <th>Quantity</th>
                        <th>Urgency Level</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $bloodRequest->hospital->name }}</td>
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