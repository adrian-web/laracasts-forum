<div x-ref="flash" x-data="{show: false, message: '', timeout: null }" @flash.window="
        show = true,
        message = $event.detail.text,
        $refs.flash.className = 'fixed right-5 bottom-5 cursor-pointer px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-green-400 active:bg-green-600 focus:outline-none focus:border-green-700 focus:shadow-outline-green',
        clearTimeout(timeout),
        timeout = setTimeout(() => {show = false}, 3000),
        " x-show.transition.opacity.duration.300ms="show" x-on:click="show = false" x-text="message"
        style="display: none;">
</div>