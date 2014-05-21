<?php
 
class Upload extends Controller
{
 
    public function __construct()
    {
        parent::__construct();
         
        // Loader
        $this->load->helper('url');
        $this->load->config('application');
    }
 
    public function index()
    {
        $this->load->view('index');
    }
 
    public function upload()
    {
        # Configuracion de la libreria
        # 'img_path' esta en /applications/config/pixmat.php
        $config['upload_path']      = $this->config->item('upload_path');
        $config['allowed_types']    = 'jpg|gif|png';
        $config['encrypt_name']     = 'TRUE';
        $config['max_size']             = '71680';
        $config['max_width']        = '8000';
        $config['max_height']       = '8000';
 
        $this->load->library('upload', $config);
 
        # Uploading
        if ( ! $this->upload->do_upload('Filedata')) {
            # Error
            $errors = $this->upload->display_errors();
 
            # nombre de la imagen, evitando errores
            $image_name = NULL;
        } else {
            # Nombre de la foto
            $imageData  = $this->upload->data();
            $image_name = $imageData['file_name'];
            $image_ext  = $imageData['file_ext'];
 
            # Achicamos la foto
            if( ! $this->resizePhoto($image_name)){
                $errors = "La imagen no pudo redimensionarse correctamente";
            } else {
                # Agregamos a la base de datos
                $data = array(
                    'title'         => 'Foto sin titulo',
                    'image'         =>   $image_name,
                    'active'            => 0
                );
 
                # ID recien creado, verificamos
                $id = $this->photos_model->create($data);
 
                if ( ! $id) {
                    $errors = "La imagen no pudo ingresarse a la DB";
                }
            }
        }
 
        // Error?
        if (isset($errors)){
            # Borramos la foto (si existe)
            $id = isset($id) ? $id : NULL;
            $this->deletePhoto($id, $image_name);
 
            echo $errors;
        }
    }
 
    private function resizePhoto($name)
    {
        # Load library
        $this->load->library('image_lib');
 
        // Achicamos a 1024x768
        $config['image_library']        = 'gd2';
        $config['source_image']     = $this->config->item('upload_path') . $name;
        $config['new_image']        = $this->config->item('upload_path') . '1024x768/' . $name;
        $config['maintain_ratio']       = TRUE;
        $config['width']            = 1024;
        $config['height']           = 768;
 
        $this->image_lib->initialize($config);
        if ( ! $this->image_lib->resize()){
            $error = TRUE;
        }
         
        /*
 
        // Le ponemos watermark, tenemos que utilizar otra configuracion, puesto que vamos a trabajar
        // con el thumbnail y vamos a ponerle watermark
        $config2['image_library']       = 'gd2';
        $config2['source_image']        = $this->config->item('upload_path') . '1024x768/' . $name;
        $config2['wm_type']         = 'overlay';
        $config2['wm_overlay_path']     = $this->config->item('watermark');
        $config2['wm_vrt_alignment']        = 'middle';
        $config2['wm_hor_alignment']    = 'center';
 
        # Watermark
        $this->image_lib->initialize($config2);
        if ( ! $this->image_lib->watermark()){
            $error = TRUE;
        }
         
        */
 
        // Achicamos a 800x600
        $config['source_image']     = $this->config->item('upload_path') . '1024x768/' . $name;
        $config['new_image']        = $this->config->item('upload_path') . '800x600/' . $name;
        $config['width']            = 800;
        $config['height']           = 600;
 
        $this->image_lib->initialize($config);
        if ( ! $this->image_lib->resize()){
            $error = TRUE;
        }
 
        // Achicamos a 400x300
        $config['source_image']     = $this->config->item('upload_path') . '1024x768/' . $name;
        $config['new_image']        = $this->config->item('upload_path') . '400x300/' . $name;
        $config['width']            = 400;
        $config['height']           = 300;
 
        $this->image_lib->initialize($config);
        if ( ! $this->image_lib->resize()){
            $error = TRUE;
        }
 
        # Error ?
        if (isset($error) and $error === TRUE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
 
    private function deletePhoto($id, $image)
    {
        # Delete from the DB
        if ($id !== NULL) {
            $this->photos_model->delete($id);
        }
 
        if ($image !== NULL) {
            # Borramos todas las imagenes (si existen). Evitamos warnings con el @ adelante
            @unlink($this->config->item("upload_path") . $image);
            @unlink($this->config->item('upload_path') . '1024x768/' . $image);
            @unlink($this->config->item('upload_path') . '800x600/' . $image);
            @unlink($this->config->item('upload_path') . '400x300/' . $image);
        }
    }
 
}