<div>
    <label for="{{ $name }}" class="font-syne text-white text-sm font-bold mb-1 inline-block">{{ $label }}</label>
    <input type="{{ $type }}" placeholder="{{ $placeholder }}" value="{{ $old }}" class="font-syne text-white p-2 rounded-md border border-[#fffaed2d] focus:outline-0 focus:border-white w-full" name="{{ $name }}" min="{{ $min ?? null }}" />
    <label class="text-red-500 text-xs font-syne">{{ $error }}</label>
</div>
