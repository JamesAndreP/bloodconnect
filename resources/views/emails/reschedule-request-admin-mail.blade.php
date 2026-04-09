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
            box-shadow: 0 0 20px rgba(255, 105, 180, 0.3);
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
            background: linear-gradient(90deg, #ff1493, #ff66b2);
            color: #f8f8f8 !important;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
            transition: background-color 0.2s ease-in-out;
        }
        .btn:hover {
            background-color: #ff85c1;
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
            <h2>Hello, {{ $donationRequest->donations[0]->hospital->user->name ?? 'User' }}!</h2>
            <p>
                A donor has submitted a new <strong>Blood Donation Reschedule Request</strong> through <strong>BloodConnect</strong>.
            </p>
            <p>
                The donor has requested to change their previously scheduled donation appointment. Please review the new proposed schedule and take appropriate action — either approve or suggest an alternative date.
            </p>
            <p>
                Timely coordination helps ensure a smooth donation process and allows us to better serve patients in need.
            </p>
            <p>
                You can view the full details of this reschedule request in your dashboard.
            </p>

            {{-- Example 3-column table --}}
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{$donationRequest->name ?? 'John Doe'}}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>{{explode('|', $donationRequest->location)[0] ?? 'Mandaue'}}</td>
                    </tr>
                    <tr>
                        <td>Previous Date</td>
                        <td>{{$donationRequest->donations[0]->latestActiveSchedule?->date ?? now()->format('Y-m-d')}}</td>
                    </tr>
                    <tr>
                        <td>Requested Date</td>
                        <td>{{$donationRequest->donations[0]->latestRescheduleRequest?->date ?? now()->format('Y-m-d')}}</td>
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
