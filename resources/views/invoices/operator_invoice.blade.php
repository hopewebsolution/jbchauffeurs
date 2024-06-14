<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        .invoice-container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-header,
        .invoice-footer {
            text-align: right;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 30px;
        }

        .invoice-header img {
            max-width: 150px;
            border-radius: 8px;
        }

        .invoice-header div {
            text-align: right;
        }

        .invoice-info {
            margin-top: 20px;
        }

        .invoice-info td {
            padding: 5px 0;
        }

        .invoice-info td:nth-child(2) {
            padding-right: 10px;
        }

        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-items th,
        .invoice-items td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .invoice-items th {
            background-color: #f8f8f8;
        }

        .invoice-items th:last-child,
        .invoice-items td:last-child {
            text-align: right;
        }

        .invoice-summary {
            margin-top: 20px;
            text-align: right;
        }

        .invoice-summary p {
            margin: 5px 0;
        }

        p {
            margin: 5px 0px;
        }

        .invoice-header table tr {
            text-align: left;
        }

        .invoice-header table tr td {
            font-size: 18px;
            line-height: 27px;
            font-weight: 500;
        }

        .invoice-header table tr th {
            font-size: 18px;
            line-height: 27px;
            font-weight: 500;
            color: #A09E9E;
        }

        table tr th {
            font-size: 18px;
            line-height: 27px;
            font-weight: 500;
            color: #403f3f;
        }

        .invoice-header table.text-right tr {
            text-align: right;
        }

        .invoice-footer {
            text-align: left;
            margin-top: 30px;
        }

        .text-black {
            color: #000 !important;
            font-weight: 600;
        }

        @media (max-width: 600px) {
            .invoice-container {
                padding: 15px;
            }
            
            .invoice-footer {
                text-align: center;
            }

            .invoice-summary {
                text-align: center;
            }

            .invoice-header {
                flex-direction: column;
            }

            .invoice-header div {
                text-align: left;
                margin-top: 10px;
            }
        }

        @media (max-width:460px) {
            .invoice-header table.text-right tr {
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <!-- <img src="https://via.placeholder.com/150" alt="Company Logo"> -->
            <div>
                <p><strong>Over the Hillz</strong></p>
                <p><strong>+19199000226</strong></p>
                <p><strong>10520 Chapel Hill Rd<br>Morrisville, NC 27560<br>United States</strong></p>
            </div>
        </div>

        <div class="invoice-header">
            <table>
                <tr>
                    <th><strong>Billed To</strong></th>
                <tr>
                    <td>Wrm<br>+17821012121<br>ok let every person know how you<br>Jaipur, Rajasthan 456777<br>United
                        States</td>
                </tr>
                </tr>
            </table>
            <table class="text-right">
                <tr>
                    <th><strong>Invoice Number</strong></th>
                <tr>
                    <td>111111</td>
                </tr>


                </tr>
            </table>
        </div>
        <div class="invoice-body">
            <table class="invoice-items">
                <thead>
                    <tr>
                        <th>Issue Dt.</th>
                        <th>Due Dt.</th>
                        <th>Currency</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>05/24/2024</td>
                        <td>05/31/2024</td>
                        <td>USD</td>

                    </tr>

                </tbody>
            </table>
        </div>
        <div class="invoice-body">
            <table class="invoice-items">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Rate</th>
                        <th>Quantity</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>      
                        <td></td>
                        <td>$0.00</td>
                    </tr>
                    <tr>
                        <th colspan="3">Sub Total</th>
                        <th>$0.00</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-black">TOTAL</th>
                        <th class="text-black">$0.00</th>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="invoice-footer">
            <p><strong>Terms & Notes</strong></p>
            <p>Invoice </p>
        </div>
    </div>
</body>

</html>