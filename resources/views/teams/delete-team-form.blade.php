<x-jet-action-section>
    <x-slot name="title">
        {{ __('Excluir equipe') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Excluir permanentemente esta equipe.') }}
    </x-slot>

    <x-slot name="content">
        <div class="test-sm text-muted">
            {{ __('Depois que uma equipe for excluída, todos os seus recursos e dados serão excluídos permanentemente. Antes de excluir esta equipe, faça o download de quaisquer dados ou informações sobre essa equipe que você deseja manter.') }}
        </div>

        <div class="mt-3">
            <x-jet-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                {{ __('Excluir equipe') }}
            </x-jet-danger-button>
        </div>

        <!-- Delete team Confirmation Modal -->
        <x-jet-confirmation-modal wire:model="confirmingTeamDeletion">
            <x-slot name="title">
                {{ __('Excluir equipe') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Tem certeza de que deseja excluir esta equipe? Depois que uma equipe for excluída, todos os seus recursos e dados serão excluídos permanentemente.') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingTeamDeletion')"
                                        wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-danger-button wire:click="deleteTeam" wire:loading.attr="disabled">
                    <div wire:loading wire:target="deleteTeam" class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>

                    {{ __('Excluir equipe') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    </x-slot>
</x-jet-action-section>
