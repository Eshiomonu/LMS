{{-- Shared course form partial. Used by create.blade.php and edit.blade.php.
     Expects: $course (for edit; null for create), $categories, $submitLabel --}}

@php
$isEdit  = isset($course) && $course->exists;
$old     = fn(string $key, $fallback = '') => old($key, $isEdit ? ($course->{$key} ?? $fallback) : $fallback);
$oldArr  = fn(string $key) => old($key, $isEdit
    ? (is_array($course->{$key}) ? implode("\n", $course->{$key}) : ($course->{$key} ?? ''))
    : '');
$oldTags = old('tags', $isEdit
    ? (is_array($course->tags) ? implode(', ', $course->tags) : ($course->tags ?? ''))
    : '');
@endphp

<div class="grid grid-cols-1 gap-7 xl:grid-cols-3">

    {{-- ── LEFT: Main details (2/3 width) ── --}}
    <div class="xl:col-span-2 space-y-6">

        {{-- Basic Info --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-5 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Basic Information
            </h3>

            <div class="space-y-4">
                {{-- Title --}}
                <div>
                    <label class="form-label">Course Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ $old('title') }}" required
                           placeholder="e.g. PMP® Certification Training"
                           class="form-input {{ $errors->has('title') ? 'border-red-400' : '' }}" />
                    @error('title') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Subtitle --}}
                <div>
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ $old('subtitle') }}"
                           placeholder="A short supporting headline"
                           class="form-input" />
                </div>

                {{-- Description --}}
                <div>
                    <label class="form-label">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="5" required
                              placeholder="Full course description…"
                              class="form-input {{ $errors->has('description') ? 'border-red-400' : '' }}">{{ $old('description') }}</textarea>
                    @error('description') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Why train with us --}}
                <div>
                    <label class="form-label">Why Train With Us</label>
                    <textarea name="why_train_with_us" rows="3"
                              placeholder="Key selling points…"
                              class="form-input">{{ $old('why_train_with_us') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Curriculum / Outcomes --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-1 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Course Content
            </h3>
            <p class="mb-5 text-xs text-slate-400">Enter one item per line for list fields.</p>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="form-label">What You Will Learn</label>
                    <textarea name="what_you_will_learn" rows="6"
                              placeholder="One outcome per line…"
                              class="form-input">{{ $oldArr('what_you_will_learn') }}</textarea>
                </div>
                <div>
                    <label class="form-label">Who This Course Is For</label>
                    <textarea name="who_course_is_for" rows="6"
                              placeholder="One audience type per line…"
                              class="form-input">{{ $oldArr('who_course_is_for') }}</textarea>
                </div>
                <div>
                    <label class="form-label">Requirements / Prerequisites</label>
                    <textarea name="requirements" rows="4"
                              placeholder="One requirement per line…"
                              class="form-input">{{ $oldArr('requirements') }}</textarea>
                </div>
                <div>
                    <label class="form-label">What You Get</label>
                    <textarea name="what_you_get" rows="4"
                              placeholder="e.g. Certificate of completion…"
                              class="form-input">{{ $oldArr('what_you_get') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Curriculum Overview</label>
                    <textarea name="course_curriculum" rows="6"
                              placeholder="One module/topic per line…"
                              class="form-input">{{ $oldArr('course_curriculum') }}</textarea>
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-5 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                SEO
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ $old('meta_title') }}"
                           class="form-input" placeholder="Override browser tab title" />
                </div>
                <div>
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-input"
                              placeholder="Short description for search engines (max 160 chars)">{{ $old('meta_description') }}</textarea>
                </div>
                <div>
                    <label class="form-label">Tags <span class="text-xs text-slate-400">(comma-separated)</span></label>
                    <input type="text" name="tags" value="{{ $oldTags }}"
                           placeholder="PMP, project management, certification"
                           class="form-input" />
                </div>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: Settings sidebar (1/3 width) ── --}}
    <div class="space-y-6">

        {{-- Publish settings --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Publish
            </h3>
            <div class="space-y-3">
                <div>
                    <label class="form-label">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="form-input">
                        @foreach(['draft'=>'Draft','pending'=>'Pending Review','published'=>'Published','archived'=>'Archived'] as $val => $lbl)
                        <option value="{{ $val }}" @selected($old('status','draft')===$val)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
                <label class="flex cursor-pointer items-center gap-2.5">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1"
                           class="h-4 w-4 rounded text-indigo-600"
                           {{ $old('is_featured', $isEdit && $course->is_featured ? '1' : '0') == '1' ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-slate-700">Mark as Featured</span>
                </label>
            </div>

            <div class="mt-5 flex gap-2">
                <button type="submit"
                        class="flex-1 rounded-xl py-2.5 text-sm font-bold text-white
                               transition hover:opacity-90 active:scale-[0.98]"
                        style="background:var(--brand)">
                    {{ $submitLabel ?? 'Save Course' }}
                </button>
                <a href="{{ route('admin.courses.index') }}"
                   class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold
                          text-slate-600 hover:bg-slate-50 transition">
                    Cancel
                </a>
            </div>
        </div>

        {{-- Organisation --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Organisation
            </h3>
            <div class="space-y-3">
                <div>
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-input">
                        <option value="">— None —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected($old('category_id')==$cat->id)>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Level <span class="text-red-500">*</span></label>
                    <select name="level" required class="form-input">
                        @foreach(['beginner','intermediate','advanced'] as $lv)
                        <option value="{{ $lv }}" @selected($old('level','beginner')===$lv)>
                            {{ ucfirst($lv) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Language</label>
                    <input type="text" name="language" value="{{ $old('language','English') }}"
                           class="form-input" />
                </div>
            </div>
        </div>

        {{-- Pricing --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Pricing
            </h3>
            <div class="space-y-3">
                <div>
                    <label class="form-label">Currency</label>
                    <select name="currency" class="form-input">
                        @foreach(['NGN'=>'NGN — Naira','USD'=>'USD — US Dollar','GBP'=>'GBP — British Pound'] as $code=>$lbl)
                        <option value="{{ $code }}" @selected($old('currency','NGN')===$code)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Price <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ $old('price',0) }}"
                           min="0" step="0.01" required class="form-input" />
                </div>
                <div>
                    <label class="form-label">Discount Price</label>
                    <input type="number" name="discount_price"
                           value="{{ $old('discount_price') }}"
                           min="0" step="0.01" class="form-input"
                           placeholder="Leave blank for none" />
                </div>
            </div>
        </div>

        {{-- Schedule / Format --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Schedule & Format
            </h3>
            <div class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Hours</label>
                        <input type="number" name="duration_hours"
                               value="{{ $old('duration_hours') }}"
                               min="0" class="form-input" />
                    </div>
                    <div>
                        <label class="form-label">Weeks</label>
                        <input type="number" name="duration_weeks"
                               value="{{ $old('duration_weeks') }}"
                               min="0" class="form-input" />
                    </div>
                </div>
                <div>
                    <label class="form-label">Schedule</label>
                    <input type="text" name="schedule" value="{{ $old('schedule') }}"
                           placeholder="e.g. Weekdays 9am–5pm" class="form-input" />
                </div>
                <div>
                    <label class="form-label">Mode</label>
                    <input type="text" name="mode" value="{{ $old('mode') }}"
                           placeholder="e.g. Live Online / In-Person" class="form-input" />
                </div>
            </div>
        </div>

        {{-- Thumbnail --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Thumbnail
            </h3>
            @if($isEdit && $course->thumbnail)
            <div class="mb-3 overflow-hidden rounded-xl">
                <img src="{{ asset('storage/'.$course->thumbnail) }}"
                     class="w-full object-cover" style="max-height:140px" />
            </div>
            @endif
            <input type="file" name="thumbnail" accept="image/*"
                   class="block w-full text-sm text-slate-500
                          file:mr-3 file:rounded-xl file:border-0
                          file:bg-indigo-50 file:px-4 file:py-2
                          file:text-sm file:font-semibold file:text-indigo-700
                          hover:file:bg-indigo-100" />
            <p class="mt-1.5 text-xs text-slate-400">JPEG, PNG — max 2 MB</p>
        </div>

    </div>{{-- end right --}}
</div>