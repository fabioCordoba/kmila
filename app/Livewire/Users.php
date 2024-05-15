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
    public $user, $roles, $name, $email, $identificacion, $telefono, $rol, $rolS, $id_user, $isEdit = false;

    public function abrirModal($id, $modal){


        if($modal == 'Edit'){
            $this->isEdit = true;
            $this->user = User::find($id);

            $this->roles = Role::get()->pluck('name');
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->identificacion = $this->user->identificacion;
            $this->telefono = $this->user->telefono;
            $this->id_user = $id;
            $this->roles->prepend($this->user->roles->implode('name', ','));

            $this->dispatch('openModal', modal: $modal);
        }else if ($modal == 'Create'){
            $this->isEdit = false;
            $this->roles = Role::get()->pluck('name');
            $this->dispatch('openModal', modal: 'Edit');
        }else{
            $this->user = User::find($id);
            $this->dispatch('openModal', modal: $modal);
        }


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

        if($this->isEdit == true){
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
        }else{
            $user = User::create([
                'name' => $this->name ,
                'email' => $this->email,
                'password' => Hash::make($this->email),
            ]);
            $user->assignRole($this->rol);

            $this->closeModal('Edit');
            $this->dispatch('UserCreate');
        }
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
