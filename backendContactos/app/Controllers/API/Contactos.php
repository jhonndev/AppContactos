<?php

namespace App\Controllers\API;

//use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ContactoModel;

//class Contactos extends BaseController
class Contactos extends ResourceController
{

    public function __construct()
    {
        $this->model = $this->setModel(new ContactoModel());
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $contactos = $this->model->findAll();
        return $this->respond($contactos);
    }

    public function create()
    {
        try {
            $nombre = $this->request->getVar('nombre');
            $apellidos = $this->request->getVar('apellidos');
            $telefono = $this->request->getVar('telefono');
            $correo = $this->request->getVar('correo');

            $rules = [
                'nombre' => 'required|alpha_space|min_length[2]',
                'apellidos' => 'permit_empty|alpha_space',
                'telefono' => 'required|numeric|min_length[10]|max_length[10]|is_unique[contactos.telefono]',
                'correo' => 'permit_empty|valid_email|is_unique[contactos.correo]',
            ];
        
            if (!$this->validate($rules)) {
                $errors = $this->validator->listErrors();
                return $this->failValidationError($errors);
            }
            
            $contacto = $this->request->getJSON();
            $this->model->insert($contacto);
            /*$contacto->id = $this->model->insertID();
            return $this->respondCreated($contacto);*/
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Contacto creado con exito'
                ]
            ];
            return $this->respondCreated($response);

        } catch(\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el Servidor');
        }
    }

    public function edit($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationError('No se ha pasado un ID valido');
            }

            $contacto = $this->model->find($id);
            if($contacto == null) {
                return $this->failNotFound('No se ha encontrado un contacto con el ID: ' . $id);
            }

            return $this->respond($contacto);
            
        } catch(\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el Servidor');
        }

    }

    public function update($id = null)
    {
        // EL ID DEBE SER ENVIADO CUANDO SE EDITE EL CONTACTO
        // SINO, EXISTE UN ERROR AL GUARDAR LA INFORMACION
        try {
            if ($id == null) {
                return $this->failValidationError('No se ha pasado un ID valido');
            }

            $verificarContacto = $this->model->find($id);
            if($verificarContacto == null) {
                return $this->failNotFound('No se ha encontrado un contacto con el ID: ' . $id);
            }

            $nombre = $this->request->getVar('nombre');
            $apellidos = $this->request->getVar('apellidos');
            $telefono = $this->request->getVar('telefono');
            $correo = $this->request->getVar('correo');

            $rules = [
                'nombre' => 'required|alpha_space|min_length[2]',
                'apellidos' => 'permit_empty|alpha_space',
                'telefono' => 'required|numeric|min_length[10]|max_length[10]|validarTelefonoUnico[{$this->request->getVar("telefono")}]',
                'correo' => 'permit_empty|valid_email|validarCorreoUnico[{$this->request->getVar("correo")}]',
            ];
            
        
            if (!$this->validate($rules)) {
                $errors = $this->validator->listErrors();
                return $this->failValidationError($errors);
            }
            
            
            $contacto = $this->request->getJSON();

            $this->model->update($id, $contacto);
            /*$contacto->id = $id;
            return $this->respondUpdated($contacto);*/

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Contacto actualizado con exito'
                ]
            ];

            return $this->respondUpdated($response);
            
        } catch(\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el Servidor');
        }
    }

    public function delete($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationError('No se ha pasado un ID valido');
            }

            $verificarContacto = $this->model->find($id);
            if($verificarContacto == null) {
                return $this->failNotFound('No se ha encontrado un contacto con el ID: ' . $id);
            }

            if($this->model->delete($id)) {
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Contacto eliminado con exito'
                    ]
                ];
    
                return $this->respondUpdated($response);
                //return $this->respondDeleted($verificarContacto);
            } else {
                return $this->failServerError('No se ha podido eliminar el contacto');
            }           
            
        } catch(\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el Servidor');
        }
    }





    // ================= Metodos antiguos =================

    /*public function index()
    {
        $model = new ContactoModel();
        $data['contactos'] = $model->orderBy('id','ASC')->findAll();
        $data['head'] = view('templates/head');
        $data['navbar'] = view('templates/navbar');
        $data['footer'] = view('templates/footer');
        $data['urlPath'] = base_url() . '' . 'uploads/';
        $data['urlImageDefault'] = base_url() . '' . 'staticImage/contact_default.jpg';

        //<?php var_dump($urlPath)

        return view('contactos/index', $data);
    }

    public function crear()
    {
        $data['head'] = view('templates/head');
        $data['navbar'] = view('templates/navbar');
        $data['footer'] = view('templates/footer');
        return view('contactos/create', $data);
    }

    public function guardar()
    {
        $nombre = $this->request->getPost('nombre');
        $apellidos = $this->request->getPost('apellidos');
        $telefono = $this->request->getPost('telefono');
        $correo = $this->request->getPost('correo');
        $foto = $this->request->getFile('foto');

        // Variables
        $nombreFoto = null;

        // Instancias
        $model = new ContactoModel();

        if(!$this->validate([
            'nombre' => 'required|alpha_space|min_length[1]',
            'apellidos' => 'permit_empty|alpha_space',
            'telefono' => 'required|numeric|min_length[10]|max_length[10]|is_unique[contactos.telefono]',
            'correo' => 'permit_empty|valid_email|is_unique[contactos.correo]',
            'foto' => 'max_size[foto,1024]|ext_in[foto,jpg]|mime_in[foto,image/jpeg,image/jpg]',
        ])){
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Asignar nombre a la imagen (Si se cargo)
        if ($foto->isValid()){
            $nombreRandom = $foto->getRandomName();
            $foto->move('../public/uploads/',$nombreRandom);
            $nombreFoto = $nombreRandom;
        }

        // Guardar Datos en la Base de Datos
        $data = [
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo' => $correo,
            'foto' => $nombreFoto
        ];

        if ($model->insert($data) === false) {
            return redirect()->back()->withInput()->with('errorCrear', 'Error al crear el contacto.');
        }

        return redirect()->to('/')->with('success', 'Contacto creado exitosamente.');
    }

    public function eliminar($id=null)
    {
        
        // Obtener la información del contacto por su ID
        $model = new ContactoModel();
        $contacto = $model->find($id);

        // Verificar si se encontró el contacto
        if (!$contacto) {
            return redirect()->to('/')->with('errorEliminar', 'El contacto no existe');
        }

        // Obtener la ruta de la foto
        $rutaFoto = '../public/uploads/' . $contacto['foto'];
        $rutaCompleta = realpath($rutaFoto);

        // Verificar si la foto existe y es accesible
        if ($rutaCompleta !== false && is_file($rutaCompleta)) {
            // Eliminar la foto
            unlink($rutaCompleta);
        }

        //Eliminar el contacto de la base de datos
        $model->where('id',$id)->delete($id);

        return redirect()->to('/')->with('success', 'Contacto eliminado exitosamente.');
    }

    public function editar($id = null)
    {
        $model = new ContactoModel();
        $data['contacto'] = $model->find($id);
        $data['head'] = view('templates/head');
        $data['navbar'] = view('templates/navbar');
        $data['footer'] = view('templates/footer');
        $data['urlPath'] = base_url() . '' . 'uploads/';
        $data['urlImageDefault'] = base_url() . '' . 'staticImage/contact_default.jpg';

        return view('contactos/edit', $data);
    }

    public function actualizar($id)
    {
        
        $nombre = $this->request->getPost('nombre');
        $apellidos = $this->request->getPost('apellidos');
        $telefono = $this->request->getPost('telefono');
        $correo = $this->request->getPost('correo');
        $foto = $this->request->getFile('foto'); 

        $model = new ContactoModel();

        $nombreFoto = null;

        if(!$this->validate([
            'nombre' => 'required||alpha_space|min_length[1]',
            'apellidos' => 'permit_empty|alpha_space',
            'telefono' => 'required|numeric|validarTelefonoUnico[{$this->request->getVar("telefono")}]',
            'correo' => 'permit_empty|valid_email|validarCorreoUnico[{$this->request->getVar("correo")}]',
            'foto' => 'uploaded[foto]|max_size[foto,1024]|ext_in[foto,jpg]|mime_in[foto,image/jpeg,image/jpg]',
        ])){
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Asignar nombre a la imagen (Si se cargo)
        if ($foto->isValid()){
            $obtenerImagen = $model->find($id);

            // Verificar si la foto existe y es accesible - Para elimnarla
            $rutaFoto = '../public/uploads/' . $obtenerImagen['foto'];
            $rutaCompleta = realpath($rutaFoto);
            if ($rutaCompleta !== false && is_file($rutaCompleta)) {
                unlink($rutaCompleta);
            }

            //Asignamos nombre a la imagen nueva
            $nombreRandom = $foto->getRandomName();
            $foto->move('../public/uploads/',$nombreRandom);
            $data=['foto' => $nombreRandom];
            $nombreFoto = $nombreRandom;
        }

        $data = [
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo' => $correo,
            'foto' => $nombreFoto
        ];


        if ($model->update($id, $data) === false) {
            return redirect()->back()->withInput()->with('errorEditar', 'Error al actualizar el contacto.');
        }

        return redirect()->to('/')->with('success', 'Contacto actualizado exitosamente.');
    }*/
}
