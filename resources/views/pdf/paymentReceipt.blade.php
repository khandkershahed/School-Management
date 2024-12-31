<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 10px;
            border: 1px solid #000;
            width: 100%;
            /* Take full width of the reduced page */
            margin: auto;
            font-size: 12px;
            /* Smaller font size for the smaller page */
        }

        /* .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 14px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 12px;
        } */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .header .logo {
            width: 50px;
            /* Adjust the size of the logo */
            height: auto;
        }

        .header .header-text {
            text-align: center;
            flex-grow: 1;
        }

        .header .header-text h1,
        .header .header-text h2 {
            margin: 0;
        }

        .header .header-text p {
            margin: 5px 0;
            font-size: 12px;
        }

        .info-table,
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td,
        .details-table td,
        .details-table th {
            padding: 4px;
            border: 1px solid #000;
        }

        .info-table td {
            border: none;
        }

        .details-table th {
            text-align: left;
        }

        .footer {
            margin-top: 10px;
        }

        .footer p {
            margin: 0;
        }

        .signature {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('images/logo_color_no_bg.png') }}" alt="Logo" class="logo"> <!-- Add your logo image here -->
            <div class="header-text">
                <h1>Shamsul Hoque Khan School and College</h1>
                <p>Paradogair, Matuail, Demra Dhaka -1362</p>
                <p>Email: info.shksc@gmail.com| Website: www.shksc.edu.bd/</p>
                <h2>PAYMENT RECEIPT</h2>
            </div>
        </div>

        <!-- Receipt Info -->
        <table class="info-table">
            <tr>
                <td><strong>Receipt SN:</strong> #</td>
                <td><strong>Payment Received:</strong> {{ date('d M, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Receipt Created:</strong> {{ date('d M, Y') }}</td>
                {{-- <td><strong>Current Due:</strong> {{ $due }} Taka</td> --}}
            </tr>
        </table>

        <!-- Student Info -->
        <table class="info-table" style="margin-top: 10px;">
            <tr>
                <td><strong>Name:</strong> {{ $student->name }}</td>
                <td><strong>Roll:</strong> {{ $student->roll }}</td>
            </tr>
            <tr>
                <td><strong>Section:</strong> {{ $student->medium->name }}</td>
                <td><strong>Class:</strong> {{ $student->class }}</td>
            </tr>
            <tr>
                <td><strong>Guardian Name:</strong> {{ $student->guardian_name }}</td>
                <td><strong>Guardian Contact Number:</strong> {{ $student->guardian_contact }}</td>
            </tr>
        </table>

        <!-- Payment Details -->
        <table class="details-table">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Fee Name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fees as $key => $fee)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $fee->name }}</td>
                        <td>{{ $fee->amount }} Taka</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p style="margin-top: 10px; margin-bottom: 10px; text-align: center; text-transform: capitalize;"><strong>In
                    Words:</strong> {{ $amount_in_words }} Taka only</p>
            <h6 style="text-align: right;"><strong>Total Amount:</strong> {{ $totalAmount }} Taka</h6>
        </div>

        <!-- Signature -->
        <div class="signature">
            <p>Received By</p>
            <p>Md. Akram Miah</p>
            {{-- <p>Received By</p> --}}
        </div>
    </div>
</body>

</html>