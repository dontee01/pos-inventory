<!DOCTYPE html>
<html>
<head>
    <title>{{ env('SITE_NAME') }}::.Receipt</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        /* Thermal Printer Optimized CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1;
            color: #000;
            background: #fff;
            width: 80mm; /* Standard thermal printer width */
            max-width: 80mm;
            margin: 0 auto;
            padding: 5mm;
        }

        @media print {
            body {
                width: 80mm !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            .no-print {
                display: none !important;
            }
            
            .page-break {
                page-break-before: always;
            }
        }

        /* Receipt Container */
        .receipt {
            width: 100%;
        }

        /* Header Styles */
        .header {
            text-align: center;
            padding-bottom: 5px;
            border-bottom: 1px dashed #000;
            margin-bottom: 5px;
        }

        .company-name {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .company-address {
            font-size: 10px;
            margin-bottom: 2px;
        }

        .company-contact {
            font-size: 10px;
            margin-bottom: 2px;
        }

        /* Receipt Info */
        .receipt-info {
            text-align: center;
            margin: 5px 0;
            padding: 3px 0;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
        }

        .receipt-number {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .receipt-date {
            font-size: 10px;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }

        .items-table th {
            text-align: left;
            padding: 2px 0;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }

        .items-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .items-table .product-name {
            width: 60%;
        }

        .items-table .quantity {
            width: 15%;
            text-align: center;
        }

        .items-table .price {
            width: 25%;
            text-align: right;
        }

        /* Summary Section */
        .summary {
            margin: 5px 0;
            padding-top: 5px;
            border-top: 1px solid #000;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 1px 0;
        }

        .summary-total {
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 2px;
            margin-top: 2px;
        }

        /* Payment Section */
        .payment-section {
            margin: 5px 0;
            padding: 3px 0;
            border-top: 1px dashed #000;
        }

        /* Footer Styles */
        .footer {
            text-align: center;
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px dashed #000;
            font-size: 10px;
        }

        .footer-text {
            margin: 2px 0;
        }

        .powered-by {
            font-weight: bold;
            margin-top: 3px;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 1px 4px;
            border-radius: 2px;
            font-size: 9px;
            font-weight: bold;
        }

        .status-discount {
            background: #f0f0f0;
            border: 1px solid #ccc;
        }

        .status-debt {
            background: #ffe6e6;
            border: 1px solid #ff9999;
        }

        .status-balance {
            background: #e6f7ff;
            border: 1px solid #99ccff;
        }

        /* Action Buttons */
        .action-buttons {
            text-align: center;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin: 0 5px;
            border: 1px solid #ccc;
            background: #f5f5f5;
            cursor: pointer;
            text-decoration: none;
            color: #333;
            font-size: 12px;
            border-radius: 3px;
        }

        .btn-print {
            background: #4CAF50;
            color: white;
            border-color: #45a049;
        }

        .btn-close {
            background: #f44336;
            color: white;
            border-color: #d32f2f;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 400px;
            width: 90%;
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-small {
            font-size: 10px;
        }

        .mt-1 { margin-top: 5px; }
        .mt-2 { margin-top: 10px; }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }

        /* QR Code Section */
        .qr-section {
            text-align: center;
            margin: 10px 0;
            padding: 5px;
            border: 1px dashed #ccc;
        }

        .qr-code {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="receipt" id="receipt-content">
        <!-- Receipt Header -->
        <div class="header">
            <div class="company-name">{{ env('COMPANY_NAME') }}</div>
            <div class="company-address">{{ env('COMPANY_ADDRESS') }}</div>
            <div class="company-contact">08067275241, 08054942852</div>
        </div>

        <!-- Receipt Info -->
        <div class="receipt-info">
            <div class="receipt-number">RECEIPT #{{ $receipt }}</div>
            <div class="receipt-date">{{ date('Y-m-d H:i:s') }}</div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th class="product-name">PRODUCT</th>
                    <th class="quantity">QTY</th>
                    <th class="price">TOTAL(₦)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart_items as $key => $cart)
                <tr>
                    <td class="product-name">{{ $cart['i_name'] }}</td>
                    <td class="quantity">{{ $cart['qty'] }}</td>
                    <td class="price">{{ $cart['price_total'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
{{-- {{ dd($amount_paid) }} --}}
        <!-- Summary Section -->
        <div class="summary">
            <div class="summary-row">
                <span>Grand Total:</span>
                <span class="text-bold">{{ $price_total }}</span>
            </div>
            <div class="summary-row">
                <span>Amount Paid:</span>
                <span class="text-bold">{{ $amount_paid }}</span>
            </div>
            
            @if($is_discount == 1 || $is_discount == 2 || $is_discount == 0)
            <div class="summary-row summary-total">
                <span>
                    @if($is_discount == 1)
                        <span class="status-badge status-discount">DISCOUNT</span>
                    @elseif($is_discount == 2)
                        <span class="status-badge status-debt">DEBT</span>
                    @else
                        <span class="status-badge status-balance">BALANCE</span>
                    @endif
                </span>
                <span>{{ $difference }}</span>
            </div>
            @endif
        </div>

        <!-- Payment Method (if available) -->
        @if(isset($payment_method))
        <div class="payment-section">
            <div class="summary-row">
                <span>Payment Method:</span>
                <span class="text-bold">{{ strtoupper($payment_method) }}</span>
            </div>
        </div>
        @endif

        <!-- Customer Info (if available) -->
        @if(isset($customer_name) && $customer_name)
        <div class="payment-section">
            <div class="summary-row">
                <span>Customer:</span>
                <span>{{ $customer_name }}</span>
            </div>
            @if(isset($customer_phone) && $customer_phone)
            <div class="summary-row">
                <span>Phone:</span>
                <span>{{ $customer_phone }}</span>
            </div>
            @endif
        </div>
        @endif

        <!-- QR Code Section (Optional) -->
        <!-- 
        <div class="qr-section">
            <div class="footer-text">Scan for digital receipt</div>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=RECEIPT-{{ $receipt }}" 
                 class="qr-code" alt="Receipt QR Code">
        </div>
        -->

        <!-- Footer -->
        <div class="footer">
            <div class="footer-text">Goods sold in good conditions are not returnable</div>
            <div class="footer-text">Thanks for your patronage</div>
            <div class="footer-text powered-by">Powered by Acing Ltd.</div>
            <div class="footer-text">0803 802 1699</div>
        </div>

        <!-- Print Indicator -->
        <!--
        <div class="text-center text-small mt-2">
            --- ---
        </div>
        -->
    </div>

    <!-- Action Buttons (Hidden when printing) -->
    <div class="action-buttons no-print">
        <a href="javascript:window.print()" class="btn btn-print">
            <i class="fa fa-print"></i> Print Receipt
        </a>
        <a class="btn btn-close" href="{{ url('/sales') }}">
            <i class="fa fa-times"></i> Close
        </a>
        {{-- <button class="btn" onclick="openEmailModal()">
            <i class="fa fa-envelope"></i> Email Receipt
        </button> --}}
    </div>

    <!-- Email Modal -->
    <div class="modal" id="emailModal">
        <div class="modal-content">
            <h3 class="text-center mb-2">Email Receipt</h3>
            <form id="emailForm">
                <div class="mb-1">
                    <label for="emailAddress">Customer Email:</label>
                    <input type="email" id="emailAddress" class="form-control" 
                           placeholder="customer@example.com" required>
                </div>
                <div class="action-buttons mt-2">
                    <button type="button" class="btn" onclick="closeEmailModal()">Cancel</button>
                    <button type="submit" class="btn btn-print">Send Email</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-print on page load (optional - uncomment if needed)
        // window.addEventListener('load', function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 1000);
        // });

        // Email Modal Functions
        function openEmailModal() {
            document.getElementById('emailModal').classList.add('active');
        }

        function closeEmailModal() {
            document.getElementById('emailModal').classList.remove('active');
        }

        // Handle Email Form Submission
        document.getElementById('emailForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('emailAddress').value;
            
            // In a real application, you would send this to your backend
            alert(`Receipt would be sent to: ${email}\n\nThis feature requires backend integration.`);
            
            closeEmailModal();
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                closeEmailModal();
            }
        });

        // Add print styles dynamically
        const printStyles = `
            @media print {
                @page {
                    margin: 0;
                    size: 80mm auto;
                }
                
                body {
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
                
                .receipt {
                    width: 80mm !important;
                    max-width: 80mm !important;
                    margin: 0 !important;
                    padding: 2mm !important;
                }
            }
        `;

        // Add print styles to document
        const styleSheet = document.createElement("style");
        styleSheet.type = "text/css";
        styleSheet.innerText = printStyles;
        document.head.appendChild(styleSheet);

        // Format numbers on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Format all currency amounts
            document.querySelectorAll('.price, [class*="summary"] span:last-child').forEach(el => {
                if (el.textContent.includes('₦')) {
                    const amount = el.textContent.replace('₦', '').trim();
                    if (!isNaN(parseFloat(amount))) {
                        el.textContent = '₦' + parseFloat(amount).toFixed(2);
                    }
                }
            });
        });
    </script>
</body>
</html>