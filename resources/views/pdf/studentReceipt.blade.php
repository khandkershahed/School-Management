<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt(Student Copy)</title>
    <style>
        /* Set A5 paper size (portrait) and ensure content fits well */
        @page {
            size: 148mm 210mm;  /* A5 size in portrait */
            margin: 5mm;         /* Adjust margin for A5 layout */
        }

        /* General body styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10px; /* Set font size to 10px */
            line-height: 1.4;
        }

        .container {
            padding: 10px;
            border: 1px solid #000;
            width: 100%;
            font-size: 10px; /* Apply 10px font size throughout */
            margin: 0;
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
            width: 80px; /* Reduced logo size for A5 */
            height: auto;
        }

        .header-text {
            text-align: center;
            font-size: 12px;
        }

        .header-text h1,
        .header-text h2 {
            margin: 0;
        }

        .header-text p {
            margin: 5px 0;
            font-size: 10px; /* Smaller font for header text */
        }

        /* Info table */
        .info-table,
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td,
        .details-table td,
        .details-table th {
            padding: 3px;
            border: 1px solid #959595;
        }

        .info-table td {
            border: none;
        }

        .details-table th {
            text-align: left;
            font-size: 10px; /* Ensure consistent font size for table headers */
        }

        /* Footer */
        .footer {
            margin-top: 10px;
            font-size: 10px;
        }

        .footer p {
            margin: 0;
            text-align: center;
            text-transform: capitalize;
        }

        /* Signature styles */
        .signature {
            margin-top: 30px;
            text-align: right;
        }

        .signature p {
            border-top: 1px dashed #bababa;
            width: 100px;
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
                    <h2>PAYMENT RECEIPT (STUDENT COPY)</h2>
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
            <p><strong>In Words:</strong> {{ $amount_in_words }} Taka only</p>
        </div>

        <!-- Signature -->
        <div class="signature">
            <p style="border-top: 1px dashed #bababa;">Accounts Officer</p>
        </div>

    </div>
</body>

</html>
