@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold">👤 Gestion des Utilisateurs</h1>

    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2">Nom</th>
                <th class="py-2">Email</th>
                <th class="py-2">Statut</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                @if ($user->role !== 'admin') <!-- Vérification du rôle ici -->
                    <tr class="border-b">
                        <td class="py-2">{{ $user->name }}</td>
                        <td class="py-2">{{ $user->email }}</td>
                        <td class="py-2">
                            <span class="px-2 py-1 {{ $user->is_blocked ? 'bg-red-500' : 'bg-green-500' }} text-white rounded">
                                {{ $user->is_blocked ? 'Bloqué' : 'Actif' }}
                            </span>
                        </td>
                        <td class="py-2 flex space-x-2">
                            <form method="POST" action="{{ route('admin.users.toggleBlock', $user->id) }}">
                                @csrf
                                <button class="bg-yellow-500 text-white px-2 py-1 rounded">
                                    {{ $user->is_blocked ? '🔓 Débloquer' : '🔒 Bloquer' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-2 py-1 rounded">🗑️ Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
