<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment...</title>
</head>
<body>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    var options = {
        "key": "{{ $key }}",
        "amount": "{{ $order->total_amount * 100 }}",
        "currency": "INR",
        "name": "Your Store",
        "description": "Order Payment",
        "order_id": "{{ $razorpayId }}",
        "handler": function (response){
            fetch("{{ route('payment.verify') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(response)
            }).then(() => {
                window.location.href = "/cart";
            });
        },
        "theme": {
            "color": "#3399cc"
        }
    };

    var rzp = new Razorpay(options);
    rzp.open();
</script>

</body>
</html>
