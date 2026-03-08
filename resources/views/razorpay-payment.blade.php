<h2 class="text-center">Pay Securely</h2>

<button id="rzp_button" class="bg-green-600 text-white p-3 rounded w-full">Pay Now</button>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
var options = {
    "key": "{{ $key }}",
    "amount": "{{ $amount }}",
    "currency": "INR",
    "name": "Your Store",
    "order_id": "{{ $order_id }}",
    "handler": function (response){
        fetch("{{ route('payment.success') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(response)
        }).then(res => window.location.href = res.url);
    }
};

var rzp1 = new Razorpay(options);

document.getElementById('rzp_button').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>
