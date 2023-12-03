<?php
namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse extends \Filament\Http\Responses\Auth\LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        if (auth()->user()->role == 'admin') {
            return redirect()->to(route('filament.admin.pages.dashboard'));
        } else if (auth()->user()->role == 'user') {
            //cek halaman terakhir
            if (session()->has('kembali')) {
                return redirect()->to(session()->get('kembali'));
            }
            return redirect()->to(route('public.index'));
        }
        return parent::toResponse($request);
    }
}
