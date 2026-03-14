{{-- Shared category form partial --}}
@php $isEdit = isset($category) && $category->exists; @endphp

@push('styles')
<style>
    .form-label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:5px; }
    .form-input { width:100%; border-radius:10px; border:1px solid #e2e8f0; padding:9px 12px; font-size:13.5px; color:#0f172a; outline:none; transition:border-color .15s; }
    .form-input:focus { border-color:#4f46e5; box-shadow:0 0 0 3px rgba(79,70,229,.1); }
    .form-error { color:#dc2626; font-size:12px; margin-top:4px; }
</style>
@endpush

<div class="max-w-lg">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-5">

        <div>
            <label class="form-label">Category Name <span class="text-red-500">*</span></label>
            <input type="text" name="name"
                   value="{{ old('name', $isEdit ? $category->name : '') }}"
                   required placeholder="e.g. Project Management"
                   class="form-input {{ $errors->has('name') ? 'border-red-400' : '' }}" />
            @error('name') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" class="form-input"
                      placeholder="Brief description of this category…">{{ old('description', $isEdit ? $category->description : '') }}</textarea>
        </div>

        <div>
            <label class="flex cursor-pointer items-center gap-2.5">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1"
                       class="h-4 w-4 rounded text-indigo-600"
                       {{ old('is_active', $isEdit ? $category->is_active : true) ? 'checked' : '' }}>
                <span class="text-sm font-medium text-slate-700">Active (visible on site)</span>
            </label>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="flex-1 rounded-xl py-2.5 text-sm font-bold text-white
                           transition hover:opacity-90 active:scale-[0.98]"
                    style="background:var(--brand)">
                {{ $submitLabel ?? 'Save Category' }}
            </button>
            <a href="{{ route('admin.categories.index') }}"
               class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold
                      text-slate-600 hover:bg-slate-50 transition">
                Cancel
            </a>
        </div>
    </div>
</div>