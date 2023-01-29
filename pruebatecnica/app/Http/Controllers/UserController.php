<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;


class UserController extends Controller
{
    public function getUsers(Request $request){
        $id= $request->input('id');

        //seleccionando todos los registros de la tabla por medio del modelo
        $users = User::select('id', 'first_name','last_name','email', 'dui')
                    ->where('id', "!=", $id)
                    ->get();

        if(is_null($users) || $users == ''){
            //$respuesta = ['resultado'=>'NO'];
            $code = 204;//peticion sin contenido
        }else{
            //$respuesta = ['resultado'=>'OK'];
            $code = 200;//peticion con exito
            foreach($users as $u){
                $u['role']  = $u->roles->pluck('name')->implode(',');
            }
        }
        
        //retornando json para frontend
        return response()->json($users,$code);
    }

    public function addUser(Request $request){
        //validacion email unico
        if($this->emailExists($request->input('data.email'))){
            $response = ['isValid'=>false, 'message' => 'Email already in use!'];
            
            return response()->json($response);
        }

         //validacion num dui unico
         if($this->duiExists($request->input('data.dui'))){
            $response = ['isValid'=>false, 'message' => 'DUI already in use!'];
            
            return response()->json($response);
        }

        //creando obj del modelo Usuario para guardar nuevo registro
        $user = new User();

        //asignando datos del request al objeto
        $user->first_name = $request->input('data.first_name');
        $user->last_name = $request->input('data.last_name');
        $user->email = $request->input('data.email');
        $user->dui = $request->input('data.dui');
        $user->verification_code = Str::random(15);
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password

        $role = $request->input('data.role');

        //guardando usuario
        if($user->save()){
            //si guarda el usuario asigna el respectivo rol
            $user->assignRole($role);
            //se manda el correo de validacion de cuenta
            $user->sendEmailVerificationNotification();
            
            $response = ['isValid'=>true, 'message' => 'User was created!'];
        }else{
            $response = ['isValid'=>false, 'message' => 'Something went wrong!'];
        }

        return response()->json($response);
    }

    public function updateUser(Request $request)
    {
        $id = $request->input('userId');

        //validacion email unico
        if($this->emailExists($request->input('data.email'), $id)){
            $response = ['isValid'=>false, 'message' => 'Email already in use!'];
            
            return response()->json($response);
        }

         //validacion num dui unico
         if($this->duiExists($request->input('data.dui'), $id)){
            $response = ['isValid'=>false, 'message' => 'DUI already in use!'];
            
            return response()->json($response);
        }


        //seleccionando registro segun id para modifircarlo
        $user = User::find($id);

        //asignando datos del request al objeto
        $user->first_name = $request->input('data.first_name');
        $user->last_name = $request->input('data.last_name');
        $user->email = $request->input('data.email');
        $user->dui = $request->input('data.dui');
        $role = $request->input('data.role');

        if($user->save()){
            $user->roles()->detach();
            $user->assignRole($role);

            $response = ['isValid'=>true, 'message' => 'User was updated!'];
        }else{
            $response = ['isValid'=>false, 'message' => 'Something went wrong!'];
        }
        return response()->json($response);
    }

    //funcion que valida si ya existe un email
    private function emailExists($email, $id = 0){
        //array de condicinoes
        $where = array();
        $where[] = ['email', '=', $email];

        //verifica si el origen del campo es la creacion o modificacion de un usuario
        if($id != 0){
            $where[] = ['id', '!=', $id];
        }

        if(User::where($where)->exists()){
            return true;
        }

        return false;
    }

    //funcion que valida si ya existe un dui
    private function duiExists($dui, $id = 0){
        //array de condicinoes
        $where = array();
        $where[] = ['dui', '=', $dui];

        //verifica si el origen del campo es la creacion o modificacion de un usuario
        if($id != 0){
            $where[] = ['id', '!=', $id];
        }
        if(User::where($where)->exists()){
            return true;
        }

        return false;
    }
}
