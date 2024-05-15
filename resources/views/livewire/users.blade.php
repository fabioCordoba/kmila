<div>

    <!-- Modal Show-->
    <div wire:ignore.self  class="modal fade" id="modal-Show" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md font-sans h-screen w-full flex flex-row justify-center items-center"  style="margin-top: 20px;">
        @if ($user)
        <div class="modal-content card w-96 mx-auto bg-white shadow-xl hover:shadow">
            <img class="w-32 mx-auto rounded-full -mt-20 border-8 border-white" src="https://avatars.githubusercontent.com/u/67946056?v=4" alt="">

            <div class="text-center mt-2 text-3xl font-medium">{{$user->name}}</div>
            <div class="text-center mt-2 font-normal text-sm">{{$user->email}}</div>
            <div class="text-center font-normal text-lg">{{ $user->roles->implode('name', ',') }}</div>
            <div class="px-6 text-center mt-2 font-light text-sm">
            <p>
                CC: {{$user->identificacion}} , Telefono: {{$user->telefono}}
            </p>
            </div>

            <div class="modal-header">
            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition" wire:click="closeModal('Show')" aria-label="Close">close</button>
            </div>
        </div>


        @else

        @endif
        </div>
    </div>

    <!-- Modal Edit-->
    <div wire:ignore.self  class="modal fade" id="modal-Edit" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" style="margin-top: 20px;">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px;">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition" wire:click="closeModal('Edit')" aria-label="Close">Close</button>
            </div>
            <div class="modal-body" style="padding: 10px;">
                <form  >
                {{csrf_field()}}

                {{$isEdit}}

                <div class="row">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="basic-addon1">Cedula</span>
                        <input type="text" class="form-control" id="cedula" name="cedula" wire:model="identificacion" value="identificacion" placeholder="Cedula" aria-label="Cedula">
                        <span class="input-group-text">Telefono</span>
                        <input type="text" class="form-control" id="telefono" name="telefono" wire:model="telefono" placeholder="Telefono" aria-label="Telefono">
                    </div>
                </div>

                <div class="row">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="basic-addon1">Nombre</span>
                        <input type="text" class="form-control" id="name" name="name" wire:model="name" placeholder="Nombre" aria-label="Nombre">
                        <input type="text" wire:model="id_user" hidden>
                    </div>
                </div>

                <div class="row">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="basic-addon1">Correo</span>
                        <input type="text" class="form-control" id="email" name="email" wire:model="email" placeholder="Correo" aria-label="Correo">
                    </div>
                </div>

                @role('ROOT')
                <div class="row">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="basic-addon1">Rol</span>
                        <select class="form-select form-select-sm" aria-label="Small select example" id="rol" name="rol" wire:model="rol">
                            @if ($roles)
                                @foreach ($roles as $esp)
                                    <option value="{{$esp}}">{{$esp}}</option>
                                @endforeach
                            @else

                            @endif
                        </select>
                    </div>
                </div>
                @endrole

                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-sm btn-outline-info" wire:click="Store">Crear</button>
                    </div>

                </div>

                </form>

            </div>

        </div>
    </div>
    </div>

    <table class="w-full divide-y divide-gray-200">
      <thead>
        <tr>
            <th scope="col" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Foto
            </th>
            <th scope="col" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Informacion Personal
            </th>
            <th scope="col" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Contacto
            </th>
            <th scope="col" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
            </th>
            <th scope="col" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Rol
            </th>
            <th scope="col" class="px-6 py-3 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                <button class="rounded-full bg-red-500">
                    <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs" wire:click="abrirModal(0,'Create')">Crear Usuario</span>
                </button>
            </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
          @if($users->count())
              @foreach($users as $i => $usuario)
                  <tr>
                      <td class="px-6 py-4 text-center whitespace-nowrap">
                        <div class="d-flex justify-content-center">
                            <div class="flex-shrink-0 h-10 w-10">
                              <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                            </div>
                          </div>

                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="text-sm text-gray-500">{{$usuario->name}}</div>
                        <div class="text-sm text-gray-900">{{$usuario->identificacion}}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="text-sm text-gray-500">{{$usuario->email}}</div>
                        <div class="text-sm text-gray-900">{{$usuario->telefono}}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                          Active
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        {{$usuario->roles->implode('name', ',')}}
                      </td>
                      <td style="width: 170px;">
                        @if ($usuario->roles->implode('name', ',') != 'ROOT')
                        <div class="flex item-center justify-center">
                            <button type="button" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" wire:click="abrirModal({{$usuario->id}},'Show')" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>

                            <button type="button" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" wire:click="abrirModal({{$usuario->id}},'Edit')" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>

                            <button type="button" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" wire:click="delUser({{$usuario->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        @endif

                      </td>
                    </tr>
              @endforeach

          @else
              <tr>
                  <td colspan="5">
                      <div class="alert alert-warning">
                          No se encontraron usuarios
                      </div>
                  </td>
              </tr>
          @endif

      </tbody>

    </table>


</div>
