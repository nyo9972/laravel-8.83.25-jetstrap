<div>
    <!-- Generate API Token -->
    <x-jet-form-section submit="createApiToken">
        <x-slot name="title">
            {{ __('Criar token de API') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Os tokens de API permitem que serviços de terceiros se autentiquem com nosso aplicativo em seu nome.') }}
        </x-slot>

        <x-slot name="form">
            <x-jet-action-message on="created">
                {{ __('Criado.') }}
            </x-jet-action-message>

            <div class="w-md-75">
                <!-- Token Name -->
                <div class="mb-3">
                    <x-jet-label for="name" value="{{ __('Nome do Token') }}" />
                    <x-jet-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                                 wire:model.defer="createApiTokenForm.name" autofocus />
                    <x-jet-input-error for="name" />
                </div>

                <!-- Token Permissions -->
                @if (Laravel\Jetstream\Jetstream::hasPermissions())
                    <div>
                        <x-jet-label for="permissions" value="{{ __('Permissions') }}" />

                        <div class="mt-2 row">
                            @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                                <div class="col-6">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <x-jet-checkbox wire:model.defer="createApiTokenForm.permissions" id="{{ 'create-'.$permission }}" :value="$permission"/>
                                            <label class="form-check-label" for="{{ 'create-'.$permission }}">
                                                {{ $permission }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-button>
                {{ __('Criar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    @if ($this->user->tokens->isNotEmpty())
        <x-jet-section-border />

        <!-- Manage API Tokens -->
        <div>
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Gerenciar tokens de API') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Você pode excluir qualquer um dos seus tokens existentes se eles não forem mais necessários.') }}
                </x-slot>

                <!-- API Token List -->
                <x-slot name="content">
                    <div>
                        @foreach ($this->user->tokens->sortBy('name') as $token)
                            <div class="d-flex justify-content-between">
                                <div>
                                    {{ $token->name }}
                                </div>

                                <div class="d-flex">
                                    @if ($token->last_used_at)
                                        <div class="text-sm text-muted">
                                            {{ __('Usado por último') }} {{ $token->last_used_at->diffForHumans() }}
                                        </div>
                                    @endif

                                    @if (Laravel\Jetstream\Jetstream::hasPermissions())
                                        <button class="btn btn-link text-secondary" wire:click="manageApiTokenPermissions({{ $token->id }})">
                                            {{ __('Permissões') }}
                                        </button>
                                    @endif

                                    <button class="btn btn-link text-danger text-decoration-none" wire:click="confirmApiTokenDeletion({{ $token->id }})">
                                        {{ __('Apagar') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>
    @endif

    <!-- Token Value Modal -->
    <x-jet-dialog-modal wire:model="displayingToken">
        <x-slot name="title">
            {{ __('API Token') }}
        </x-slot>

        <x-slot name="content">
            <div>
                {{ __('Copie seu novo token de API. Para sua segurança, ganhou\' ser mostrado novamente.') }}
            </div>

            <div class="mb-3">
                <x-jet-input x-ref="plaintextToken" type="text" readonly :value="$plainTextToken"
                             autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                             @showing-token-modal.window="setTimeout(() => $refs.plaintextToken.select(), 250)"
                />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('displayingToken', false)" wire:loading.attr="disabled">
                {{ __('Fechar') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- API Token Permissions Modal -->
    <x-jet-dialog-modal wire:model="managingApiTokenPermissions">
        <x-slot name="title">
            {{ __('Permissões de token de API') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-2 row">
                @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                    <div class="col-6">
                        <div class="mb-3">
                            <div class="form-check">
                                <x-jet-checkbox wire:model.defer="updateApiTokenForm.permissions" id="{{ 'update-'.$permission }}" :value="$permission"/>
                                <label class="form-check-label" for="{{ 'update-'.$permission }}">
                                    {{ $permission }}
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingApiTokenPermissions', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button wire:click="updateApiToken" wire:loading.attr="disabled">
                {{ __('Salvar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Delete Token Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingApiTokenDeletion">
        <x-slot name="title">
            {{ __('Apagar API Token') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que deseja excluir este token de API?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingApiTokenDeletion')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button wire:loading.attr="disabled" wire:click="deleteApiToken">
                {{ __('Apagar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
