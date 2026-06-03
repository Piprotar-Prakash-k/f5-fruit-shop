<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class CustomerLogin extends Component
{
    public string $email = '';
    public string $password = '';

    public function login()
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email'    => $this->email,
            'password' => $this->password,
        ])) {
            return redirect('/');
        }

        $this->addError('email', 'Wrong email or password!');
    }

    public function render()
    {
        return view('livewire.customer-login');
    }
}
