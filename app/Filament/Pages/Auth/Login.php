<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Login as BasePage;
use Illuminate\Validation\ValidationException;

class Login extends BasePage
{
    public function mount(): void
    {
        parent::mount();

        if (app()->isLocal()) {
            $this->form->fill([
                'username' => config('app.default_user.username'),
                'password' => config('app.default_user.password'),
                'remember' => true,
            ]);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password'  => $data['password'],
        ];
    }

    /**
     * Get the login form component.
     *
     * @return \Filament\Forms\Components\Component
     */
    protected function getLoginFormComponent(): Component 
    {
        return TextInput::make('username')
            ->label('Usuário')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }
}
