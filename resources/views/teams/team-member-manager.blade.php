<div>
    @if (Gate::check('addTeamMember', $team))
        <x-jet-section-border />

        <!-- Add Team Member -->
        <x-jet-form-section submit="addTeamMember">
            <x-slot name="title">
                {{ __('Adicionar membro da equipe') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Adicione um novo membro à sua equipe, permitindo que eles colaborem com você.') }}
            </x-slot>

            <x-slot name="form">
                <x-jet-action-message on="saved">
                    {{ __('Adicionado.') }}
                </x-jet-action-message>

                <div class="mb-3">
                    {{ __('Forneça o endereço de e-mail da pessoa que você gostaria de adicionar a esta equipe. O endereço de e-mail deve estar associado a uma conta existente.') }}
                </div>

                    <!-- Member Email -->
                    <div class="mb-2 w-md-75">
                        <div class="form-group">
                            <x-jet-label for="email" value="{{ __('Email') }}" />
                            <x-jet-input id="name" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                                         wire:model.defer="addTeamMemberForm.email" />
                            <x-jet-input-error for="email" />
                        </div>
                    </div>

                <!-- Role -->
                @if (count($this->roles) > 0)
                    <div class="my-3 w-md-75">
                        <div class="form-group">
                            <x-jet-label for="role" value="{{ __('Role') }}" />

                            <input type="hidden" class="{{ $errors->has('role') ? 'is-invalid' : '' }}">
                            <x-jet-input-error for="role" />
                        </div>

                        <div class="list-group">
                            @foreach ($this->roles as $index => $role)
                                <a href="#" class="list-group-item list-group-item-action{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? ' text-black-50' : '' }}"
                                   wire:click.prevent="$set('addTeamMemberForm.role', '{{ $role->key }}')">
                                    <div>
                                        <span class="{{ $addTeamMemberForm['role'] == $role->key ? 'font-weight-bold' : '' }}">
                                            {{ $role->name }}
                                        </span>
                                        @if ($addTeamMemberForm['role'] == $role->key)
                                            <svg class="ms-1 text-success font-weight-light" width="20" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-2">
                                        {{ $role->description }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </x-slot>

            <x-slot name="actions">
                <x-jet-button>
                    {{ __('Adicionar') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    @endif

    @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
        <x-jet-section-border />

        <!-- Team Member Invitations -->
        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Convites de equipe pendentes') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Essas pessoas foram convidadas para sua equipe e receberam um e-mail de convite. Eles podem se juntar à equipe aceitando o convite por e-mail.') }}
            </x-slot>

            <x-slot name="content">
                @foreach ($team->teamInvitations as $invitation)
                    <div class="d-flex align-items-center justify-content-between mt-2 mb-2">
                        <div class="">{{ $invitation->email }}</div>

                        <div class="d-flex align-items-center">
                            @if (Gate::check('removeTeamMember', $team))
                                <!-- Cancel Team Invitation -->
                                <button class="btn btn-link text-danger text-decoration-none"
                                                    wire:click="cancelTeamInvitation({{ $invitation->id }})">
                                    <div wire:loading wire:target="cancelTeamInvitation" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    {{ __('Cancelar') }}
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </x-slot>
        </x-jet-action-section>
    @endif

    @if ($team->users->isNotEmpty())
        <x-jet-section-border />

        <!-- Manage Team Members -->
        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Membros da equipe') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Todas as pessoas que fazem parte desta equipe.') }}
            </x-slot>

            <!-- Team Member List -->
            <x-slot name="content">
                @foreach ($team->users->sortBy('name') as $user)
                    <div class="d-flex justify-content-between mt-2 mb-2">
                        <div class="d-flex align-items-center">
                            <div class="pr-3">
                                <img width="32" class="rounded-circle" src="{{ $user->profile_photo_url }}">
                            </div>
                            <span>{{ $user->name }}</span>
                        </div>

                        <div class="d-flex">
                            <!-- Manage Team Member Role -->
                            @if (Gate::check('addTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())
                                <button class="btn btn-link text-secondary" wire:click="manageRole({{ $user->id }})">
                                    {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                </button>
                            @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                                <button class="btn btn-link text-secondary disabled text-decoration-none ms-2">
                                    {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                </button>
                            @endif

                            <!-- Leave Team -->
                            @if ($this->user->id === $user->id)
                                <button class="btn btn-link text-danger text-decoration-none" wire:click="$toggle('confirmingLeavingTeam')">
                                    {{ __('Sair') }}
                                </button>

                            <!-- Remove Team Member -->
                            @elseif (Gate::check('removeTeamMember', $team))
                                <button class="btn btn-link text-danger text-decoration-none" wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">
                                    <div wire:loading wire:target="confirmTeamMemberRemoval" class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Carregando...</span>
                                    </div>

                                    {{ __('Remover') }}
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </x-slot>
    </x-jet-action-section>
    @endif

    <!-- Role Management Modal -->
    <x-jet-dialog-modal wire:model="currentlyManagingRole">
        <x-slot name="title">
            {{ __('Manage Role') }}
        </x-slot>

        <x-slot name="content">
            <div class="list-group">
                @foreach ($this->roles as $index => $role)
                    <a href="#" class="list-group-item list-group-item-action{{ $currentRole !== $role->key ? ' text-black-50' : '' }}"
                       wire:click.prevent="$set('currentRole', '{{ $role->key }}')">
                        <div>
                            <span class="{{ $currentRole == $role->key ? 'font-weight-bold' : '' }}">
                                {{ $role->name }}
                            </span>
                            @if ($currentRole == $role->key)
                                <svg class="ms-1 text-success font-weight-light" width="20" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                        </div>

                        <!-- Role Description -->
                        <div class="mt-2">
                            {{ $role->description }}
                        </div>
                    </a>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="stopManagingRole" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ms-2" wire:click="updateRole" wire:loading.attr="disabled">
                {{ __('Salvar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Leave Team Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingLeavingTeam">
        <x-slot name="title">
            {{ __('Sair da equipe') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que gostaria de deixar esta equipe?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ms-2" wire:click="leaveTeam" wire:loading.attr="disabled">
                {{ __('Sair') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Remove Team Member Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingTeamMemberRemoval">
        <x-slot name="title">
            {{ __('Remover membro da equipe') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que deseja remover essa pessoa da equipe?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ms-2" wire:click="removeTeamMember" wire:loading.attr="disabled">
                {{ __('Remover') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
