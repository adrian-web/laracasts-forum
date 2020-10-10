<div>
    <div x-data="{ hidden: {{ (int) $lockState}} }" x-show="!hidden" x-cloak>
        <form wire:submit.prevent="create">
            <div class="mt-5 shadow overflow-hidden shadow-md sm:rounded-md">
                <div class="px-4 py-5 sm:p-6">
                    <x-jet-label for="body" value="{{ __('Body') }}" />
                    <textarea name="body" id="body" rows="10" wire:model.defer="body"
                        class="form-textarea shadow-sm mt-1 block w-full" required></textarea>
                    <x-jet-input-error for="body" class="mt-2" />
                </div>
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 sm:px-6">
                    <x-jet-button>
                        <span wire:loading wire:target="create">
                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                        {{ __('Post') }}
                    </x-jet-button>
                </div>
            </div>
        </form>
    </div>
    <div x-data="{ hidden: {{ (int) $lockState}} }" x-show="hidden" x-cloak>
        <h4 class="mt-6 text-2xl">
            <p>{{ __('Thread has been locked...')}}</p>
        </h4>
    </div>
</div>