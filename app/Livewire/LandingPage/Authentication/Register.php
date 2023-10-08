<?php

namespace App\Livewire\LandingPage\Authentication;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.landing-page.app')]
class Register extends Component
{

    #[Rule('required|min:5')] 
    public $name = '';

    #[Rule('required|email|unique:users,email')] 
    public $email = '';

    #[Rule('required|min:8')] 
    public $password = '';

    public function save() {

        // lakukan validasi terlebih dahulu
        $this->validate();

        // simpan data
        $this->store();
        
    }

    private function checkUserOrCreate() {
        $user = UserRole::where('name', 'User')->first();

        if($user != null) {
            return $user;
        }

        return UserRole::create([
            'name' => 'User'
        ]);
    }

    private function store() {
        try {

            $user = $this->checkUserOrCreate();
            
            $user = User::create([
                'user_roles_id' => $user->id,
                'fullname' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'register_type' => 'email',
            ]);

            

            if(!$user) {
                Session::flash('error', 'Gagal Membuat Akun'); 
                return;       
            }


            if(Auth::guard('users')->loginUsingId($user->id)) {
                // reset field
                $this->reset();
                // redirect ke dashboard
                $this->redirect('/dashboard', navigate:true);
            }

        } catch (QueryException $e) {
            Session::flash('error', "ada sesuatu yang salah");        
        }
    }

    public function render()
    {
        return view('livewire.landing-page.authentication.register');
    }
}
