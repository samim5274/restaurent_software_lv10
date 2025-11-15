function calculateAmount() {
    const subtotalText = document.getElementById('cart-total').innerText.replace(/,/g, '');
    const subtotal = parseFloat(subtotalText) || 0;

    const vatPercent = parseFloat(document.getElementById('num4').value) || 0;
    const discount = parseFloat(document.getElementById('num3').value) || 0;
    const pay = parseFloat(document.getElementById('num2').value) || 0;

    const confirmBtn = document.getElementById('confirmBtn');
    const result = document.getElementById('result');
    const customerInfo = document.getElementById("customer-info");

    // Validation
    if (vatPercent < 0 || discount < 0 || pay < 0) {
        result.innerText = "Negative values are not allowed.";
        confirmBtn.disabled = true;
        return;
    }

    // Calculate VAT and grand total
    const vatAmount = (subtotal * vatPercent) / 100;
    const grandTotal = subtotal + vatAmount - discount;

    // Update VAT & Discount display
    document.getElementById('vat-amount').innerText = vatAmount.toFixed(2);
    document.getElementById('discount-amount').innerText = discount.toFixed(2);

    // Update calculated subtotal (grandTotal)
    document.getElementById('cart-subtotal').innerText = grandTotal.toFixed(2);

    // Determine due or return
    const balance = pay - grandTotal;
    let message = "";

    if (balance > 0) {
        message = "Return: ৳" + balance.toFixed(2) + "/-";
        result.classList.remove("text-danger");
        result.classList.add("text-success");
        confirmBtn.disabled = false;
        customerInfo.style.display = "none";
    } else if (balance < 0) {
        message = "Due: ৳" + Math.abs(balance).toFixed(2) + "/-";
        result.classList.remove("text-success");
        result.classList.add("text-danger");
        confirmBtn.disabled = false;
        customerInfo.style.display = "block";
    } else {
        message = "Fully Paid: ৳0.00/-";
        result.classList.remove("text-danger");
        result.classList.add("text-success");
        confirmBtn.disabled = false;
        customerInfo.style.display = "none";
    }

    result.innerText = message;
}
