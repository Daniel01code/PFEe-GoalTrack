<?php

if (!function_exists('redirectByRole')) {
    function redirectByRole()
    {
        if (!auth()->check()) {
            return route('login');
        }

        $role = auth()->user()->role;

        return match ($role) {
            'dg'      => route('dg.dashboard'),
            'chef'    => route('chef.dashboard'),
            'employe' => route('employee.dashboard'),
            // default   => route('home'), // ou '/' ou route('login')
        };
    }
}