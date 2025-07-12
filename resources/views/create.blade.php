@extends('layouts.app')

@section('title', 'LinkTinker | The URL Shortener powered by Laravel')

@section('main-content')
<div>
    <form method="POST" action="{{ route('shortlinks.store') }}">
        @csrf
        <div class="grid lg:grid-cols-2 gap-4">
            @include("components.input", [
                "name" => "url",
                "placeholder" => "Enter URL Here",
                "type" => "text",
                "label" => "URL",
                "error" => $errors->first('url'),
                "old" => old('url')
            ])

            @include("components.input", [
                "name" => "slug",
                "placeholder" => "Enter Slug",
                "type" => "text",
                "label" => "Slug (Optional)",
                "error" => $errors->first('slug'),
                "old" => old('slug')
            ])

            @include("components.input", [
                "name" => "expires_at",
                "placeholder" => "Enter Expiry Date (Optional)",
                "type" => "date",
                "label" => "Expiry Date (Optional)",
                "error" => $errors->first('expires_at'),
                "old" => old('expires_at'),
                "min" => Carbon\Carbon::now()->toDateString()
            ])

            @include("components.input", [
                "name" => "max_clicks",
                "placeholder" => "Enter Maximum Clicks",
                "type" => "text",
                "label" => "Max Clicks (Optional)",
                "error" => $errors->first('max_clicks'),
                "old" => old('max_clicks')
            ])

            <div class="lg:col-span-2 flex justify-end">
                @include('components.button', ["buttonContent" => "Shorten Link", "type" => "submit"])
            </div>
        </div>
    </form>
    @if(session()->has("slug"))
    @php
        $shortenedUrl = env("APP_URL") . "/" . session()->get("slug");
    @endphp
    <hr class="text-gray-500 mt-5">
    <div class="font-syne grid gap-4">
        <div class="w-full text-center pt-5">
            <p class="w-full flex lg:flex-row flex-col items-center justify-center">
                {{-- <span class="me-2 lg:mb-0 mb-2">Your Short Link: </span> --}}
                <span class="p-1.5 rounded-md border border-[#fffaed2d] flex items-center">
                    <span class="me-2"><a href="{{ $shortenedUrl }}" id="short-link" target="_blank" class="hover:underline">{{ $shortenedUrl }}</a></span>
                    @include('components.icon-button', [
                        "buttonContent" => "<svg  xmlns='http://www.w3.org/2000/svg'  width='16'  height='16'  viewBox='0 0 24 24'  fill='none'  stroke='currentColor'  stroke-width='2'  stroke-linecap='round'  stroke-linejoin='round'  class='icon icon-tabler icons-tabler-outline icon-tabler-copy'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z' /><path d='M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1' /></svg>",
                        "type" => "button",
                        "id" => "copy-btn"
                    ])
                </span>
            </p>
            <p class="text-green-500 mt-3">Your link has been shortened successfully..!!</p>
        </div>
    </div>
    @endif
</div>
@endsection

@push("scripts")
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if(document.querySelector("#copy-btn") == null) return
            document.querySelector("#copy-btn").addEventListener("click", function() {
                copyToClipboard(document.querySelector("#short-link").textContent)
            })
        })

        function copyToClipboard(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text)
                .then(() => {
                    console.log('Copied to clipboard');
                })
                .catch(err => {
                    console.error('Failed to copy: ', err);
                });
            } else {
                // Fallback
                fallbackCopyToClipboard(text);
            }
        }

        function fallbackCopyToClipboard(text) {
            const textarea = document.createElement("textarea");
            textarea.value = text;

            // Avoid scrolling to bottom
            textarea.style.top = "0";
            textarea.style.left = "0";
            textarea.style.position = "fixed";

            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();

            try {
                const successful = document.execCommand("copy");
                console.log(successful ? 'Copied (fallback)' : 'Fallback copy failed');
            } catch (err) {
                console.error('Fallback copy error:', err);
            }

            document.body.removeChild(textarea);
        }
    </script>
@endpush
