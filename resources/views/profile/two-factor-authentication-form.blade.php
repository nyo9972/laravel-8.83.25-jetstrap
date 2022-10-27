<x-jet-action-section>
    <x-slot name="title">
        {{ __('Autenticação de dois fatores') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Adicione segurança adicional à sua conta usando autenticação de dois fatores.') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="h5 font-weight-bold">
            @if ($this->enabled)
                {{ __('Você ativou a autenticação de dois fatores.') }}
            @else
                {{ __('Você não ativou a autenticação de dois fatores.') }}
            @endif
        </h3>

        <p class="mt-3">
            {{ __('Quando a autenticação de dois fatores estiver habilitada, você será solicitado a fornecer um token seguro e aleatório durante a autenticação. Você pode recuperar este token do seu telefone\'Aplicativo Google Authenticator.') }}
        </p>

        @if ($this->enabled)
            @if ($showingQrCode)
                <p class="mt-3">
                    {{ __('A autenticação de dois fatores agora está habilitada. Digitalize o seguinte código QR usando seu telefone\'Aplicativo Google Authenticator.') }}
                </p>

                <div class="mt-3">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>
            @endif

            @if ($showingRecoveryCodes)
                <p class="mt-3">
                    {{ __('Armazene esses códigos de recuperação em um gerenciador de senhas seguro. Eles podem ser usados ​​para recuperar o acesso à sua conta se seu dispositivo de autenticação de dois fatores for perdido.') }}
                </p>

                <div class="bg-light rounded p-3">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-3">
            @if (! $this->enabled)
                <x-jet-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-jet-button type="button" wire:loading.attr="disabled">
                        {{ __('Permitir') }}
                    </x-jet-button>
                </x-jet-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-jet-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-jet-secondary-button class="me-3">
                            <div wire:loading wire:target="regenerateRecoveryCodes" class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>

                            {{ __('Regenerar Códigos de Recuperação') }}
                        </x-jet-secondary-button>
                    </x-jet-confirms-password>
                @else
                    <x-jet-confirms-password wire:then="showRecoveryCodes">
                        <x-jet-secondary-button class="me-3">
                            <div wire:loading wire:target="showRecoveryCodes" class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>

                            {{ __('Mostrar códigos de recuperação') }}
                        </x-jet-secondary-button>
                    </x-jet-confirms-password>
                @endif

                <x-jet-confirms-password wire:then="disableTwoFactorAuthentication">
                    <x-jet-danger-button wire:loading.attr="disabled">
                        <div wire:loading wire:target="disableTwoFactorAuthentication" class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>

                        {{ __('Desativar') }}
                    </x-jet-danger-button>
                </x-jet-confirms-password>
            @endif
        </div>
    </x-slot>
</x-jet-action-section>
