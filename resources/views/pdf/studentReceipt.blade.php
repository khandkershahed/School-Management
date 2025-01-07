<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt(Student Copy)</title>
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
            margin: auto;
            font-size: 12px;
        }

        /* Use a table for header layout */
        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 10px;
        }

        /* Center logo and text vertically using table cells */
        .header-table td {
            vertical-align: middle;
            padding: 0;
        }

        .logo {
            width: 120px;
            height: auto;
        }

        .header-text {
            text-align: center;
            font-size: 14px;
        }

        .header-text h1,
        .header-text h2 {
            margin: 0;
        }

        .header-text p {
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
            border: 1px solid #959595;
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
        <table class="header-table">
            <tr>
                <td>
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo_color_no_bg.png'))) }}"
                        alt="Logo" class="logo">
                </td>
                <td class="header-text">
                    <h1>Shamsul Hoque Khan School and College</h1>
                    <p>Paradogair, Matuail, Demra Dhaka -1362</p>
                    <p>Email: info.shksc@gmail.com | Website: www.shksc.edu.bd/</p>
                    <h2>PAYMENT RECEIPT (STUDENT COPY)</h2>
                </td>
            </tr>
        </table>

        <!-- Receipt Info -->
        <table class="info-table">
            <tr>
                <td><strong>Receipt SN:</strong> #{{ $invoiceNumber }}</td>
                <td><strong>Payment Received:</strong> {{ date('d M, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Receipt Created:</strong> {{ date('d M, Y') }}</td>
            </tr>
        </table>

        <!-- Student Info -->
        <table class="info-table" style="margin-top: 10px;">
            <tr>
                <td><strong>Name:</strong> {{ $student->name }}</td>
                <td><strong>Roll:</strong> {{ $student->roll }}</td>
            </tr>
            <tr>
                <td><strong>Section:</strong> {{ $student->medium }}</td>
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
                    <th>Waived Amount</th>
                    <th>Final Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feeDetails as $key => $detail)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $detail['fee'] }}</td>
                        <td>{{ $detail['amount'] }} Taka</td>
                        <td> @if (($detail['waiverAmount']) >0) {{ $detail['waiverAmount'] }} Taka @else N/A @endif</td>
                        <td>{{ $detail['finalAmount'] }} Taka</td>
                    </tr>
                @endforeach
                <tr style="background-color: #d5d5d5">
                    <td colspan="4" style="text-align: center;"><strong>Total Amount:</strong> </td>
                    <td>{{ $totalAmount }} Taka</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p style="margin-top: 10px; margin-bottom: 10px; text-align: center; text-transform: capitalize;"><strong>In
                    Words:</strong> {{ $amount_in_words }} Taka only</p>
        </div>

        <!-- Signature -->
        <div class="signature" style="text-align: right; margin-top: 30px;">
            <p style="border-top: 1px dashed #bababa; width: 120px; display: inline-block;">Accounts Officer</p>
        </div>

    </div>
</body>

</html>
