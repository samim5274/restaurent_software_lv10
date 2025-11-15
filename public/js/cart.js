$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.btn-plus, .btn-minus', function () {
        var id = $(this).data('id');
        var input = $('input.qty-input[data-id="' + id + '"]');
        var currentQty = parseInt(input.val()|| 1);
        var newQty = currentQty;

        if ($(this).hasClass('btn-plus')) {
            newQty = currentQty + 1;
        } else if ($(this).hasClass('btn-minus') && currentQty > 1) {
            newQty = currentQty - 1;
        }

        if (newQty === currentQty) return;

        updateQuantity(id, newQty, input);
    });

    $(document).on('change', '.qty-input', function () {
        var id = $(this).data('id');
        var newQty = parseInt($(this).val());

        if (newQty < 1 || isNaN(newQty)) {
            alert('Invalid quantity');
            $(this).val(1);
            newQty = 1;
        }

        updateQuantity(id, newQty, $(this));
    });

    function updateQuantity(id, newQty, input) {
        $.post('/cart/update-quantity', {
            id: id,
            quantity: newQty
        }, function (response) {
            if (response.status === 'success') {
                input.val(response.quantity);

                var card = input.closest('.card-body');
                var price = parseFloat(card.find('[data-price]').data('price'));
                var subtotal = price * response.quantity;
                card.find('.item-subtotal').text('৳' + subtotal.toFixed(2));

                updateCartTotal();
            } else {
                alert(response.message || 'Update failed');
            }
        }).fail(function (xhr) {
            alert('Something went wrong!');
            console.error(xhr.responseText);
        });
    }

    function updateCartTotal() {
        let total = 0;
        $('.card-body').each(function () {
            const price = parseFloat($(this).find('[data-price]').data('price'));
            const qty = parseInt($(this).find('.qty-input').val());
            if (!isNaN(price) && !isNaN(qty)) {
                total += price * qty;
            }
        });
        $('#cart-subtotal').text(total.toFixed(0));
        $('#cart-total').text(total.toFixed(0));
        $('#cart-total-input').val(Math.round(total));
    }
});
