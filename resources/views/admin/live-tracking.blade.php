@extends('layouts.app')

@section('content')

<style>
/* 🌿 MITTI THEME COLORS */
:root {
    --mitti-bg: #f4efe7;
    --mitti-card: #ffffff;
    --mitti-border: #e3d9c9;
    --mitti-dark: #5e4b3c;
    --mitti-accent: #c7a97a;
}

/* PAGE BACKGROUND */
body { background: var(--mitti-bg) !important; }

.section-title {
    font-size: 24px;
    font-weight: 800;
    color: var(--mitti-dark);
    margin-bottom: 18px;
}

/* PARTNER CARD */
.partner-card {
    background: var(--mitti-card);
    padding: 18px;
    border-radius: 14px;
    border: 1px solid var(--mitti-border);
    margin-bottom: 18px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    transition: 0.2s ease;
}
.partner-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.partner-name {
    font-size: 18px;
    font-weight: 700;
    color: var(--mitti-dark);
}

.partner-code {
    font-size: 13px;
    color: #8a6a4a;
}

.status-online {
    color: #0d8a29;
    font-weight: 600;
}
.status-offline {
    color: #b73b3b;
    font-weight: 600;
}

/* ORDER BOX */
.order-box {
    background: #faf7f2;
    border: 1px solid var(--mitti-border);
    padding: 12px;
    border-radius: 10px;
    margin-top: 10px;
    cursor: pointer;
    transition: 0.2s;
}
.order-box:hover {
    background: #f0e8dc;
}

/* MODAL */
.modal-bg {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.45);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal-box {
    width: 95%;
    max-width: 450px;
    background: var(--mitti-card);
    border-radius: 16px;
    padding: 22px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}

/* TIMELINE */
.timeline-step {
    display: flex;
    align-items: start;
    margin-bottom: 14px;
}
.dot {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    flex-shrink: 0;
    margin-right: 12px;
    border: 2px solid var(--mitti-accent);
}
.dot.done { background: var(--mitti-accent); }
.dot.pending { background: var(--mitti-bg); }

.line {
    width: 2px;
    height: 22px;
    background: var(--mitti-border);
    margin-left: 6px;
}
</style>


<div class="p-4 md:p-6">
    <h1 class="section-title">📍 Live Delivery Partner Tracking</h1>

    <div id="liveData"></div>
</div>


{{-- 🌿 MODAL --}}
<div class="modal-bg" id="modal">
    <div class="modal-box animate__animated animate__fadeInUp">

        <h3 class="text-xl font-bold mb-2 text-[var(--mitti-dark)]" id="modalTitle"></h3>

        <p class="text-sm mb-2 text-[var(--mitti-dark)]">
            <strong>Tracking ID:</strong> <span id="trackingId"></span>
        </p>

        <p class="text-sm mb-2 text-[var(--mitti-dark)]">
            <strong>Deliver To:</strong> <span id="deliverTo"></span>
        </p>

        <p class="text-sm mb-4 text-[var(--mitti-dark)]">
            <strong>ETA:</strong> <span id="eta"></span>
        </p>

        <div id="modalTimeline" class="mb-3"></div>

        <h4 class="font-semibold text-[var(--mitti-dark)]">🛒 Order Items</h4>
        <ul id="modalItems" class="list-disc ml-5 text-[var(--mitti-dark)] mb-3"></ul>

        <button onclick="closeModal()" 
            class="mt-3 bg-[var(--mitti-accent)] text-white px-4 py-2 rounded-md shadow">
            Close
        </button>
    </div>
</div>


<script>
/* ================================
   🌿 LIVE DATA LOAD
================================ */
function loadLive() {
    fetch("{{ route('admin.live.tracking.data') }}")
        .then(r => r.json())
        .then(data => {
            let html = "";

            data.forEach(p => {

                html += `
                <div class="partner-card">

                    <div class="partner-name">${p.partner_name}</div>
                    <div class="partner-code">Partner Code: ${p.partner_code ?? '—'}</div>

                    <div class="text-sm mt-1 ${p.online_status === 'online' ? 'status-online' : 'status-offline'}">
                        ${p.online_status}
                    </div>

                    <div class="mt-3 font-semibold text-[var(--mitti-dark)]">
                        Active Orders (${p.total_active_orders})
                    </div>
                `;

                p.active_orders.forEach(o => {
                    html += `
                    <div class="order-box" onclick="openOrder('${o.order_number}')">
                        <div><b>#${o.order_number}</b></div>
                        <div class='text-xs text-gray-500'>Tracking ID: ${o.awb ?? '—'}</div>
                        <span class="text-sm">Status: ${o.status}</span>
                    </div>`;
                });

                html += `
                    <div class="mt-3 font-semibold text-[var(--mitti-dark)]">
                        Completed Orders (${p.total_completed_orders})
                    </div>
                `;

                p.completed_orders.forEach(o => {
                    html += `
                    <div class="order-box" onclick="openOrder('${o.order_number}')">
                        <div><b>#${o.order_number}</b></div>
                        <div class='text-xs text-gray-500'>Tracking ID: ${o.awb ?? '—'}</div>
                        <span class="text-sm">Delivered</span>
                    </div>`;
                });

                html += `</div>`;
            });

            document.getElementById("liveData").innerHTML = html;
        });
}

loadLive();
setInterval(loadLive, 4000);


/* ================================
   🌿 ORDER DETAIL POPUP
================================ */
function openOrder(orderNo) {
    fetch(`/admin/order-detail/${orderNo}`)
        .then(r => r.json())
        .then(data => {

            document.getElementById("modalTitle").innerHTML = `Order #${data.order.order_number}`;
            document.getElementById("trackingId").innerHTML = data.order.tracking_id ?? '—';
            document.getElementById("deliverTo").innerHTML = data.order.address ?? '—';
            document.getElementById("eta").innerHTML = data.order.eta ?? '—';

            let t = "";
            data.timeline.forEach((step, i) => {
                t += `
                <div class="timeline-step">
                    <div class="dot ${step.done ? 'done' : 'pending'}"></div>

                    <div>
                        <div class="font-semibold text-[var(--mitti-dark)]">${step.label}</div>
                        <div class="text-xs text-gray-600">${step.time ?? ''}</div>
                    </div>
                </div>
                ${i < data.timeline.length-1 ? '<div class="line"></div>' : ''}
                `;
            });

            document.getElementById("modalTimeline").innerHTML = t;

            let items = "";
            data.items.forEach(i => items += `<li>${i.qty} × ${i.name}</li>`);
            document.getElementById("modalItems").innerHTML = items;

            document.getElementById("modal").style.display = "flex";
        });
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}

</script>

@endsection
