<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt(Office Copy)</title>
    <style>
        /* Set A5 page size */
        @page {
            size: 139mm 203mm;
            margin: 3mm;
            /* Reduced margin to prevent overflow */
        }

        /* General body styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 9px;
            /* Reduce font size to 9px for smaller content */
            line-height: 1.4;
        }

        /* Container should fit within the page */
        .container {
            width: 128mm !important;
            /* Adjusted to fit the A5 width */
            padding: 2mm;
            box-sizing: border-box;
        }

        /* Header layout */
        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 10px;
        }

        .header-table td {
            vertical-align: middle;
            padding: 0;
        }

        /* Logo size adjusted for A5 */
        .logo {
            width: 50px;
            /* Further reduced logo size */
            height: auto;
        }

        .header-text {
            text-align: center;
            font-size: 10px;
            /* Slightly smaller font for header */
        }

        .header-text h1,
        .header-text h2 {
            margin: 0;
        }

        .header-text p {
            margin: 3px 0;
            font-size: 9px;
            /* Smaller font for text */
        }

        /* Info table - make sure tables fit within page */
        .info-table,
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        /* Ensure tables are within the page width */
        .info-table td,
        .details-table td,
        .details-table th {
            padding: 3px;
            border: 1px solid #959595;
            word-wrap: break-word;
            text-align: left;
            font-size: 9px;
            /* Smaller font size for tables */
        }

        .info-table td {
            border: none;
        }

        .details-table th {
            font-size: 9px;
            /* Smaller font size for table headers */
        }

        /* Footer styling */
        .footer {
            margin-top: 5px;
            font-size: 9px;
        }

        .footer p {
            margin: 0;
            text-align: center;
            text-transform: capitalize;
        }

        /* Signature styling */
        .signature {
            margin-top: 25px;
            text-align: right;
        }

        .signature p {
            border-top: 1px dashed #bababa;
            width: 90px;
            display: inline-block;
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
                    <p>Email: info.shksc@gmail.com | Website: www.shksc.edu.bd</p>
                    <h2>PAYMENT RECEIPT (OFFICE COPY)</h2>
                </td>
            </tr>
        </table>

        <!-- Student Info -->
        <table class="info-table" style="margin-top: 10px;">
            <tr>
                <td><strong>Receipt SN:</strong> #{{ $invoiceNumber }}</td>
                <td><strong>Student ID:</strong> {{ $student->student_id }}</td>
            </tr>
            <tr>
                <td><strong>Receipt Created:</strong> {{ date('d M, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Name:</strong> {{ $student->name }}</td>
                <td><strong>Roll:</strong> {{ $student->roll }}</td>
            </tr>
            <tr>
                <td><strong>Medium:</strong> {{ $student->medium }}</td>
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
                        <td>
                            @if ($detail['waiverAmount'] > 0)
                                {{ $detail['waiverAmount'] }} Taka
                            @else
                                N/A
                            @endif
                        </td>
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
            <p><strong>In Words:</strong> {{ $amount_in_words }} Taka only</p>
        </div>

        <!-- Signature -->
        <div class="signature">
            <p style="border-top: 1px dashed #bababa;">Accounts Officer</p>
        </div>

    </div>
</body>

</html>
