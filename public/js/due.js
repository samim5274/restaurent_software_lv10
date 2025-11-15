function calculateAmount(id) {
    const total = parseFloat(document.getElementById('num1' + id).value) || 0;
    const pay = parseFloat(document.getElementById('num2' + id).value) || 0;
    const discount = parseFloat(document.getElementById('num3' + id).value) || 0;

    const result = document.getElementById('result' + id);
    const btnSave = document.getElementById('btnSave' + id);

    const payable = total - discount;
    const balance = pay - payable;

    // Validate
    if (total <= 0) {
        result.textContent = "Invalid total amount.";
        result.className = "text-danger display-6";
        btnSave.disabled = true;
        return;
    }

    if (discount < 0 || pay < 0) {
        result.textContent = "Negative values are not allowed.";
        result.className = "text-danger display-6";
        btnSave.disabled = true;
        return;
    }

    if (discount > total) {
        result.textContent = "Discount cannot exceed total.";
        result.className = "text-danger display-6";
        btnSave.disabled = true;
        return;
    }

    // Enable save
    btnSave.disabled = false;

    // Show result
    if (balance > 0) {
        result.textContent = "Return: ৳" + balance.toFixed(2) + "/-";
        result.className = "text-success display-6";
    } else if (balance < 0) {
        result.textContent = "Due: ৳" + Math.abs(balance).toFixed(2) + "/-";
        result.className = "text-danger display-6";
    } else {
        result.textContent = "Fully Paid: ৳0.00/-";
        result.className = "text-primary display-6";
    }
}
