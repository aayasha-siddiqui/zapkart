@extends('layouts.app')
<style>
:root{
  --mitti-dark:#5a3e36;
  --mitti-mid:#8a6a52;
  --mitti-accent:#c07a35;
  --mitti-soft:#e8d8c4;
  --mitti-cream:#f3e9dd;
  --mitti-warning:#d8952a;
  --mitti-success:#2e7d32;
  --mitti-danger:#c62828;
  --mitti-muted:#7c726d;
}

/* TEXT */
.text-mitti-dark{color:var(--mitti-dark);}
.text-mitti-muted{color:var(--mitti-muted);}

/* BACKGROUND */
.bg-mitti-mid{background:var(--mitti-mid);}
.bg-mitti-cream{background:var(--mitti-cream);}
.bg-mitti-warning{background:var(--mitti-warning);}
.bg-mitti-success{background:var(--mitti-success);}
.bg-mitti-danger{background:var(--mitti-danger);}

/* BORDER */
.border-mitti-soft{border-color:var(--mitti-soft);}
</style>

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-mitti-dark">Users Management</h1>
            <p class="text-sm text-mitti-muted">All registered users in the system</p>
        </div>

        <div class="bg-white px-4 py-2 rounded-lg shadow text-mitti-dark">
            <span class="font-semibold">Total Users:</span>
            {{ $users->count() }}
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-4">
        <input id="searchInput"
            type="text"
            placeholder="Search by name, email, role…"
            class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-mitti-mid focus:outline-none" />
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto rounded-lg shadow">
        <table id="usersTable" class="min-w-full bg-white">
            <thead class="bg-mitti-mid text-white">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">User</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Email</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Role</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Orders</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Joined</th>
                    <th class="px-4 py-2 text-right text-sm font-semibold">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr class="border-b hover:bg-mitti-cream transition">
                    <td class="px-4 py-3">{{ $user->id }}</td>

                    <td class="px-4 py-3 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-mitti-mid text-white flex items-center justify-center font-semibold">
                            {{ strtoupper(substr($user->name,0,2)) }}
                        </div>
                        <div>
                            <div class="font-semibold">{{ $user->name }}</div>
                        </div>
                    </td>

                    <td class="px-4 py-3">{{ $user->email }}</td>

                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded bg-gray-200 font-semibold">
                            {{ $user->role ?? 'User' }}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        {{ $user->orders_count ?? 0 }}
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-600">
                        {{ $user->created_at->format('d M Y') }}
                    </td>

                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.users.show', $user->id) }}"
                            class="bg-mitti-mid hover:bg-mitti-dark text-white px-3 py-1 rounded shadow transition">
                            View →
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
    {{ $users->links() }}
</div>

</div>

<!-- JS Search Filter -->
<script>
document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#usersTable tbody tr");

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

@endsection
