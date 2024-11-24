<div x-data="{ show: false }" x-show="show" x-transition.duration.300ms class="fixed bottom-5 left-5 bg-green-500 text-white p-4 rounded-md" x-init="$watch('message', value => { if(value) { show = true; setTimeout(() => show = false, 3000); } })">
    <span x-text="message"></span>
</div>