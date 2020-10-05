<div>
    <form wire:submit.prevent="create">
        <div class="lg:mt-5 md:mt-0 md:col-span-2">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="body" value="{{ __('Body') }}" />
                            <textarea name="body" id="body" rows="10" wire:model.defer="body"
                                class="form-textarea rounded-md shadow-sm mt-1 block w-full" required></textarea>
                            <x-jet-input-error for="body" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <x-jet-button>
                        {{ __('Post') }}
                    </x-jet-button>
                </div>
            </div>
        </div>
    </form>
</div>