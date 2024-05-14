<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;

class Users extends Component
{
    public $user, $roles, $name, $email, $identificacion, $telefono, $rol, $rolS, $id_user;

    public function abrirModal($id, $modal){

        $this->user = User::find($id);

        if($modal == 'Edit'){
            $this->roles = Role::get()->pluck('name');
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->identificacion = $this->user->identificacion;
            $this->telefono = $this->user->telefono;
            $this->id_user = $id;
            $this->roles->prepend($this->user->roles->implode('name', ','));
        }
        $this->dispatch('openModal', modal: $modal);
    }

    public function closeModal($modal){
        $this->dispatch('closeModal', modal: $modal);
        $this->resetInputs();
    }

    public function resetInputs(){
        $this->name = null;
        $this->email = null;
        $this->identificacion = null;
        $this->telefono = null;
        $this->rol = null;
        $this->roles = null;
        $this->id_user = null;
    }

    public function Store(){
        $validatedData = $this->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        if($this->rol != NULL){

            User::find($this->id_user)->update([
                'name' => $this->name ,
                'email' => $this->email,
                'identificacion' => $this->identificacion,
                'telefono' => $this->telefono
            ]);

             User::find($this->id_user)->syncRoles($this->rol);

        }else{

            User::find($this->id_user)->update([
                'name' => $this->name ,
                'email' => $this->email,
            ]);
        }

        $this->closeModal('Edit');
        $this->dispatch('UserUpdate');

    }

    public function delUser($id){
        $this->dispatch('eliminar', id: $id);
    }

    #[On('say-delete')]
    public function delete($id){
        User::find($id)->delete();
        $this->dispatch('Delete');
    }

    public function render()
    {
        return view('livewire.users',[
            'users' => User::all(),
        ]);
    }
}
