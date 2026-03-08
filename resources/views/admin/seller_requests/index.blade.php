<!DOCTYPE html>
<html>
<head>
    <title>Seller Requests</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#f5efe7] min-h-screen p-6">

    <h1 class="text-3xl font-bold text-center text-[#6b4f2c] mb-8">
        Seller Requests
    </h1>

    <div class="overflow-x-auto bg-white border-2 border-[#c2a27e] rounded-lg shadow">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#e8dccb] text-[#6b4f2c]">
                    <th class="p-3 border border-[#c2a27e]">User</th>
                    <th class="p-3 border border-[#c2a27e]">Business</th>
                    <th class="p-3 border border-[#c2a27e]">GST</th>
                    <th class="p-3 border border-[#c2a27e]">Status</th>
                    <th class="p-3 border border-[#c2a27e]">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($requests as $req)
                <tr class="hover:bg-[#f9f4ee]">
                    <td class="p-3 border border-[#c2a27e]">
                        {{ $req->user->name ?? 'N/A' }}
                    </td>
                    <td class="p-3 border border-[#c2a27e]">
                        {{ $req->business_name }}
                    </td>
                    <td class="p-3 border border-[#c2a27e]">
                        {{ $req->gst ?? '-' }}
                    </td>
                    <td class="p-3 border border-[#c2a27e] capitalize">
                        {{ $req->status }}
                    </td>
                    <td class="p-3 border border-[#c2a27e] space-x-2">
                        @if($req->status === 'pending')
                        <form method="POST" action="/admin/seller-requests/{{ $req->id }}/approve" class="inline">
                            @csrf
                            <button class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-800">
                                Approve
                            </button>
                        </form>

                        <form method="POST" action="/admin/seller-requests/{{ $req->id }}/reject" class="inline">
                            @csrf
                            <button class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800">
                                Reject
                            </button>
                        </form>
                        @else
                            <span class="text-sm text-gray-600">
                                No action
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
