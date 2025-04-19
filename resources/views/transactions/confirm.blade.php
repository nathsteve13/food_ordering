<!DOCTYPE html>
<html>
<head>
    <title>Payment Confirmation</title>
</head>
<body>
    <h1>Payment Confirmation</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('transactions.confirm') }}" method="POST">
        @csrf
        <label for="transaction_id">Transcation ID:</label><br>
        <input type="text" name="transaction_id" id="transaction_id" required><br><br>

        <label for="payment_method">Payment Method:</label><br>
        <select name="payment_method" id="payment_method" required>
            <option value="eWallet">e-wallet</option>
            <option value="credit">Credit</option>
            <option value="debit">Debit</option>
            <option value="qris">QRIS</option>
        </select><br><br>

        <label for="amount">Total Payment (Rp):</label><br>
        <input type="number" name="amount" id="amount" required><br><br>

        <button type="submit">Payment Confirm</button>
    </form>
</body>
</html>