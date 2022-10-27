<x-jet-form-section submit="createTeam">
    <x-slot name="title">
        {{ __('Detalhes da equipe') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Crie uma nova equipe para colaborar com outras pessoas em projetos.') }}
    </x-slot>

    <x-slot name="form">
        <div class="mb-3">
            <x-jet-label value="{{ __('Proprietário da equipe') }}" />

            <div class="d-flex mt-2">
                <img class="rounded-circle" width="48" src="{{ $this->user->profile_photo_url }}">

                <div class="ms-2">
                    <div>{{ $this->user->name }}</div>
                    <div class="text-muted">{{ $this->user->email }}</div>
                </div>
            </div>
        </div>

        <div class="w-md-75">
            <div class="mb-3">
                <x-jet-label for="name" value="{{ __('Nome do time') }}" />
                <x-jet-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                             wire:model.defer="state.name" autofocus />
                <x-jet-input-error for="name" />
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button>
            {{ __('Criar') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
