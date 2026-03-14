@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Categories')
@section('page-subtitle', $categories->total() . ' categories')

@section('header-actions')
<a href="{{ route('admin.categories.create') }}"
   class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold text-white
          shadow-sm transition hover:opacity-90" style="background:var(--brand)">
    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    New Category
</a>
@endsection

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 bg-slate-50/60 text-xs font-bold uppercase
                       tracking-wider text-slate-500">
                <th class="px-6 py-3.5 text-left">Name</th>
                <th class="px-4 py-3.5 text-left hidden md:table-cell">Slug</th>
                <th class="px-4 py-3.5 text-left hidden md:table-cell">Description</th>
                <th class="px-4 py-3.5 text-center">Courses</th>
                <th class="px-4 py-3.5 text-center">Active</th>
                <th class="px-4 py-3.5 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($categories as $cat)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4 font-semibold text-slate-900">{{ $cat->name }}</td>
                <td class="px-4 py-4 hidden md:table-cell text-xs text-slate-400 font-mono">{{ $cat->slug }}</td>
                <td class="px-4 py-4 hidden md:table-cell text-slate-500 text-xs max-w-[200px] truncate">
                    {{ $cat->description ?: '—' }}
                </td>
                <td class="px-4 py-4 text-center text-slate-600">{{ $cat->courses_count }}</td>
                <td class="px-4 py-4 text-center">
                    <form method="POST" action="{{ route('admin.categories.toggle', $cat) }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold
                                       transition {{ $cat->is_active ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $cat->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                            {{ $cat->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </form>
                </td>
                <td class="px-4 py-4 text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <a href="{{ route('admin.categories.edit', $cat) }}"
                           class="inline-flex h-8 w-8 items-center justify-center rounded-lg
                                  border border-slate-200 text-slate-500 hover:bg-indigo-50
                                  hover:text-indigo-600 hover:border-indigo-200 transition">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                              onsubmit="return confirm('Delete \'{{ $cat->name }}\'? Cannot delete if it has courses.')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg
                                           border border-slate-200 text-slate-500 hover:bg-red-50
                                           hover:text-red-600 hover:border-red-200 transition">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-14 text-center text-sm text-slate-400">
                    No categories yet.
                    <a href="{{ route('admin.categories.create') }}"
                       class="ml-1 font-semibold hover:underline" style="color:var(--brand)">
                        Create one →
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($categories->hasPages())
    <div class="border-t border-slate-100 px-6 py-4">{{ $categories->links() }}</div>
    @endif
</div>
@endsection