@extends('layouts.app')

@section('content')
<!DOCTYPE html>

<html>
<head>
    <title>Seller Requests</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#f5efe7] min-h-screen p-6">

    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-center text-[#6b4f2c] mb-8">
        Seller Requests
    </h1>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-5xl mx-auto mb-4 bg-green-100 text-green-800 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-5xl mx-auto mb-4 bg-red-100 text-red-800 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- ================= PENDING SELLERS ================= -->
    <div class="max-w-6xl mx-auto bg-white border-2 border-[#c2a27e] rounded-lg shadow mb-10">
        <h2 class="text-xl font-semibold text-[#6b4f2c] px-6 py-4 border-b border-[#c2a27e] bg-[#e8dccb]">
            Pending Seller Requests
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f9f4ee] text-[#6b4f2c]">
                        <th class="p-3 border border-[#c2a27e]">User</th>
                        <th class="p-3 border border-[#c2a27e]">Email</th>
                        <th class="p-3 border border-[#c2a27e]">Business</th>
                        <th class="p-3 border border-[#c2a27e]">GST</th>
                        <th class="p-3 border border-[#c2a27e]">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pending as $req)
                        <tr class="hover:bg-[#f9f4ee]">
                            <td class="p-3 border border-[#c2a27e]">
                                {{ $req->user->name ?? 'N/A' }}
                            </td>
                            <td class="p-3 border border-[#c2a27e]">
                                {{ $req->user->email ?? '-' }}
                            </td>
                            <td class="p-3 border border-[#c2a27e]">
                                {{ $req->business_name }}
                            </td>
                           <td class="p-3 border border-[#c2a27e]">
    {{ $req->gst ?? '-' }}
</td>


                            <td class="p-3 border border-[#c2a27e] space-x-2">
                                <form method="POST" action="/admin/seller-approve/{{ $req->id }}" class="inline">
                                    @csrf
                                    <button class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-800">
                                        Approve
                                    </button>
                                </form>

                                <form method="POST" action="/admin/seller-reject/{{ $req->id }}" class="inline">
                                    @csrf
                                    <button class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800">
                                        Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-600">
                                No pending seller requests.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= APPROVED SELLERS ================= -->
    <div class="max-w-6xl mx-auto bg-white border-2 border-[#c2a27e] rounded-lg shadow mb-10">
        <h2 class="text-xl font-semibold text-[#6b4f2c] px-6 py-4 border-b border-[#c2a27e] bg-[#e8dccb]">
            Approved Sellers
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f9f4ee] text-[#6b4f2c]">
                        <th class="p-3 border border-[#c2a27e]">User</th>
                        <th class="p-3 border border-[#c2a27e]">Email</th>
                        <th class="p-3 border border-[#c2a27e]">Business</th>
                        <th class="p-3 border border-[#c2a27e]">GST</th>
<th class="p-3 border border-[#c2a27e]">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($approved as $req)
                        <tr class="hover:bg-[#f9f4ee]">
                            <td class="p-3 border border-[#c2a27e]">
                                {{ $req->user->name ?? 'N/A' }}
                            </td>
                            <td class="p-3 border border-[#c2a27e]">
                                {{ $req->user->email ?? '-' }}
                            </td>
                            <td class="p-3 border border-[#c2a27e]">
                                {{ $req->business_name }}
                            </td>
                            <td class="p-3 border border-[#c2a27e]">
                                {{ $req->gst ?? '-' }}
                            </td>
                            <td class="p-3 border border-[#c2a27e] text-center">
    <a href="{{ route('admin.sellers.show', $req->user_id) }}"
       class="bg-[#6b4f2c] text-white px-3 py-1 rounded hover:bg-[#5a3e22] text-sm">
        Show
    </a>
</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-4 text-gray-600">
                                No approved sellers.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= REJECTED SELLERS ================= -->
    <div class="max-w-6xl mx-auto bg-white border-2 border-[#c2a27e] rounded-lg shadow">
        <h2 class="text-xl font-semibold text-[#6b4f2c] px-6 py-4 border-b border-[#c2a27e] bg-[#e8dccb]">
            Rejected Seller Requests
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f9f4ee] text-[#6b4f2c]">
                        <th class="p-3 border border-[#c2a27e]">User</th>
                        <th class="p-3 border border-[#c2a27e]">Email</th>
                        <th class="p-3 border border-[#c2a27e]">Business</th>
                        <th class="p-3 border border-[#c2a27e]">GST</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rejected as $req)
                        <tr class="hover:bg-[#f9f4ee]">
                            <td class="p-3 border border-[#c2a27e]">
                                {{ $req->user->name ?? 'N/A' }}
                            </td>
                            <td class="p-3 border border-[#c2a27e]">
                                {{ $req->user->email ?? '-' }}
                            </td>
                            <td class="p-3 border border-[#c2a27e]">
                                {{ $req->business_name }}
                            </td>
                            <td class="p-3 border border-[#c2a27e]">
                                {{ $req->gst ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-4 text-gray-600">
                                No rejected sellers.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
@endsection
